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

    // Create an instance of PostRenderer
    $postRenderer = new PostRenderer(
        $post['id'],
        $pdo
    );

    // Render the post
    $postRenderer->render(showReplies: false, mode: "profile");
}
?>
