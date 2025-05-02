<div class="profile-top" style="background-image: url('<?= $coverImage ?>');">
    <img src="<?= $profilePicUrl ?>" alt="Profile" class="avatar-large avatar-large shadow border">
    <p class="username text-shadow"><?= $profileFullName ?></p>
    
    <?php include_once __DIR__ . '/modules/friend-action-button.php'; ?>
</div>