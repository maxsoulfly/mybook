<?php

include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
include_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

$pdo = getDBConnection();
$FriendManager = new FriendManager($pdo);

// Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['friend_id'])) {
    die('Invalid request');
}

$userId = $_SESSION['user_id'];
$friendId = (int) $_POST['friend_id'];


$FriendManager->validateFriendRequest($userId, $friendId);
$FriendManager->cancelFriendRequest($userId, $friendId);

$finalUrl = redirectBackWithParam('request', 'cancelled');
header('Location: ' . $finalUrl);
exit;
