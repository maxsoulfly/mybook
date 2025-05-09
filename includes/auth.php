<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit;
}

// Expose $user variable for use in headers/layouts
$user = [
    'id' => $_SESSION['user_id'],
    'display_name' => $_SESSION['display_name'] ?? '',
    'avatar' => $_SESSION['avatar'] ?? ''
];
