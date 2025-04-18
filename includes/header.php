<?php include_once(__DIR__ . '/../config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBook | <?php echo $page_title ?></title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= $BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">


</head>

<body>
    <header id="header" class="<?= !empty($fullHeader) ? 'header-large' : 'header-compact' ?>">

        <?php if (!empty($fullHeader)): ?>
            <h1><a href="<?= $BASE_URL ?>/index.php">MyBook</a></h1>
            <a href="<?= $BASE_URL ?>/pages/<?= $page === 'login' ? 'signup' : 'login' ?>.php" class="button secondary">
                <?= $page === 'login' ? 'Sign Up' : 'Log In' ?>
            </a>

        <?php else: ?>
            <div class="wrapper">
                <h1><a href="<?= $BASE_URL ?>/index.php">MyBook</a></h1>
                <form action="<?= $BASE_URL ?>/search.php" method="get" class="search-form">
                    <input type="text" name="q" placeholder="Search for people, places and things" class="input search-input">
                    <i class="mdi mdi-magnify search-icon"></i>

                </form>
                <div class="avatar">
                    <a href="<?= $BASE_URL ?>/pages/profile.php">
                        <img src="<?= $BASE_URL ?>/assets/img/user1.jpg" alt="Profile" class="avatar-small">
                        <span class="username">Boris Gee</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </header>