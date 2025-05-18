<?php
$page_title = "Sign Up";
$page = "signup";
$fullHeader = true; // flag for big header

include_once __DIR__ . '/../includes/header-public.php';

?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'exists'): ?>
    <div class="error-message">
        Username or email already exists. Please try another.
    </div>
<?php endif; ?>


<main>
    <div id="left-container">

    </div>


    <div class="main-container">
        <div class="form-section container-centered">
            <h2>Sign up to Mybook</h2>
            <form action="<?= $BASE_URL ?>/actions/auth/signup-process.php" method="POST">
                <input type="text" name="display_name" placeholder="Full Name">
                <input type="text" name="username" placeholder="Username">

                <select name="gender">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <input type="text" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="retype_password" placeholder="Retype Password">

                <button class="primary">Create Account</button>

                <ul class="links">
                    <li><a href="<?= $BASE_URL ?>/pages/login.php">Log in to Mybook</a></li>
                </ul>
            </form>
        </div>
    </div>


    <div id="right-container"></div>
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>