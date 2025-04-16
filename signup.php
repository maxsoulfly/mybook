<?php
$page_title = "Sign Up";
$page = "signup";

include 'includes/header.php';
?>

<main>
    <div id="left-container">

    </div>

    <div id="main-container">
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
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="password" name="repassword" id="repassword" placeholder="Retype Password">
            <button class="primary">Login</button>
            <ul class="links">
                <li><a href="login.php">Log in to Mybook</a></li>
            </ul>
        </div>
    </div>

    <div id="right-container"></div>
</main>


<?php include 'includes/footer.php'; ?>