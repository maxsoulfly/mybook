<?php

include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

$page_title = "Timeline";
$page = "timeline";

if (!isset($_SESSION["username"])) {
    header('Location: ' . $BASE_URL . '/pages/login.php');
}

$username = $_SESSION["username"];
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


        <!-- Friends here -->
        <div class="content-container">


            <?php include_once __DIR__ . '/../includes/timeline-sidebar.php'; ?>
            <?php include_once __DIR__ . '/../includes/timeline-main.php'; ?>

        </div>
        <!-- <div id="right-container"></div> -->
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>