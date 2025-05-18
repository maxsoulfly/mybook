<?php

function areFriends(PDO $pdo, int $userId, int $friendId): bool
{
    $stmt = $pdo->prepare("  SELECT 1 FROM friends 
                                    WHERE 
                                    (
                                        (user_id = :user AND friend_id = :friend) 
                                        OR (user_id = :friend AND friend_id = :user)
                                    )
                                    AND status = 'accepted')");
    $stmt->execute([
        'user' => $userId,
        'friend' => $friendId
    ]);
    return (bool) $stmt->fetch();
}

function getFriendStatus(PDO $pdo, int $userId, int $profileId): string
{
    $stmt = $pdo->prepare("
        SELECT user_id, friend_id, status FROM friends 
        WHERE 
            (user_id = :user AND friend_id = :profile)
         OR (user_id = :profile AND friend_id = :user)
    ");
    $stmt->execute(['user' => $userId, 'profile' => $profileId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return 'none';

    if ($row['status'] === 'accepted') return 'accepted';

    if ($row['status'] === 'pending') {
        if ((int)$row['user_id'] === $userId) {
            return 'pending_sent';     // we sent the request
        } else {
            return 'pending_received'; // they sent it to us
        }
    }

    if ($row['status'] === 'stalker') {
        if ($row['user_id'] == $_SESSION['user_id']) {
            return 'stalker'; // I’m the stalker
        } else {
            return 'followed_by'; // You denied them, they follow you
        }
    }

    return 'none'; // fallback
}
function getFriends($pdo, $profileId)
{
    $stmt = $pdo->prepare(
        'SELECT 
            users.username, 
            users.id AS user_id, 
            users.display_name, 
            users.avatar
         FROM friends
         JOIN users 
           ON (users.id = friends.friend_id AND friends.user_id = :id)
           OR (users.id = friends.user_id AND friends.friend_id = :id)
         WHERE friends.status = "accepted"'
    );
    $stmt->execute(['id' => $profileId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
