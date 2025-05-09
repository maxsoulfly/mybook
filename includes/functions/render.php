<?php

function renderFriend($username, $full_name, $avatar)
{
    global $BASE_URL;

    echo '
        <li>
            <a href="' . $BASE_URL . '/pages/profile.php?u=' . htmlspecialchars($username) . '">
                <img src="' . $BASE_URL . $avatar . '" alt="' . htmlspecialchars($username) . '">
                <div class="friend-name">
                    ' . htmlspecialchars($full_name) . '
                </div>
            </a>
        </li>
    ';
}
