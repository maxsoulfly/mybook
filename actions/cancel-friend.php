<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

const FRIEND_STATUS = [
    'PENDING' => 'pending',
    'ACCEPTED' => 'accepted',
    'BLOCKED' => 'blocked',
    'STALKER'=> 'stalker',
    'UNFRIENDED'=> 'unfriended',
];
// Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['friend_id'])) {
    die('Invalid request');
}

$userId = $_SESSION['user_id'];
$friendId = (int) $_POST['friend_id'];

// Optional: prevent self-action
if ($userId === $friendId) {
    die('You cannot perform this action on yourself.');
}

// Delete where *you* initiated the relationship
$stmt = $pdo->prepare("DELETE FROM friends WHERE user_id = :user AND friend_id = :friend");
$stmt->execute(['user' => $userId, 'friend' => $friendId]);

// Redirect back
$referer = $_SERVER['HTTP_REFERER'];
$separator = str_contains($referer, '?') ? '&' : '?';
header('Location: ' . $referer . $separator . 'request=cancelled');
exit;
