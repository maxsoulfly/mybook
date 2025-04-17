<?php
$page_title = "Sign Up";
$page = "signup";

include '../includes/header.php';
?>

<main>
    <div id="left-container">

    </div>


    <div class="main-container">
        <div class="form-section container">
            <h2>Sign up to Mybook</h2>
            <form action="">
                <input type="text" name="first_name" placeholder="First Name">
                <input type="text" name="last_name" placeholder="Last Name">

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
                    <li><a href="login.php">Log in to Mybook</a></li>
                </ul>
            </form>
        </div>
    </div>


    <div id="right-container"></div>
</main>


<?php include '../includes/footer.php'; ?>