<?php

include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

$page_title = "Profile";
$page = "profile";

if (!isset($_GET['u'])) {
    die('No user specified.');
}

$username = $_GET['u'];
$pdo = getDBConnection();

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('User not found.');
}


$coverImage = $BASE_URL . $user['cover'];
$profilePicUrl = $BASE_URL . $user['avatar'];
$userFullName = $user['first_name'] . ' ' . $user['last_name'];


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