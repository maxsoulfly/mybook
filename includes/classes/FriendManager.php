<?php

class FriendManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function areFriends(int $userId, int $friendId): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT 1 FROM friends 
             WHERE (
                 (user_id = :user AND friend_id = :friend) 
                 OR (user_id = :friend AND friend_id = :user)
             )
             AND status = 'accepted'"
        );
        $stmt->execute([
            'user' => $userId,
            'friend' => $friendId
        ]);
        return (bool) $stmt->fetch();
    }

    public function getFriendStatus(int $userId, int $profileId): string
    {
        $stmt = $this->pdo->prepare(
            "SELECT user_id, friend_id, status FROM friends 
             WHERE 
                 (user_id = :user AND friend_id = :profile)
              OR (user_id = :profile AND friend_id = :user)"
        );
        $stmt->execute(['user' => $userId, 'profile' => $profileId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return 'none';

        if ($row['status'] === 'accepted') return 'accepted';

        if ($row['status'] === 'pending') {
            if ((int)$row['user_id'] === $userId) {
                return 'pending_sent';
            } else {
                return 'pending_received';
            }
        }

        if ($row['status'] === 'stalker') {
            if ($row['user_id'] == $_SESSION['user_id']) {
                return 'stalker';
            } else {
                return 'followed_by';
            }
        }

        return 'none';
    }

    public function getFriends(int $profileId): array
    {
        $stmt = $this->pdo->prepare(
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
}
