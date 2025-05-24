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

    public function notifyLike(PDO $pdo, int $likerId, ?int $postId = null, ?int $commentId = null): void
    {
        $userManager = new UserManager($pdo);
        $postManager = new PostManager($pdo);
        $actor = $userManager->getUserByUserId($likerId);

        if ($postId) {
            $post = $postManager->fetchPost($postId);
            if ($post && $post['user_id'] !== $likerId) {
                $content = $actor['display_name'] . ' liked your post.';
                $baseLink  = '/pages/post.php?id=' . $postId;
                $this->add($pdo, $post['user_id'], $content, $baseLink,  $likerId);
            }
        } elseif ($commentId) {
            $comment = $postManager->getCommentById($commentId);
            if ($comment && $comment['user_id'] !== $likerId) {
                $content = $actor['display_name'] . ' liked your comment.';
                $baseLink  = '/pages/post.php?id=' . $comment['post_id'];
                $this->add($pdo, $comment['user_id'], $content, $baseLink, $likerId);
            }
        }
    }

    public function notifyComment(PDO $pdo, int $likerId, ?int $postId = null, ?int $commentId = null): void
    {
        $userManager = new UserManager($pdo);
        $postManager = new PostManager($pdo);
        $actor = $userManager->getUserByUserId($likerId);

        if ($postId) {
            $post = $postManager->fetchPost($postId);
            if ($post && $post['user_id'] !== $likerId) {
                $content = $actor['display_name'] . ' commented on your post.';
                $baseLink  = '/pages/post.php?id=' . $postId;
                $this->add($pdo, $post['user_id'], $content, $baseLink,  $likerId);
            }
        } elseif ($commentId) {
            $comment = $postManager->getCommentById($commentId);
            if ($comment && $comment['user_id'] !== $likerId) {
                $content = $actor['display_name'] . ' replied to your comment.';
                $baseLink  = '/pages/post.php?id=' . $comment['post_id'];
                $this->add($pdo, $comment['user_id'], $content, $baseLink, $likerId);
            }
        }
    }
}
