<?php
// $hasUnread=count($notifications)> 0;
// $iconClass = $hasUnread ? 'mdi mdi-bell has-unread' : 'mdi mdi-bell-outline';
$iconClass = 'mdi mdi-bell has-unread';
?>

<div class="notification-wrapper">
    <button class="notification-button" aria-label="Notifications">
        <i class="mdi mdi-bell has-unread"></i>
    </button>
    <span class="notification-badge">1</span>
    <div class="notification-dropdown">
        <ul>
            <li class="notification-item">
                <a href="" class="new">
                    <img src="/assets/img/maxxavatar.jpg" alt="Profile" class="avatar-small">
                    <span class="notification-text">Maxx posted on your wall.</span>
                </a>
            </li>
            <li class="notification-item">
                <a href="">
                    <img src=" /assets/img/maxxavatar.jpg" alt="Profile" class="avatar-small">
                    <span class="notification-text">Yana liked your photo.</span>
                </a>
            </li>
        </ul>
        <a href="/pages/notifications.php" class="view-all">View all</a>
    </div>
</div>