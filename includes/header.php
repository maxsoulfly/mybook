<?php include_once(__DIR__ . '/../config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBook | <?php echo $page_title ?></title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">


</head>

<body>
    <header id="header">
        <h1><a href="/index.php">MyBook</a></h1>
        <?php if ($page === "login"): ?>
            <a href="<?= $BASE_URL ?>/pages/signup.php" class="button secondary">Sign Up</a>
        <?php else: ?>
            <a href="<?= $BASE_URL ?>/pages/login.php" class="button secondary">Log In</a>
        <?php endif; ?>

        <i class="mdi mdi-magnify"></i>

    </header>