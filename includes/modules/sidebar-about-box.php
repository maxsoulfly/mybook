<?php
include_once __DIR__ . '/../functions.php';


$pdo = getDBConnection();
$profileId = $profile['id'];

$UserManager = new UserManager($pdo);
$user = $UserManager->getUserByUsername(username: $username);


?>

<div class="sidebar-box">
    <h3>Intro</h3>
    <div class="sidebar-item">
        <i class="mdi mdi-account-circle-outline"></i>
        <p><?= !empty($user['about_me']) ? htmlspecialchars($user['about_me']) : 'No information provided yet.'; ?></p>
    </div>
    <div class="sidebar-item">
        <i class="mdi mdi-map-marker-outline"></i>
        <p><?= !empty($user['location']) ? 'Lives in ' . htmlspecialchars($user['location']) : 'Location not specified.'; ?></p>
    </div>
</div>