<?php
include_once __DIR__ . '/../functions.php';


$pdo = getDBConnection();
$FriendManager = new FriendManager($pdo);
$profileId = $profile['id'];
$friends = $FriendManager->getFriends($profileId);

?>

<div class="sidebar-box">
    <h3>Friends (<?= count($friends) ?>)</h3>
    <ul class="friends-list">
        <?php
        foreach ($friends as $friend) {
            $isInitiator = $friend['user_id'] == $profileId;
            $friendUsername = $friend['username'];
            $friendName = $friend['display_name'];
            $friendAvatar = $friend['avatar'];

            renderFriend($friendUsername, $friendName, $friendAvatar);
        }

        ?>
    </ul>
</div>