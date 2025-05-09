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
