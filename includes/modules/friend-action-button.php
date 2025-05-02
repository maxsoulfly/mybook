<?php if ($profile['id'] !== $_SESSION['user_id']): ?>
    <form method="post" action="<?= $BASE_URL ?>/actions/add-friend.php">
        <input type="hidden" name="friend_id" value="<?= $profile['id'] ?>">
        <button class="button primary">Add Friend</button>
    </form>
<?php endif; ?>