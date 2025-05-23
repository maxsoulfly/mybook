<?php

include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/db.php';
$pdo = getDBConnection();
$postManager = new PostManager($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
}
$errorMsg = validateFields($_POST);
if ($errorMsg !== '') {
    die($errorMsg);
}

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$content = trim($_POST['content']);


$recipient_id = filter_input(INPUT_POST, 'recipient_id', FILTER_SANITIZE_NUMBER_INT) ?? NULL;

try {
    $newPostId = $postManager->insertPost($pdo, $user_id, $content, $recipient_id);

    $NotificationsManager = new NotificationsManager();
    $NotificationsManager->notifyPost($pdo, $user_id, $newPostId);

    $finalUrl = redirectBackWithParam('post', 'success');
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam('post', 'failed');
}
header('Location: ' . $finalUrl);
exit;
