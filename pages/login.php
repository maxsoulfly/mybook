<?php
$page_title = "Log In";
$page = "login";
$fullHeader = true; // flag for big header

<<<<<<< HEAD:login.php
include 'includes/header.php';
=======
include_once __DIR__ . '/../includes/header.php';
>>>>>>> 5582112d5ab5c5cfa7c6d4aefa3d4e43e2e30b2a:pages/login.php
?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">
<<<<<<< HEAD:login.php
        <div class="container form-container">
=======
        <div class="form-section container">
>>>>>>> 5582112d5ab5c5cfa7c6d4aefa3d4e43e2e30b2a:pages/login.php
            <h2>Log in to Mybook</h2>
            <input type="text" name="email" id="email" placeholder="Enter your email">
            <input type="password" name="password" id="password" placeholder="Password">
            <button class="primary">Login</button>
            <ul class="links">
                <li><a href="#">Forgotten Password?</a></li>
                <li><a href="<?= $BASE_URL ?>/pages/signup.php">Sign Up for Mybook</a></li>
            </ul>
        </div>
    </div>

    <div id="right-container"></div>
</main>


<<<<<<< HEAD:login.php
<?php include 'includes/footer.php'; ?>
=======
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
>>>>>>> 5582112d5ab5c5cfa7c6d4aefa3d4e43e2e30b2a:pages/login.php
