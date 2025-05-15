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
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

if (!$user_id) {
    die('no user_id');
}

// Check if the user already liked the post
$existingLike = $postManager->existingLike($post_id, $user_id);

try {
    if ($existingLike) {
        $action = 'unlike';

        $stmt = $pdo->prepare('DELETE FROM likes WHERE id = :like_id');
        $stmt->execute(['like_id' => $existingLike['id']]);
    } else {
        $action = 'like';

        $stmt = $pdo->prepare(
            'INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)'
        );
        $stmt->execute([
            'post_id' => $post_id,
            'user_id' => $user_id,
        ]);
    }
    $finalUrl = redirectBackWithParam($action, 'success');
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam($action ?? 'like', 'failed');
}

header('Location: ' . $finalUrl);
exit;
