    <?php include_once __DIR__ . '/../functions.php'; ?>

    <?php
    $pdo = getDBConnection();


    // Create an instance of PostRenderer
    $postRenderer = new PostRenderer(
        $post_id,
        $pdo
    );

    // Render the post
    $postRenderer->render();
