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

function renderPendingFriend($username, $display_name, $avatar)
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
            <form method="post" action="<?= $BASE_URL ?>/friends/accept-friend.php" style="display: inline-block;">
                <input type="hidden" name="friend_id" value="<?= $profile[\'id\'] ?>">
                <button class="button secondary">Accept</button>
            </form>
                <form method="post" action="<?= $BASE_URL ?>/friends/deny-friend.php" style="display: inline-block;">
                    <input type="hidden" name="friend_id" value="<?= $profile[\'id\'] ?>">
                    <button class="button alert">Reject</button>
                </form>
            </div>
        </li>
    ';
}
