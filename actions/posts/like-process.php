<?php

include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/db.php';

$pdo = getDBConnection();
$postManager = new PostManager($pdo);
$LikeManager = new LikeManager();
$NotificationsManager = new NotificationsManager();

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
        $finalUrl = $LikeManager->handleLikeAction($postManager, $pdo, $user_id, $post_id, $comment_id);
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
