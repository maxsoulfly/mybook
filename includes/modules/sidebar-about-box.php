<?php
include_once __DIR__ . '/../functions.php';


$pdo = getDBConnection();
$profileId = $profile['id'];


?>

<div class="sidebar-box">
    <h3>Intro</h3>
    <div class="sidebar-item">
        <i class="mdi mdi-account-circle-outline"></i>
        <p><?= !empty($profile['about_me']) ? htmlspecialchars($profile['about_me']) : 'No information provided yet.'; ?></p>
    </div>
    <div class="sidebar-item">
        <i class="mdi mdi-map-marker-outline"></i>
        <p><?= !empty($profile['location']) ? 'Lives in ' . htmlspecialchars($profile['location']) : 'Location not specified.'; ?></p>
    </div>
</div>