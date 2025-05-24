<?php

class NotificationsRenderer
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function renderDropdown(array $notifications): string
    {
        $html = '<ul>';
        foreach ($notifications as $notification) {
            $html .= $this->renderItem($notification);
        }
        $html .= '</ul>';
        return $html;
    }
    public function renderItem(array $notification): string
    {
        $userManager = new UserManager($this->pdo);
        $user = $userManager->getUserByUserId($notification['user_id']);
        $when = timeAgoShort($notification['created_at']);
        return '<li class="notification-item">
                    <a href="' . $notification['link'] . '" class="' . ($notification['is_read'] ? '' : 'new') . '">
                        <img src="' . $user['avatar'] . '" alt="Profile" class="avatar-small">
                        <div>
                            <span class="notification-text">' . $notification['content'] . '</span>
                            <span class="post-date">' . $when . '</span>
                        </div>
                    </a>
                </li>';
    }
}
