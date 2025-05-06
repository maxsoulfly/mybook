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
    renderPost($post['first_name'] . ' ' . $post['last_name'], $post['username'], $post['avatar'], $post['created_at'], $post['content']);
}

?>

<div class="post">
    <div class="post-header">
        <a href="/pages/profile.php?u=johndoe">
            <img src="/assets/img/user2.jpg" alt="johndoe">
        </a>
        <div class="post-user-info">
            <strong>
                <a href="/pages/profile.php?u=johndoe">
                    John Doe</a></strong><a href="/pages/profile.php?u=johndoe">
            </a>
            <span class="post-date">2025-05-03 13:59:54</span>
        </div>
    </div>
    <p class="post-content">
        Hey Maxx 👋<br>
        <br>
        Just wanted to say hi and leave a little digital graffiti on your wall.<br>
        <br>
        Keep rocking, coding, and conquering the chaos 💻🎸🔥<br>
        <br>
        #HiThere #MaxxZoneTagged #VibesSent
    </p>
    <div class="post-actions">
        <a href="#">Like</a>
        <a href="#">Comment</a>
    </div>

    <div class="comment">
        <a href=""><img class="avatar" src="/assets/img/user2.jpg" alt="username"></a>
        <div class="comment-body">
            <div class="comment-wrapper">

                <div class="comment-header">
                    <a href=""><strong class="username">maxxdee</strong></a>
                    <span class="comment-time">2025-05-06 12:34</span>
                </div>
                <p class="comment-text">This is a test comment 🎸</p>

            </div>
            <div class="comment-actions">
                <a href="#">Like</a> · <a href="#">Reply</a>
            </div>
        </div>
    </div>


    <div class="comment">
        <a href=""><img class="avatar" src="/assets/img/user1.jpg" alt="username"></a>
        <div class="comment-body">
            <div class="comment-wrapper">

                <div class="comment-header">
                    <a href=""><strong class="username">maxxdee</strong></a>
                    <span class="comment-time">2025-05-06 12:34</span>
                </div>
                <p class="comment-text">This is another but much much much much much longer test comment 🎸</p>

            </div>
            <div class="comment-actions">
                <a href="#">Like</a> · <a href="#">Reply</a>
            </div>
        </div>
    </div>


</div>