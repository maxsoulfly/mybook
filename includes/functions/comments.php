<?php

function fetchLatestComment(PDO $pdo, int $postId)
{
    $stmt = $pdo->prepare(
        "SELECT c.*, u.username, u.first_name, u.last_name, u.avatar
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.post_id = :post_id
            ORDER BY c.created_at DESC
            LIMIT 1
    "
    );

    $stmt->execute(['post_id' => $postId]);
    $latestComment = $stmt->fetch(PDO::FETCH_ASSOC);
    return $latestComment ?: null;
}
