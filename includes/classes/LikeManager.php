<?php

class LikeManager
{
    public function handleLikeAction($postManager, $pdo, $user_id, $post_id = null, $comment_id = null)
    {
        $notification = new NotificationsManager();
        $existingLike = $postManager->existingLike($user_id, $post_id, $comment_id);
        $actionType = $existingLike ? 'unlike' : 'like';

        if ($existingLike) {
            $this->deleteLike($pdo, $existingLike['id']);
        } else {
            $this->insertLike($pdo, $user_id, $post_id, $comment_id);
            $notification->notifyLike($pdo, $user_id, $post_id, $comment_id);
        }

        $action = ($post_id ? 'post' : 'comment') . " {$actionType}";
        return redirectBackWithParam($action, 'success');
    }

    public function insertLike($pdo, $user_id, $post_id = null, $comment_id = null)
    {
        if ($comment_id) {
            $stmt = $pdo->prepare('INSERT INTO likes (comment_id, user_id) VALUES (:comment_id, :user_id)');
            $stmt->execute(['comment_id' => $comment_id, 'user_id' => $user_id]);
        } elseif ($post_id) {
            $stmt = $pdo->prepare('INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)');
            $stmt->execute(['post_id' => $post_id, 'user_id' => $user_id]);
        }

        error_log("Like successfully inserted - User: {$user_id}, Post: {$post_id}, Comment: {$comment_id}");
    }

    private function deleteLike($pdo, $like_id)
    {
        $stmt = $pdo->prepare('DELETE FROM likes WHERE id = :like_id');
        $stmt->execute(['like_id' => $like_id]);
        error_log("Like successfully removed - ID: {$like_id}");
    }
}
