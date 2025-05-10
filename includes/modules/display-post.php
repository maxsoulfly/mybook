    <?php include_once __DIR__ . '/../functions.php'; ?>

    <?php
    $pdo = getDBConnection();

    // Initialize PostManager
    $postManager = new PostManager($pdo);
    // Fetch the post
    $post = $postManager->fetchPost($post_id);

    // If post not found, display an error
    if (!$post) {
        die('Post not found.');
    }

    // Fetch all comments for the post
    $comments = $postManager->fetchComments($pdo, $post_id);

    // Fetch replies for each comment
    foreach ($comments as &$comment) {
        $comment['replies'] = $postManager->fetchReplies($pdo, $comment['id']);
    }

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
