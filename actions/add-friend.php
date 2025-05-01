<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['friend_id'])) {
    die('Invalid request');
}

$userId = $_SESSION['user_id'];
$friendId  = (int) $_POST['friend_id'];

if ($userId == $friendId){
    die('You cannot add yourself as a friend.');
}

$stmt = $pdo->prepare("  SELECT 1 FROM friends 
                                WHERE (user_id = :user AND friend_id = :friend)
                                OR (user_id = :friend AND friend_id = :user)");
$stmt->execute(['user' => $userId,'friend'=> $friendId]);
if ($stmt->fetch()) {
    // already friends — redirect back
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>