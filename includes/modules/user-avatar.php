<div class="avatar">
    <a href="<?= $BASE_URL ?>/pages/profile.php?u=<?= $user["username"] ?>">
        <img src="<?= $BASE_URL ?><?= $user['avatar'] ?>" alt="Profile" class="avatar-small">
        <span class="username"><?= $user["display_name"] ?></span>
    </a>
    <?php include_once __DIR__ . '/user-logout.php'; ?>

</div>