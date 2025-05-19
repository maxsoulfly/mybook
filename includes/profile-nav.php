<nav class="profile-nav">
    <ul>
        <li><a href="<?= $BASE_URL ?>/pages/profile.php?u=<?= $username ?>">Posts</a></li>
        <li><a href="<?= $BASE_URL ?>/pages/about.php?u=<?= $username ?>">About</a></li>
        <li><a href="<?= $BASE_URL ?>/pages/friends.php?u=<?= $username ?>">Friends</a></li>
        <li><a href="#">Photos</a></li>

        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $username): ?>
            <li><a href="<?= $BASE_URL ?>/pages/edit-profile.php">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
        <?php endif; ?>
    </ul>
</nav>