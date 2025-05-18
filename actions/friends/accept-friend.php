<?php


include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
include_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';
$pdo = getDBConnection();

const FRIEND_STATUS = [
    'PENDING' => 'pending',
    'ACCEPTED' => 'accepted',
    'BLOCKED' => 'blocked',
    'STALKER' => 'stalker',
    'UNFRIENDED' => 'unfriended',
];


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

// Check if they are already friends (not just a pending request)
$stmt = $pdo->prepare("SELECT status FROM friends 
    WHERE (user_id = :user AND friend_id = :friend)
       OR (user_id = :friend AND friend_id = :user)");
$stmt->execute(['user' => $userId, 'friend' => $friendId]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && $row['status'] === FRIEND_STATUS['ACCEPTED']) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Send a friend request
$stmt = $pdo->prepare("UPDATE friends
    SET status = :status
    WHERE user_id = :friend AND friend_id = :user AND status = :pending");

$stmt->execute([
    'status' => FRIEND_STATUS['ACCEPTED'],
    'friend' => $friendId,
    'user'   => $userId,
    'pending' => FRIEND_STATUS['PENDING']
]);

$finalUrl = redirectBackWithParam('request', 'accepted');
header('Location: ' . $finalUrl);
exit;
