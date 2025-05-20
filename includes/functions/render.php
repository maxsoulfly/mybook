<?php

function renderFriend($username, $display_name, $avatar)
{
    global $BASE_URL;

    echo '
        <li>
            <a href="' . $BASE_URL . '/pages/profile.php?u=' . htmlspecialchars($username) . '">
                <img src="' . $BASE_URL . $avatar . '" alt="' . htmlspecialchars($username) . '">
                <div class="friend-name">
                    ' . htmlspecialchars($display_name) . '
                </div>
            </a>
        </li>
    ';
}

function renderPendingFriend($username, $display_name, $avatar, $user_id)
{
    global $BASE_URL;

    echo '
        <li>
            <a href="' . $BASE_URL . '/pages/profile.php?u=' . htmlspecialchars($username) . '">
                <img src="' . $BASE_URL . $avatar . '" alt="' . htmlspecialchars($username) . '">
                <div class="friend-name">
                    ' . htmlspecialchars($display_name) . '
                </div>
            </a>
           <div class="button-group">
            <form method="post" action="' .  $BASE_URL . '/actions/friends/accept-friend.php" style="display: inline-block;">
                <input type="hidden" name="friend_id" value="' . $user_id . '">
                <button class="button primary">Accept</button>
            </form>
                <form method="post" action="' . $BASE_URL . '/actions/friends/deny-friend.php" style="display: inline-block;">
                    <input type="hidden" name="friend_id" value="' . $user_id . '">
                    <button class="button transparent">X</button>
                </form>
            </div>
        </li>
    ';
}
