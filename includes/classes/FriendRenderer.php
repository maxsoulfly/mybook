<?php

class FriendRenderer
{
    public static function friendItem($username, $displayName, $avatar, $baseUrl)
    {
        return '
            <li>
                <a href="' . $baseUrl . '/pages/profile.php?u=' . htmlspecialchars($username) . '">
                    <img src="' . $baseUrl . $avatar . '" alt="' . htmlspecialchars($username) . '">
                    <div class="friend-name">' . htmlspecialchars($displayName) . '</div>
                </a>
            </li>
            ';
    }

    public static function pendingRequestItem($username, $displayName, $avatar, $userId, $baseUrl)
    {
        return '
            <li>
                <a href="' . $baseUrl . '/pages/profile.php?u=' . htmlspecialchars($username) . '">
                    <img src="' . $baseUrl . $avatar . '" alt="' . htmlspecialchars($username) . '">
                    <div class="friend-name">' . htmlspecialchars($displayName) . '</div>
                </a>
                <div class="button-group">
                    <form method="post" action="' . $baseUrl . '/actions/friends/accept-friend.php">
                        <input type="hidden" name="friend_id" value="' . $userId . '">
                        <button class="button primary">Accept</button>
                    </form>
                    <form method="post" action="' . $baseUrl . '/actions/friends/deny-friend.php">
                        <input type="hidden" name="friend_id" value="' . $userId . '">
                        <button class="button transparent">X</button>
                    </form>
                </div>
            </li>
        ';
    }
}
