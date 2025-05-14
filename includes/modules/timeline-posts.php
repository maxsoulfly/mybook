<?php include_once __DIR__ . '/../functions.php'; ?>

<?php
$pdo = getDBConnection();
$profileId = $profile['id'];

$stmt = $pdo->prepare(
    'SELECT posts.*, users.display_name, users.username, users.avatar
     FROM posts
     JOIN users ON posts.user_id = users.id
     LEFT JOIN friends ON (
        (friends.user_id = :id AND friends.friend_id = users.id) OR 
        (friends.friend_id = :id AND friends.user_id = users.id)
     )
     WHERE 
        posts.recipient_id = :id 
        OR (posts.recipient_id IS NULL AND posts.user_id = :id)
        OR (friends.status IN (\'pending\', \'accepted\', \'stalker\'))
     ORDER BY posts.created_at DESC'
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
    $postRenderer->render(showReplies: false, mode: "timeline");
}
?>
