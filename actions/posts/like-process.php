<?php
error_log("Like process triggered - POST Data: " . json_encode($_POST));

include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/db.php';

$pdo = getDBConnection();
$postManager = new PostManager($pdo);

// Validate POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
}

// Sanitize input
$post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
$comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

if (!$user_id) {
    die('User ID is required.');
}

// Determine Like/Unlike Action
$finalUrl = 'index.php'; // Default URL

try {
    if ($post_id || $comment_id) {
        $finalUrl = handleLikeAction($postManager, $pdo, $user_id, $post_id, $comment_id);
    } else {
        die('Invalid input.');
    }
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $finalUrl = redirectBackWithParam('like', 'failed');
}

// Redirect user
header("Location: {$finalUrl}");
exit;

/**
 * Handles the like/unlike action for posts or comments.
 *
 * @param PostManager $postManager
 * @param PDO $pdo
 * @param int $user_id
 * @param int|null $post_id
 * @param int|null $comment_id
 * @return string
 */
function handleLikeAction($postManager, $pdo, $user_id, $post_id = null, $comment_id = null)
{
    $existingLike = $postManager->existingLike($user_id, $post_id, $comment_id);
    $actionType = $existingLike ? 'unlike' : 'like';

    if ($existingLike) {
        deleteLike($pdo, $existingLike['id']);
    } else {
        insertLike($pdo, $user_id, $post_id, $comment_id);
    }

    $action = ($post_id ? 'post' : 'comment') . " {$actionType}";
    return redirectBackWithParam($action, 'success');
}

/**
 * Inserts a like (post or comment) into the database.
 */
function insertLike($pdo, $user_id, $post_id = null, $comment_id = null)
{
    if ($comment_id) {
        $stmt = $pdo->prepare('INSERT INTO likes (comment_id, user_id) VALUES (:comment_id, :user_id)');
        $stmt->execute(['comment_id' => $comment_id, 'user_id' => $user_id]);
    } elseif ($post_id) {
        $stmt = $pdo->prepare('INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)');
        $stmt->execute(['post_id' => $post_id, 'user_id' => $user_id]);
    }

    error_log("Like successfully inserted - User: {$user_id}, Post: {$post_id}, Comment: {$comment_id}");
}

/**
 * Deletes an existing like from the database.
 */
function deleteLike($pdo, $like_id)
{
    $stmt = $pdo->prepare('DELETE FROM likes WHERE id = :like_id');
    $stmt->execute(['like_id' => $like_id]);
    error_log("Like successfully removed - ID: {$like_id}");
}
