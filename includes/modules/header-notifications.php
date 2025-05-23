<?php
// $hasUnread=count($notifications)> 0;
// $iconClass = $hasUnread ? 'mdi mdi-bell has-unread' : 'mdi mdi-bell-outline';
$iconClass = 'mdi mdi-bell has-unread';
?>

<div class="notification-wrapper">
    <button id="notification-toggle" class="notification-button" aria-label="Notifications">
        <i class="mdi mdi-bell has-unread"></i>
    </button>
    <span class="notification-badge">1</span>
    <div id="notification-dropdown" class="hidden">
        <ul>
            <li>
                <a href="" class="new">
                    <img src="/assets/img/maxxavatar.jpg" alt="Profile" class="avatar-small">
                    <span class="notification-text">Maxx posted on your wall.</span>
                </a>
            </li>
            <li>
                <a href="">
                    <img src=" /assets/img/maxxavatar.jpg" alt="Profile" class="avatar-small">
                    <span class="notification-text">Yana liked your photo.</span>
                </a>
            </li>
        </ul>
        <a href="/pages/notifications.php" class="view-all">View all</a>
    </div>
</div>