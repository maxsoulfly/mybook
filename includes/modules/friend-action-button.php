<?php

$FriendManager = new FriendManager($pdo);
$status = $FriendManager->getFriendStatus($user['id'], $profile['id']);
?>

<?php if ($status === 'none' && ($profile['id'] !== $_SESSION['user_id'])): ?>
    <form method="post" action="<?= $BASE_URL ?>/actions/friends/add-friend.php">
        <input type="hidden" name="friend_id" value="<?= $profile['id'] ?>">
        <button class="button primary">Add Friend</button>
    </form>
<?php elseif ($status === 'pending_sent'): ?>
    <form method="post" action="<?= $BASE_URL ?>actions//friends/cancel-friend.php">
        <input type="hidden" name="friend_id" value="<?= $profile['id'] ?>">
        <button class="button info">Cancel Request</button>
    </form>

<?php elseif ($status === 'pending_received'): ?>
    <div class="button-group">
        <form method="post" action="<?= $BASE_URL ?>actions//friends/accept-friend.php" style="display: inline-block;">
            <input type="hidden" name="friend_id" value="<?= $profile['id'] ?>">
            <button class="button secondary">Accept</button>
        </form>
        <form method="post" action="<?= $BASE_URL ?>actions//friends/deny-friend.php" style="display: inline-block;">
            <input type="hidden" name="friend_id" value="<?= $profile['id'] ?>">
            <button class="button alert">Reject</button>
        </form>
    </div>

<?php elseif ($status === 'accepted'): ?>
    <!-- Already friends: no button for now -->

<?php elseif ($status === 'stalker'): ?>
    <!-- If I'm the stalker (i.e., I initiated and was denied) -->
    <form method="post" action="<?= $BASE_URL ?>actions//friends/cancel-friend.php">
        <input type="hidden" name="friend_id" value="<?= $profile['id'] ?>">
        <button class="button info">Unfollow</button>
    </form>
<?php elseif ($status === 'followed_by'): ?>
    <span class='badge muted'>They’re stalking you</span>
<?php endif; ?>