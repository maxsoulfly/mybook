<!-- Status box -->
<div class="status-box">
    <form method="post" action="<?= $BASE_URL ?>/actions/posts/post-process.php">
        <?php if ($user['id'] == $profile['id']): ?>
            <!-- My profile -->
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
        <?php else: ?>
            <!-- Friend's profile -->
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
            <input type="hidden" name="recipient_id" value="<?= $profile['id'] ?>">
        <?php endif; ?>
        <textarea
            name="content"
            placeholder="What's on your mind, <?= $user["username"] ?>?"
            rows="3"></textarea>
        <button class="primary">Post</button>
    </form>
</div>