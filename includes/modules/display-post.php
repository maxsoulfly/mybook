<?php include_once __DIR__ . '/../functions.php'; ?>

<?php
$pdo = getDBConnection();

// Fetch the post
$stmt = $pdo->prepare(
    'SELECT posts.*, users.display_name, users.username, users.avatar
     FROM posts
     JOIN users ON posts.user_id = users.id
     WHERE posts.id = :post_id
     LIMIT 1'
);
$stmt->execute(['post_id' => $post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// If post not found, display an error
if (!$post) {
    die('Post not found.');
}

// Fetch all comments for the post
$commentsStmt = $pdo->prepare(
    'SELECT comments.*, users.display_name, users.username, users.avatar 
     FROM comments 
     JOIN users ON comments.user_id = users.id 
     WHERE comments.post_id = :post_id 
     ORDER BY comments.created_at ASC'
);
$commentsStmt->execute(['post_id' => $post_id]);
$comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

// Create an instance of PostRenderer
$postRenderer = new PostRenderer(
    $post['id'],
    $post['display_name'],
    $post['username'],
    $post['avatar'],
    $post['created_at'],
    $post['content'],
    $BASE_URL,
    null, // No need for latestComment anymore
    $comments // All comments passed here
);

// Render the post
$postRenderer->render();
