<?php
$page_title = "Profile";
$page = "profile";


include_once __DIR__ . '/../includes/header.php';

$coverImage = $BASE_URL . '/assets/img/mountain.jpg';
?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">

        <div class="profile-top" style="background-image: url('<?= $coverImage ?>');">
            <img src="<?= $profilePicUrl ?>" alt="Profile" class="avatar-large">
            <p class="username"><?= $username ?></p>
        </div>
        <nav class="profile-nav">
            <ul>
                <li><a href="#">Timeline</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Friends</a></li>
                <li><a href="#">Photos</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </nav>

        <div class="content-container">
            <div class="left-content">
                <p>This is the left content, taking 2 parts.</p>
            </div>
            <div class="main-content">
                <p>This is the right content, taking 3 parts.</p>
            </div>
        </div>

    </div>

    <!-- <div id="right-container"></div> -->
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>
