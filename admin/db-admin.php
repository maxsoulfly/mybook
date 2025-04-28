<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['query'])) {
    die('No query specified.');
}

$query = $_GET['query'];
$pdo = getDBConnection();

// Very basic switch to choose action
if ($query === 'add_gender_column') {
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN gender TEXT");
        echo "Gender column added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($query === 'update_default_images') {
    try {
        $stmt = $pdo->prepare("UPDATE users SET avatar = :avatar, cover = :cover WHERE username = :username");
        $stmt->execute([
            'avatar' => '/assets/img/default_avatar.png',
            'cover' => '/assets/img/default_cover.png',
            'username' => 'maxxdee'
        ]);
        echo "Avatar and cover updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Unknown query.";
}
