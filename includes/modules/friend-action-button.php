<?php

$FriendManager = new FriendManager($pdo);
$status = $FriendManager->getFriendStatus($user['id'], $profile['id']);

echo FriendRenderer::actionButtons($pdo, $user['id'], $profile['id'], $BASE_URL);
