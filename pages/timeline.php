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


        <!-- Friends here -->
        <div class="content-container">


            <?php include_once __DIR__ . '/../includes/timeline-sidebar.php'; ?>
            <?php include_once __DIR__ . '/../includes/timeline-main.php'; ?>

        </div>
        <!-- <div id="right-container"></div> -->
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>