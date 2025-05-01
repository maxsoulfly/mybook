<?php

require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
} else {
    if (
        !empty($_POST['username']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['retype_password']) &&
        !empty($_POST['first_name']) &&
        !empty($_POST['last_name']) &&
        !empty($_POST['gender'])
    ) {
        // All good, move forward 🚀
        if ($_POST['password'] !== $_POST['retype_password']) {
            die('Passwords do not match.');
        }

        $username = trim($_POST['username']);

        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Invalid email format.');
        }

        $password = trim($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $gender = trim($_POST['gender']);

        // default avatar & cover
        $avatar = "/assets/img/default_avatar.png";
        $cover = "/assets/img/default_cover.png";

        $stmt = $pdo->prepare(
            "INSERT INTO users (username, email, password, first_name, last_name, gender)
                    VALUES (:username, :email, :password, :first_name, :last_name, :gender)
        "
        );
        try {
            $stmt->execute([
                'username'   => $username,
                'email'      => $email,
                'password'   => $hashedPassword,
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'gender'     => $gender,
                'avatar'     => $avatar,
                'cover'     => $cover
            ]);

            // Success! Redirect to login
            header('Location: ' . $BASE_URL . '/pages/login.php?signup=success');
            exit;
        } catch (PDOException $e) {
            // TODO: Detect if duplicate is on username or email and show more specific error

            // Failure (likely duplicate username/email)
            header('Location: ' . $BASE_URL . '/pages/signup.php?error=exists');
            exit;
        }
    } else {
        die('Please fill in all required fields.');
    }
}
