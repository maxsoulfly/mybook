<?php include_once __DIR__ . '/../functions.php'; ?>

<?php
$pdo = getDBConnection();
$profileId = $profile['id'];


$stmt = $pdo->prepare(
    'SELECT posts.*, users.first_name, users.last_name, users.username, users.avatar
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE recipient_id = :id OR (recipient_id IS NULL AND user_id = :id)
            ORDER BY created_at DESC
'
);
$stmt->execute(['id' => $profileId]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {

    $fullname = $post['first_name'] . ' ' . $post['last_name'];
    $username = $post['username'];
    $avatar = $post['avatar'];
    $createdAt = $post['created_at'];
    $content = $post['content'];

    $latestComment = fetchLatestComment($pdo, $post['id']);

    renderPost($fullname, $username, $avatar, $createdAt, $content, $latestComment);
}
?>
</div>