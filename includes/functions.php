<?php

function renderPost($username, $avatar, $date, $content)
{
    global $BASE_URL;

    echo '
        <div class="post">
            <div class="post-header">
                <img src="' . $BASE_URL . $avatar . '" alt="' . htmlspecialchars($username) . '">
                <div class="post-user-info">
                <strong>' . htmlspecialchars($username) . '</strong>
                <span class="post-date">' . htmlspecialchars($date) . '</span>
                </div>
            </div>
            <p class="post-content">' . htmlspecialchars($content) . '</p>
            <div class="post-actions">
                <a href="#">Like</a>
                <a href="#">Comment</a>
            </div>
        </div>
    ';
}

function renderFriend($username, $avatar)
{
    global $BASE_URL;

    echo '
        <li>
            <img src="' . $BASE_URL . $avatar . '" alt="' . htmlspecialchars($username) . '">
            ' . htmlspecialchars($username) . '
        </li>
    ';
}
