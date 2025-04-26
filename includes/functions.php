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

function renderFriend($username, $full_name, $avatar)
{
    global $BASE_URL;

    echo '
        <li>
            <a href="http://localhost:8000/pages/profile.php?u=' . htmlspecialchars($username) . '">
                <img src="' . $BASE_URL . $avatar . '" alt="' . htmlspecialchars($username) . '">
                ' . htmlspecialchars($full_name) . '
            </a>
        </li>
    ';
}


function escapeOutput(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}



function getLoggedInUser(): ?array
{
    if (isset($_SESSION['user_id'])) {
        return [
            'id' => $_SESSION['user_id'],
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name' => $_SESSION['last_name'] ?? '',
            'avatar' => $_SESSION['avatar'] ?? ''
        ];
    }
    return null; // Not logged in
}
