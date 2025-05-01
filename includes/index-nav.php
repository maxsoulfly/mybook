<nav class="profile-nav">
    <ul>
        
    <?php if (!isset($_SESSION['user_id'])): ?>
        <li><a href="<?= $BASE_URL ?>/pages/signup.php">Sign Up</a></li>
        <li><a href="<?= $BASE_URL ?>/pages/login.php">login</a></li>
    <?php endif; ?>
        <li><a href="<?= $BASE_URL ?>/pages/profile.php">Profile</a></li>
        <li><a href="<?= $BASE_URL ?>/pages/timeline.php">Timeline</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Friends</a></li>
        <li><a href="#">Photos</a></li>
        <li><a href="#">Settings</a></li>
    </ul>
</nav>