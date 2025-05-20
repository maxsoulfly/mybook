<div class="main-content">

    <?php
    if (isset($_SESSION['username']) && $_SESSION['username'] === $username)
        include_once __DIR__ . '/modules/friends-pending-box.php';
    ?>
    <?php include_once __DIR__ . '/modules/friends-box.php'; ?>

</div>