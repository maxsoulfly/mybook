<?php

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


// Validate
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$type = trim($_POST['type']);

if (!in_array($type, ['avatar', 'cover'])) {
    die('Invalid image type.');
}

if (!isset($_FILES[$type]) || $_FILES[$type]['error'] !== UPLOAD_ERR_OK) {
    die('File upload failed.');
}

// Create target directory:
// assets/uploads/{user_id}/ (if not exists)
$uploadDir = __DIR__ . '/../../assets/uploads/' . $user_id . '/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true); // true allows recursive creation
}


// Build final path:
// assets/uploads/{user_id}/{type}.jpg
$destinationPath = $uploadDir . $type . '.jpg';


// Move uploaded file to final location
$tmpFile = $_FILES[$type]['tmp_name'];

$success = false;

if ($type === 'avatar') {
    $success = resizeAndCropImage($tmpFile, $destinationPath, 500, 500);
} elseif ($type === 'cover') {
    $success = resizeAndCropImage($tmpFile, $destinationPath, 1280, 720);
}

if (!$success) {
    die('Image processing failed.');
}


if (!move_uploaded_file($tmpFile, $destinationPath)) {
    die('Error saving uploaded file.');
}

// Update DB with new path if needed (optional MVP)
$relativePath = 'assets/uploads/' . $user_id . '/' . $type . '.jpg';

$stmt = $pdo->prepare("UPDATE users SET $type = :path WHERE id = :user_id");

try {
    $stmt->execute([
        'path'     => $relativePath,
        'user_id'  => $user_id,
    ]);

    $finalUrl = redirectBackWithParam($type . '_upload', 'success');
    header('Location: ' . $finalUrl);
    exit;
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam($type . '_upload', 'failed');
    header('Location: ' . $finalUrl);
    exit;
}
