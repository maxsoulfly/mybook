<?php

include_once __DIR__ . '/../config.php';

$page_title = "Profile";
$page = "profile";



$coverImage = $BASE_URL . '/assets/img/mountain.jpg';
$profilePicUrl = $BASE_URL . '/assets/img/selfie.jpg';
$username = 'Shaniqua Bee';


include_once __DIR__ . '/../includes/header.php';

?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">

        <?php include_once __DIR__ . '/../includes/profile-cover.php'; ?>
        <?php include_once __DIR__ . '/../includes/profile-nav.php'; ?>

        <!-- Friends here -->
        <div class="content-container">


            <?php include_once __DIR__ . '/../includes/profile-sidebar.php'; ?>
            <?php include_once __DIR__ . '/../includes/profile-main.php'; ?>

        </div>
        <!-- <div id="right-container"></div> -->
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>