<?php

include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/db.php';
$pdo = getDBConnection();
$postManager = new PostManager($pdo);
$notification = new NotificationsManager();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
}

$errorMsg = validateFields($_POST);
if ($errorMsg !== '') {
    die($errorMsg);
}

$post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
$parent_id = filter_input(INPUT_POST, 'parent_id', FILTER_SANITIZE_NUMBER_INT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$content = trim($_POST['content']);

try {
    $comment_id = $postManager->insertComment($pdo, $post_id, $parent_id, $user_id, $content);
    $notification->notifyComment($pdo, $user_id, $post_id, $comment_id);


    $finalUrl = redirectBackWithParam('comment', 'success');
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam('comment', 'failed');
}

header('Location: ' . $finalUrl);
exit;
