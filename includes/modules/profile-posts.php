<?php include_once __DIR__ . '/../functions.php'; ?>

<?php
$pdo = getDBConnection();
$profileId = $profile['id'];
$PostManager = new PostManager($pdo);


$posts = $PostManager->fetchProfilePosts($pdo, $profileId);


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
