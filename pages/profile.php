<?php
$page_title = "Profile";
$page = "profile";

<<<<<<< HEAD:signup.php
include 'includes/header.php';
=======
include_once __DIR__ . '/../includes/header.php';
>>>>>>> 5582112d5ab5c5cfa7c6d4aefa3d4e43e2e30b2a:pages/profile.php
?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">
<<<<<<< HEAD:signup.php
        <div class="container form-container">
            <h2>Sign Up to Mybook</h2>
            <input type="text" name="first_name" id="first_name" placeholder="First Name">
            <input type="text" name="last_name" id="last_name" placeholder="Last Name">
            
            <div class="form-group">
                <label class="form-label">Sex:</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male"> Male</label>
                    <label><input type="radio" name="gender" value="female"> Female</label>
                    <label><input type="radio" name="gender" value="yes"> Yes</label>
                </div>
            </div>

            <input type="email" name="email" id="email" placeholder="Enter your email">
=======
        <div class="form-section container">
            <h2>Log in to Mybook</h2>
            <input type="text" name="email" id="email" placeholder="Enter your email">
>>>>>>> 5582112d5ab5c5cfa7c6d4aefa3d4e43e2e30b2a:pages/profile.php
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="password" name="repassword" id="repassword" placeholder="Retype Password">
            <button class="primary">Login</button>
            <ul class="links">
<<<<<<< HEAD:signup.php
                <li><a href="login.php">Log in to Mybook</a></li>
=======
                <li><a href="#">Forgotten Password?</a></li>
                <li><a href="<?= $BASE_URL ?>/pages/signup.php">Sign Up for Mybook</a></li>
>>>>>>> 5582112d5ab5c5cfa7c6d4aefa3d4e43e2e30b2a:pages/profile.php
            </ul>
        </div>
    </div>

    <div id="right-container"></div>
</main>


<<<<<<< HEAD:signup.php
<?php include 'includes/footer.php'; ?>
=======
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
>>>>>>> 5582112d5ab5c5cfa7c6d4aefa3d4e43e2e30b2a:pages/profile.php
