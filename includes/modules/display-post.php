    <?php include_once __DIR__ . '/../functions.php'; ?>

    <?php
    $pdo = getDBConnection();

    function fetchPost($pdo, $post_id)
    {
        $stmt = $pdo->prepare(
            'SELECT posts.*, users.display_name, users.username, users.avatar
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.id = :post_id
            LIMIT 1'
        );
        $stmt->execute(['post_id' => $post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function fetchComments($pdo, $post_id)
    {
        $stmt = $pdo->prepare(
            'SELECT c.*, users.display_name, users.username, users.avatar 
            FROM comments AS c
            JOIN users ON c.user_id = users.id 
            WHERE c.post_id = :post_id 
                AND c.parent_id IS NULL
            ORDER BY c.created_at ASC'
        );
        $stmt->execute(['post_id' => $post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function fetchReplies($pdo, $parent_id)
    {
        $stmt = $pdo->prepare(
            'SELECT id, post_id, user_id, content, created_at
            FROM comments
            WHERE parent_id = :parent_id
            ORDER BY created_at ASC'
        );
        $stmt->execute(['parent_id' => $parent_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch the post
    $post = fetchPost($pdo, $post_id);

    // If post not found, display an error
    if (!$post) {
        die('Post not found.');
    }

    // Fetch all comments for the post
    $comments = fetchComments($pdo, $post_id);

    // Fetch replies for each comment
    foreach ($comments as &$comment) {
        $comment['replies'] = fetchReplies($pdo, $comment['id']);
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
