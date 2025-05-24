<?php

$NotificationsRenderer = new NotificationsRenderer($pdo);
$NotificationsManager = new NotificationsManager();

$unreadNotifications = $NotificationsManager->getUnreadByUser($pdo, $user['id']);
$hasUnread = $unreadNotifications && count($unreadNotifications) > 0;

$notifications = $NotificationsManager->getAllByUser($pdo, $user['id']);
if ($notifications === null) {
    $notifications = [];
}
$iconClass = 'mdi mdi-bell has-unread';
?>

<div class="notification-wrapper">
    <button id="notification-toggle" class="notification-button" aria-label="Notifications">
        <i class="mdi mdi-bell has-unread"></i>
    </button>
    <?php if ($hasUnread): ?>
        <span class="notification-badge"><?= count($unreadNotifications) ?></span>
    <?php endif; ?>
    <div id="notification-dropdown" class="hidden">
        <?= $NotificationsRenderer->renderDropdown($notifications) ?>
        <a href="/pages/notifications.php" class="view-all">View all</a>
    </div>
</div>