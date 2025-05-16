<?php

class PostManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchPost($post_id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT 
            posts.*, 
            users.display_name, 
            users.username, 
            users.avatar,
            recipient.display_name AS recipient_name,
            recipient.username AS recipient_username
         FROM posts
         JOIN users ON posts.user_id = users.id
         LEFT JOIN users AS recipient ON posts.recipient_id = recipient.id
         WHERE posts.id = :post_id
         LIMIT 1'
        );
        $stmt->execute(['post_id' => $post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function fetchComments($post_id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.*, users.display_name, users.username, users.avatar 
             FROM comments AS c
             JOIN users ON c.user_id = users.id 
             WHERE c.post_id = :post_id 
                   AND c.parent_id IS NULL
             ORDER BY c.created_at ASC'
        );
        $stmt->execute(['post_id' => $post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countComments($post_id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) AS comment_count 
             FROM comments 
             WHERE post_id = :post_id'
        );
        $stmt->execute(['post_id' => $post_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['comment_count'] ?? 0;
    }

    public function countLikes($post_id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) AS like_count FROM likes WHERE post_id = :post_id'
        );
        $stmt->execute(['post_id' => $post_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['like_count'] ?? 0;
    }
    public function countCommentLikes($comment_id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) AS comment_likes 
                    FROM likes 
                    WHERE comment_id = :comment_id;'
        );
        $stmt->execute(['comment_id' => $comment_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['comment_likes'] ?? 0;
    }

    public function existingLike($user_id, $post_id = null, $comment_id = null)
    {
        if ($comment_id) {
            $query = 'SELECT id FROM likes WHERE comment_id = :comment_id AND user_id = :user_id';
            $params = ['comment_id' => $comment_id, 'user_id' => $user_id];
        } elseif ($post_id) {
            $query = 'SELECT id FROM likes WHERE post_id = :post_id AND user_id = :user_id';
            $params = ['post_id' => $post_id, 'user_id' => $user_id];
        } else {
            throw new InvalidArgumentException('Either post_id or comment_id must be provided.');
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function fetchReplies($parent_id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.*, users.display_name, users.username, users.avatar 
             FROM comments AS c
             JOIN users ON c.user_id = users.id 
             WHERE parent_id = :parent_id
             ORDER BY created_at ASC'
        );
        $stmt->execute(['parent_id' => $parent_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchRecentComments(PDO $pdo, int $postId, int $numComments)
    {
        $stmt = $pdo->prepare(
            "SELECT c.*, u.username, u.display_name, u.avatar
                    FROM comments c
                    JOIN users u ON c.user_id = u.id
                    WHERE c.post_id = :post_id
                        AND c.parent_id IS NULL
                    ORDER BY c.created_at DESC
                    LIMIT :numComments
            "
        );

        $stmt->execute(['post_id' => $postId, 'numComments' => $numComments]);
        $latestComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $latestComments ?: null;
    }

    public function fetchLatestComment(PDO $pdo, int $postId)
    {
        $stmt = $pdo->prepare(
            "SELECT c.*, u.username, u.display_name, u.avatar
                    FROM comments c
                    JOIN users u ON c.user_id = u.id
                    WHERE c.post_id = :post_id
                        AND c.parent_id IS NULL
                    ORDER BY c.created_at DESC
                    LIMIT 1
            "
        );

        $stmt->execute(['post_id' => $postId]);
        $latestComment = $stmt->fetch(PDO::FETCH_ASSOC);
        return $latestComment ?: null;
    }
}
