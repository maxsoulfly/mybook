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

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$content = trim($_POST['content']);


$recipient_id = filter_input(INPUT_POST, 'recipient_id', FILTER_SANITIZE_NUMBER_INT) ?? NULL;

$stmt = $pdo->prepare(
    "INSERT INTO posts (user_id, content, recipient_id)
                VALUES (:user_id, :content, :recipient_id)
        "
);
try {
    $stmt->execute([
        'user_id'   => $user_id,
        'content'      => $content,
        'recipient_id'   => $recipient_id
    ]);

    $finalUrl = redirectBackWithParam('post', 'success');
    header('Location: ' . $finalUrl);
    exit;
} catch (PDOException $e) {
    $finalUrl = redirectBackWithParam('post', 'failed');
    header('Location: ' . $finalUrl);
    exit;
}
