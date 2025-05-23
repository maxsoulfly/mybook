<?php
session_start();

include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/db.php';
$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
}

$errorMsg = validateFields($_POST);
if ($errorMsg !== '') {
    die($errorMsg);
}

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
$_SESSION['display_name'] = $user['display_name'];
$_SESSION['avatar'] = $user['avatar'];
$_SESSION['username'] = $user['username'];

header('Location: ' . $BASE_URL . '/pages/timeline.php');
exit;
