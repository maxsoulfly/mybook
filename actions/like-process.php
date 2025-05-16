<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$pdo = getDBConnection();
$postManager = new PostManager($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
}

$errorMsg = validateFields($_POST);
if ($errorMsg !== '') {
    die($errorMsg);
}

$post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
$comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

if (!$user_id) {
    die('no user_id');
}

try {
    if ($post_id) {
        $finalUrl = handleLikeAction($postManager, $pdo, $user_id, $post_id, null);
    } elseif ($comment_id) {
        $finalUrl = handleLikeAction($postManager, $pdo, $user_id, null, $comment_id);
    } else {
        die('Invalid input.');
    }
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam('like', 'failed');
}

header('Location: ' . $finalUrl);
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
    $action = $existingLike ? 'unlike' : 'like';

    if ($existingLike) {
        $stmt = $pdo->prepare('DELETE FROM likes WHERE id = :like_id');
        $stmt->execute(['like_id' => $existingLike['id']]);
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO likes (' . ($post_id ? 'post_id' : 'comment_id') . ', user_id) VALUES (:id, :user_id)'
        );
        $stmt->execute([
            'id' => $post_id ?? $comment_id,
            'user_id' => $user_id,
        ]);
    }

    return redirectBackWithParam($action, 'success');
}
