<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBook | <?php echo $page_title ?></title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <header id="header">
        <h1>MyBook</h1>
        <?php
        if ($page == "login") {
            echo '<a href="signup.php" class="button secondary">Sign Up</a>';
        } else {
            echo '<a href="login.php" class="button secondary">Log In</a>';
        }
        ?>

    </header>