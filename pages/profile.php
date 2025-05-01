<?php

include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = "Profile";
$page = "profile";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['u'])) {
    // if logged in display logged in user
    if (isset($_SESSION["username"])) {
        header('Location: '.$BASE_URL.'/pages/profile.php?u=' . $_SESSION['username']);
    }
    // else redirect to login
    else {
        header('Location: ' . $BASE_URL . '/pages/login.php');
    }
}

$username = $_GET['u'];
$pdo = getDBConnection();
$user = getLoggedInUser($pdo);
$profile = getUserByUsername($pdo, $username);


if (!$user) {
    header('Location: ' . $BASE_URL . '/pages/login.php');
    exit;
}

$coverImage = $BASE_URL . $profile['cover'];
$profilePicUrl = $BASE_URL . $profile['avatar'];
$profileFullName = $profile['first_name'] . ' ' . $profile['last_name'];


include_once __DIR__ . '/../includes/header.php';

?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">

        <?php include_once __DIR__ . '/../includes/profile-cover.php'; ?>

        <?php include_once __DIR__ . '/../includes/profile-nav.php'; ?>


        <?php if ($user['id'] !== $_SESSION['user_id']): ?>
            <form method="post" action="<?= $BASE_URL ?>/actions/add-friend.php">
                <input type="hidden" name="friend_id" value="<?= $user['id'] ?>">
                <button class="button primary">Add Friend</button>
            </form>
        <?php endif; ?>
        <!-- Friends here -->
        <div class="content-container">


            <?php include_once __DIR__ . '/../includes/profile-sidebar.php'; ?>
            <?php include_once __DIR__ . '/../includes/profile-main.php'; ?>

        </div>
        <!-- <div id="right-container"></div> -->
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>