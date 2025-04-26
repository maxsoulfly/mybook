<?php
require_once __DIR__ . '/includes/auth.php';
include_once __DIR__ . '/config.php';

$page_title = "Index";
$page = "index";

$profilePicUrl = $BASE_URL . '/assets/img/user1.jpg';
$username = 'Boris Gee';

include_once __DIR__ . '/includes/header-public.php';
?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">
        <?php include_once __DIR__ . '/includes/index-nav.php'; ?>
    </div>

    <div id="right-container"></div>
</main>


<?php include_once __DIR__ . '/includes/footer.php'; ?>