<?php
include_once __DIR__ . '/../functions.php';

$pdo = getDBConnection();
$FriendManager = new FriendManager($pdo);
$profileId = $profile['id'];
$pendingFriend = $FriendManager->getPendingFriendRequests($profileId);
?>

<div class="content-box">
    <h3>Pending Friends Requests</h3>
    <ul class="friends-request-list">
        <?php
        foreach ($pendingFriend as $friend) {
            $isInitiator = $friend['user_id'] == $profileId;
            $friendUsername = $friend['username'];
            $friendName = $friend['display_name'];
            $friendAvatar = $friend['avatar'];

            renderPendingFriend($friendUsername, $friendName, $friendAvatar);
        }

        ?>
    </ul>
</div>