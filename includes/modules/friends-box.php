<?php
include_once __DIR__ . '/../functions.php';


$pdo = getDBConnection();
$profileId = $profile['id'];


$stmt = $pdo->prepare(
    'SELECT 
        users.username, 
        users.id AS user_id, 
        users.first_name || " " || users.last_name AS full_name, 
        users.avatar
     FROM friends
     JOIN users 
       ON (users.id = friends.friend_id AND friends.user_id = :id)
       OR (users.id = friends.user_id AND friends.friend_id = :id)
     WHERE friends.status = "accepted"'
);
$stmt->execute(['id' => $profileId]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="sidebar-box">
    <h3>Friends</h3>
    <ul class="friends-list">
        <?php
        foreach ($friends as $friend) {
            $isInitiator = $friend['user_id'] == $profileId;
            $friendUsername = $friend['username'];
            $friendName = $friend['full_name'];
            $friendAvatar = $friend['avatar'];
        
            renderFriend($friendUsername, $friendName, $friendAvatar);
        }
        
        ?>
    </ul>
</div>