<?php
include_once __DIR__ . '/../functions.php';


$pdo = getDBConnection();
$profileId = $user['id'];


$stmt = $pdo->prepare(
    'SELECT 
                    friends.*, 
                    users.username, 
                    users.first_name || " " || users.last_name AS full_name, 
                    users.avatar
        FROM friends
        JOIN users ON friends.friend_id = users.id
        WHERE friends.user_id = :id AND friends.status = "accepted"

'
);
$stmt->execute(['id' => $profileId]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="sidebar-box">
    <h3>Friends</h3>
    <ul class="friends-list">
        <?php
        foreach ($friends as $friend) {
            renderFriend($friend['username'], $friend['full_name'], $friend["avatar"]);
        }
        ?>
    </ul>
</div>