<div class="profile-top" style="background-image: url('<?= $coverImage ?>');">
    <img src="<?= $profilePicUrl ?>" alt="Profile" class="avatar-large avatar-large shadow border">
    <p class="username text-shadow"><?= $profileFullName ?></p>
    
    <?php if ($profile['id'] !== $_SESSION['user_id']): ?>
        <form method="post" action="<?= $BASE_URL ?>/actions/add-friend.php">
            <input type="hidden" name="friend_id" value="<?= $user['id'] ?>">
            <button class="button primary">Add Friend</button>
        </form>
    <?php endif; ?>

</div>