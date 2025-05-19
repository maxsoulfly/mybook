<?php

include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = "Edit Profile";
$page = "edit-profile";

if (!isset($_SESSION["username"])) {
    header('Location: ' . $BASE_URL . '/pages/login.php');
}

$username = $_SESSION["username"];
$pdo = getDBConnection();

$UserManager = new UserManager($pdo);
$user = $UserManager->getLoggedInUser();
$profile = $UserManager->getUserByUsername($username);

if (!$user) {
    header('Location: ' . $BASE_URL . '/pages/login.php');
    exit;
}

$coverImage = $BASE_URL . $user['cover'];
$profilePicUrl = $BASE_URL . $user['avatar'];
$display_name = $user['display_name'];



include_once __DIR__ . '/../includes/header.php';

?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">

        <?php include_once __DIR__ . '/../includes/profile-nav.php'; ?>
        <!-- Friends here -->
        <div class="content-container">


            <?php include_once __DIR__ . '/../includes/edit-profile-main.php'; ?>

        </div>
        <!-- <div id="right-container"></div> -->
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>