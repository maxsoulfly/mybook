<?php
include_once __DIR__ . '/../functions.php';

$friends = [
    ["username" => "Boris Gee", "avatar" => "/assets/img/user1.jpg"],
    ["username" => "John Doe", "avatar" => "/assets/img/user2.jpg"],
    ["username" => "Mika Strong", "avatar" => "/assets/img/user3.jpg"],
    ["username" => "Ali Sun", "avatar" => "/assets/img/user4.jpg"],
];
?>

<div class="sidebar-box">
    <h3>Friends</h3>
    <ul class="friends-list">
        <?
        foreach ($friends as $friend) {
            renderFriend($friend["username"], $friend["avatar"]);
        }
        ?>
    </ul>
</div>