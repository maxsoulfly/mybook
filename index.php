<?php
include_once __DIR__ . '/config.php';

$page_title = "Index";
$page = "index";


// $coverImage = $BASE_URL . '/assets/img/mountain.jpg';
$profilePicUrl = $BASE_URL . '/assets/img/user1.jpg';
$username = 'Boris Gee';

include_once __DIR__ . '/includes/header.php';
?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">
        <div class="container">
            <a href="<?= $BASE_URL ?>/pages/profile.php">Profile</a>
        </div>
    </div>

    <div id="right-container"></div>
</main>


<?php include_once __DIR__ . '/includes/footer.php'; ?>