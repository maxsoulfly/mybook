<div class="main-content">

    <?php

    if ($profile['id'] === $user['id'] || $friendStatus === 'accepted') {
        // show post form
        include_once __DIR__ . '/modules/status-box.php';
    }

    ?>
    <?php include_once __DIR__ . '/modules/profile-posts.php'; ?>

</div>