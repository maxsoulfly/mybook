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

// Make sure user isn’t adding themselves
if ($userId == $friendId) {
    die('You cannot add yourself as a friend.');
}

$FriendManager->handleDenyFriendRequest($userId, $friendId);


$finalUrl = redirectBackWithParam('request', 'denied');
header('Location: ' . $finalUrl);
exit;
