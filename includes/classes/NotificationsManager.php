<?php

class NotificationsManager
{

    public  function getUnreadByUser(PDO $pdo, int $user_id): ?array
    {
        $stmt = $pdo->prepare(
            "SELECT * 
                    FROM notifications 
                    WHERE user_id = :user_id
                    AND is_read = 0 
                    ORDER BY created_at DESC"
        );
        $stmt->execute(['user_id' => $user_id]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notifications ?: null;
    }
    public  function getReadByUser(PDO $pdo, int $user_id): ?array
    {
        $stmt = $pdo->prepare(
            "SELECT * 
                    FROM notifications 
                    WHERE user_id = :user_id
                    AND is_read = 1 
                    ORDER BY created_at DESC"
        );
        $stmt->execute(['user_id' => $user_id]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notifications ?: null;
    }

    public  function getAllByUser(PDO $pdo, int $user_id): ?array
    {
        $stmt = $pdo->prepare(
            "SELECT * 
                    FROM notifications 
                    WHERE user_id = :user_id
                    ORDER BY created_at DESC"
        );
        $stmt->execute(['user_id' => $user_id]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notifications ?: null;
    }
    public function markAllRead(PDO $pdo, int $user_id): void
    {
        $stmt = $pdo->prepare(
            "UPDATE notifications 
                    SET is_read = 1 
                    WHERE user_id = :user_id 
                    AND is_read = 0"
        );
        $stmt->execute(['user_id' => $user_id]);
    }
    public function markRead(PDO $pdo, int $user_id, $notificationId): void
    {
        $stmt = $pdo->prepare(
            "UPDATE notifications 
                    SET is_read = 1 
                    WHERE id = :id 
                    AND user_id = :user_id"
        );
        $stmt->execute(['id' => $notificationId, 'user_id' => $user_id]);
    }

    public function add(PDO $pdo, int $user_id, string $content, string $link, ?int $actorId = null): void
    {
        $stmt = $pdo->prepare(
            "INSERT INTO notifications (user_id, actor_id, content, link) 
                    VALUES (:user_id, :actor_id, :content, :link)"
        );
        $stmt->execute([
            'user_id' => $user_id,
            'actor_id' => $actorId,
            'content' => $content,
        ]);

        $notificationId = (int) $pdo->lastInsertId();

        if (!empty($link)) {
            $update = $pdo->prepare("UPDATE notifications SET link = :link WHERE id = :id");
            $update->execute([
                'link' => $link . '&notification_id=' . $notificationId,
                'id' => $notificationId
            ]);
        }
    }
    private function getActorDisplayName(PDO $pdo, int $actorId): ?string
    {
        $userManager = new UserManager($pdo);
        $actor = $userManager->getUserByUserId($actorId);
        return $actor['display_name'] ?? null;
    }

    private function dispatchActionNotification(
        PDO $pdo,
        int $actorId,
        string $actionType,
        ?int $postId = null,
        ?int $commentId = null
    ): void {
        $postManager = new PostManager($pdo);
        $displayName = $this->getActorDisplayName($pdo, $actorId);
        if (!$displayName) return;

        if ($postId) {
            $post = $postManager->fetchPost($postId);

            // Handle 'post' notifications (user posted on someone’s wall)
            if ($actionType === 'post') {
                if ($post && $post['recipient_id'] !== $actorId) {
                    $content = "$displayName posted on your wall.";
                    $baseLink = '/pages/post.php?id=' . $postId;
                    $this->add($pdo, $post['recipient_id'], $content, $baseLink, $actorId);
                }
            }

            // Handle like/comment on a post (notify the post author)
            elseif (in_array($actionType, ['like', 'comment'])) {
                if ($post && $post['user_id'] !== $actorId) {
                    $content = match ($actionType) {
                        'like' => "$displayName liked your post.",
                        'comment' => "$displayName commented on your post.",
                        default => null
                    };
                    if ($content) {
                        $baseLink = '/pages/post.php?id=' . $postId;
                        $this->add($pdo, $post['user_id'], $content, $baseLink, $actorId);
                    }
                }
            }
        } elseif ($commentId) {
            $comment = $postManager->getCommentById($commentId);
            if ($comment && $comment['user_id'] !== $actorId) {
                $content = match ($actionType) {
                    'like' => "$displayName liked your comment.",
                    'comment' => "$displayName replied to your comment.",
                    default => null
                };
                if ($content) {
                    $baseLink = '/pages/post.php?id=' . $comment['post_id'];
                    $this->add($pdo, $comment['user_id'], $content, $baseLink, $actorId);
                }
            }
        }
    }

    public function notifyLike(PDO $pdo, int $likerId, ?int $postId = null, ?int $commentId = null): void
    {
        $this->dispatchActionNotification($pdo, $likerId, 'like', $postId, $commentId);
    }

    public function notifyComment(PDO $pdo, int $commenterId, ?int $postId = null, ?int $commentId = null): void
    {
        $this->dispatchActionNotification($pdo, $commenterId, 'comment', $postId, $commentId);
    }

    public function notifyPost(PDO $pdo, int $posterId, int $postId): void
    {
        $this->dispatchActionNotification($pdo, $posterId, 'post', $postId, null);
    }

    public function notifyFriendRequest(PDO $pdo, int $senderId, int $recipientId): void
    {
        if ($senderId === $recipientId) return; // Safety check

        $UserManager = new UserManager($pdo);

        $user = $UserManager->getUserByUserId($recipientId);
        $displayName = $this->getActorDisplayName($pdo, $senderId);
        if (!$displayName) return;

        $content = "$displayName sent you a friend request.";
        $link = "/pages/friends.php?u=" . $user['username']; // or your confirmation page

        $this->add($pdo, $recipientId, $content, $link, $senderId);
    }

    public function notifyFriendAccept(PDO $pdo, int $senderId, int $recipientId): void
    {
        if ($senderId === $recipientId) return; // Safety check

        $UserManager = new UserManager($pdo);

        $user = $UserManager->getUserByUserId($senderId);
        $displayName = $this->getActorDisplayName($pdo, $recipientId);
        if (!$displayName) return;

        $content = "You are now friends with $displayName";
        $link = "/pages/profile.php?u=" . $user['username']; // or your confirmation page

        $this->add($pdo, $recipientId, $content, $link, $senderId);
    }
}
