<?php
session_start();

require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
} else {
    if (
        !empty($_POST['email']) &&
        !empty($_POST['password'])
    ) {
        // all good

        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Invalid email format.');
        }

        // 1. Prepare and execute a SELECT query to find the user by email
        $password = trim($_POST['password']);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. If no user found → die('Incorrect email or password.')
        // 3. If user found, use password_verify($password, $user['password'])
        // 4. If password doesn't match → die('Incorrect email or password.')
        if (!$user || !password_verify($password, $user['password'])) {
            die('Incorrect email or password.');
        }

        // 5. If everything is good → (we'll build session/login later)
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['avatar'] = $user['avatar'];

        header('Location: ../index.php');
        exit;
    } else {
        die('Please fill in all required fields.');
    }
}
