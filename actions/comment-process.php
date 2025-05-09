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

$post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$content = trim($_POST['content']);


$stmt = $pdo->prepare(
    "INSERT INTO comments (post_id, user_id, content)
                VALUES (:post_id, :user_id, :content)
        "
);
try {
    $stmt->execute([
        'post_id'   => $post_id,
        'user_id'   => $user_id,
        'content'      => $content,
    ]);

    $finalUrl = redirectBackWithParam('comment', 'success');
    header('Location: ' . $finalUrl);
    exit;
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam('comment', 'failed');
    header('Location: ' . $finalUrl);
    exit;
}
