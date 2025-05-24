<?php


include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
include_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';
$pdo = getDBConnection();

$FriendManager = new FriendManager($pdo);


// Validate the request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['friend_id'])) {
    die('Invalid request');
}

$userId = $_SESSION['user_id'];
$friendId  = (int) $_POST['friend_id'];


$FriendManager->validateFriendRequest($userId, $friendId);

if ($FriendManager->areAlreadyFriends($userId, $friendId)) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$FriendManager->acceptFriendRequest($userId, $friendId);

$NotificationsManager = new NotificationsManager();
$NotificationsManager->notifyFriendAccept($pdo, $friendId, $userId);
$NotificationsManager->notifyFriendAccept($pdo, $userId, $friendId);

$finalUrl = redirectBackWithParam('request', 'accepted');
header('Location: ' . $finalUrl);
exit;
