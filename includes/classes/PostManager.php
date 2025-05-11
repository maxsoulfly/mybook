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
            'SELECT posts.*, users.display_name, users.username, users.avatar
             FROM posts
             JOIN users ON posts.user_id = users.id
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
