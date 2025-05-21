<?php

class FriendManager
{
    private PDO $pdo;
    private const FRIEND_STATUS = [
        'PENDING' => 'pending',
        'ACCEPTED' => 'accepted',
        'BLOCKED' => 'blocked',
        'STALKER' => 'stalker',
        'UNFRIENDED' => 'unfriended',
    ];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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

    public function getPendingFriendRequests(int $profileId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT 
                users.username, 
                users.id AS user_id, 
                users.display_name, 
                users.avatar
             FROM friends
             JOIN users
                ON users.id = friends.user_id
             WHERE friends.status = "pending"
                AND friends.friend_id = :id'
        );
        $stmt->execute(['id' => $profileId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFriendsCount(int $profileId): int
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) AS count
         FROM friends
         JOIN users 
           ON (users.id = friends.friend_id AND friends.user_id = :id)
           OR (users.id = friends.user_id AND friends.friend_id = :id)
         WHERE friends.status = "accepted"'
        );
        $stmt->execute(['id' => $profileId]);
        return (int) $stmt->fetchColumn();
    }

    public function validateFriendRequest(int $userId, int $friendId): void
    {
        if ($userId === $friendId) {
            throw new Exception('You cannot add yourself as a friend.');
        }
    }

    public function areAlreadyFriends(int $userId, int $friendId): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT status FROM friends 
                WHERE (user_id = :user AND friend_id = :friend)
                OR (user_id = :friend AND friend_id = :user)
    "
        );
        $stmt->execute(['user' => $userId, 'friend' => $friendId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['status'] === self::FRIEND_STATUS['ACCEPTED'];
    }

    public function acceptFriendRequest(int $userId, int $friendId): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE friends
                    SET status = :status
                    WHERE user_id = :friend AND friend_id = :user AND status = :pending
            "
        );
        $stmt->execute([
            'status'  => self::FRIEND_STATUS['ACCEPTED'],
            'friend'  => $friendId,
            'user'    => $userId,
            'pending' => self::FRIEND_STATUS['PENDING']
        ]);
    }

    public function sendFriendRequest(int $userId, int $friendId)
    {
        $stmt = $this->pdo->prepare('INSERT INTO friends (user_id, friend_id, status) 
                                VALUES (:user, :friend, :status)');
        $stmt->execute(
            [
                'user' => $userId,
                'friend' => $friendId,
                'status' => self::FRIEND_STATUS['PENDING']
            ]
        );
    }

    public function cancelFriendRequest(int $userId, int $friendId)
    {
        // Delete where *you* initiated the relationship
        $stmt = $this->pdo->prepare("DELETE FROM friends WHERE user_id = :user AND friend_id = :friend");
        $stmt->execute(['user' => $userId, 'friend' => $friendId]);
    }
}
