<?php

include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = "Profile";
$page = "profile";



if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    die('No post id');
}

if (!isset($_SESSION["username"])) {
    header('Location: ' . $BASE_URL . '/pages/login.php');
}

$post_id = $_GET['id'];
$pdo = getDBConnection();
$UserManager = new UserManager($pdo);
$NotificationsManager = new NotificationsManager();
$user = $UserManager->getLoggedInUser();

if (isset($_GET['notification_id'])) {
    $notificationId = (int)$_GET['notification_id'];
    $NotificationsManager->markRead($pdo, $user['id'], $notificationId);
}

if (!$user) {
    header('Location: ' . $BASE_URL . '/pages/login.php');
    exit;
}

include_once __DIR__ . '/../includes/header.php';

?>



<main>
    <div id="left-container">

    </div>

    <div id="main-container">

        <!-- Friends here -->
        <div class="content-container">

            <?php include_once __DIR__ . '/../includes/post-main.php'; ?>

        </div>
        <!-- <div id="right-container"></div> -->
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>