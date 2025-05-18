<?php


include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
}

$errorMsg = validateFields($_POST);
if ($errorMsg !== '') {
    die($errorMsg);
}

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$display_name = trim($_POST['display_name']);
$about_me = trim($_POST['about_me']);
$location = trim($_POST['location']);


$stmt = $pdo->prepare(
    "UPDATE users
            SET display_name = :display_name, about_me = :about_me, location = :location
            WHERE id = :user_id;
            "
);
try {
    $stmt->execute([
        'display_name'   => $display_name,
        'about_me'   => $about_me,
        'location'   => $location,
        'user_id'      => $user_id,
    ]);

    $finalUrl = redirectBackWithParam('about_update', 'success');
    header('Location: ' . $finalUrl);
    exit;
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam('about_update', 'failed');
    header('Location: ' . $finalUrl);
    exit;
}
