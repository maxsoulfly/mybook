<?php
$page_title = "Log In";
$page = "login";
$fullHeader = true; // flag for big header

include_once __DIR__ . '/../includes/header-public.php';
?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">
        <div class="form-section container-centered">
            <h2>Log in to Mybook</h2>
            <form action="<?= $BASE_URL ?>/actions/login-process.php" method="POST">
                <input type="text" name="email" id="email" placeholder="Enter your email">
                <input type="password" name="password" id="password" placeholder="Password">
                <button type="submit" class="primary">Login</button>
            </form>
            <ul class="links">
                <li><a href="#">Forgotten Password?</a></li>
                <li><a href="<?= $BASE_URL ?>/pages/signup.php">Sign Up for Mybook</a></li>
            </ul>

        </div>
    </div>

    <div id="right-container"></div>
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>