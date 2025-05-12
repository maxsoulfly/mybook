<?php include_once __DIR__ . '/../functions.php'; ?>

<?php
$pdo = getDBConnection();
$profileId = $profile['id'];


$stmt = $pdo->prepare(
    'SELECT posts.*, users.display_name, users.username, users.avatar
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE recipient_id = :id OR (recipient_id IS NULL AND user_id = :id)
            ORDER BY created_at DESC
'
);
$stmt->execute(['id' => $profileId]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    // Initialize PostManager
    $postManager = new PostManager($pdo);

    // Fetch the latest comment for this post
    $latestComments = $postManager->fetchRecentComments($pdo, $post['id'], numComments: 2);

    // Create an instance of PostRenderer
    $postRenderer = new PostRenderer(
        $post['id'],
        $post['display_name'],
        $post['username'],
        $post['avatar'],
        $post['created_at'],
        $post['content'],
        $BASE_URL,
        $latestComments
    );

    // Render the post
    $postRenderer->render();
}
?>
