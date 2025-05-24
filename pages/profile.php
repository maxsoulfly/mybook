<?php if (isset($_GET['request']) && $_GET['request'] === 'sent'): ?>
    <p class="notice">Friend request sent!</p>
<?php endif; ?>

<?php

include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = "Profile";
$page = "profile";

$pdo = getDBConnection();


$UserManager = new UserManager($pdo);
$UserManager->redirectIfNotLoggedIn($BASE_URL, "profile");
$username = $_GET['u'];

$FriendManager = new FriendManager($pdo);
$UserManager = new UserManager($pdo);
$user = $UserManager->getLoggedInUser();
$profile = $UserManager->getUserByUsername($username);

if (isset($_GET['notification_id'])) {
    $notificationId = (int)$_GET['notification_id'];
    $NotificationsManager = new NotificationsManager();
    $NotificationsManager->markRead($pdo, $user['id'], $notificationId);
}

if (!$user) {
    header('Location: ' . $BASE_URL . '/pages/login.php');
    exit;
}

// echo "user id:" . $user["id"] . " | profile id:" . $profile["id"];

$coverImage = $BASE_URL . $profile['cover'];
$profilePicUrl = $BASE_URL . $profile['avatar'];
$profileFullName = $profile['display_name'];
$friendStatus = $FriendManager->getFriendStatus($user["id"], $profile["id"]);

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