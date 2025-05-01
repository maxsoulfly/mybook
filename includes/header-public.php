<?php
include_once(__DIR__ . '/../config.php');

?>
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
        <?php include_once __DIR__ . '/modules/header-logo.php'; ?>
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            <?php include_once __DIR__ . '/modules/header-auth-button.php'; ?>
        <?php endif; ?>
    </header>