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

    public static function renderActionButton(
        int $profileId,
        string $baseUrl,
        string $actionUrl,
        string $buttonStyle,
        string $buttonLabel,
        string $formStyle = ''
    ): string {
        return '
        <form method="post" action="' . $baseUrl . $actionUrl . '" style="' . $formStyle . '">
            <input type="hidden" name="friend_id" value="' . $profileId . '">
            <button class="button ' . $buttonStyle . '">' . $buttonLabel . '</button>
        </form>';
    }

    public static function actionButtons(
        PDO $pdo,
        int $viewerId,
        int $profileId,
        string $baseUrl
    ): string {
        $FriendManager = new FriendManager($pdo);
        $status = $FriendManager->getFriendStatus($viewerId, $profileId);
        $output = '';

        if ($status === 'none' && $viewerId !== $profileId) {
            $output .= self::renderActionButton($profileId, $baseUrl, '/actions/friends/add-friend.php', 'primary', 'Add Friend');
        } elseif ($status === 'pending_sent') {
            $output .= self::renderActionButton($profileId, $baseUrl, '/actions/friends/cancel-friend.php', 'info', 'Cancel Request');
        } elseif ($status === 'pending_received') {
            $formStyle = 'display: inline-block;';
            $output .= '<div class="button-group">';
            $output .= self::renderActionButton($profileId, $baseUrl, '/actions/friends/accept-friend.php', 'secondary', 'Accept', $formStyle);
            $output .= self::renderActionButton($profileId, $baseUrl, '/actions/friends/deny-friend.php', 'alert', 'Reject', $formStyle);
            $output .= '</div>';
        } elseif ($status === 'stalker') {
            $output .= self::renderActionButton($profileId, $baseUrl, '/actions/friends/cancel-friend.php', 'info', 'Unfollow');
        } elseif ($status === 'followed_by') {
            $output .= '<span class="badge muted">They’re stalking you</span>';
        }

        return $output;
    }
}
