<?php

function renderPost($fullname, $username, $avatar, $date, $content)
{
    global $BASE_URL;
    $username = htmlspecialchars($username);
    $fullname = htmlspecialchars($fullname);
    $date = htmlspecialchars($date);
    echo '
        <div class="post">
            <div class="post-header">
                <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                    <img src="' . $BASE_URL . $avatar . '" alt="' . $username . '">
                </a>
                <div class="post-user-info">
                    <strong>
                        <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                            ' . $fullname . '</strong>
                        </a>
                    <span class="post-date">' . $date . '</span>
                </div>
            </div>
            <p class="post-content">
                ' . nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '
            </p>
            <div class="post-actions">
                <a href="#">Like</a>
                <a href="#">Comment</a>
            </div>
        </div>
    ';
}

function renderComment($fullname, $username, $avatar, $date, $content)
{
    global $BASE_URL;

    $username = htmlspecialchars($username);
    $fullname = htmlspecialchars($fullname);
    $date = htmlspecialchars($date);

    echo '
        <div class="comment">
            <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                <img class="avatar" src="' . $BASE_URL . $avatar . '" alt="' . $username . '">
            </a>
            <div class="comment-body">
                <div class="comment-wrapper">

                    <div class="comment-header">
                        <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                            <strong class="username">' . $fullname . '</strong>
                        </a>
                        <span class="comment-time">' . $date . '</span>
                    </div>
                    <p class="comment-text">
                        ' . nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '
                    </p>

                </div>
                <div class="comment-actions">
                    <a href="#">Like</a> · <a href="#">Reply</a>
                </div>
            </div>
        </div>
    ';
}

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


function escapeOutput(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


function getUserFromSession(): ?array
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


function getLoggedInUser(PDO $pdo): array|null
{
    if (!isset($_SESSION['username'])) {
        return null;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $_SESSION['username']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserByUsername(PDO $pdo, string $username): ?array
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
}

function areFriends(PDO $pdo, int $userId, int $friendId): bool
{
    $stmt = $pdo->prepare("  SELECT 1 FROM friends 
                                    WHERE 
                                    (
                                        (user_id = :user AND friend_id = :friend) 
                                        OR (user_id = :friend AND friend_id = :user)
                                    )
                                    AND status = 'accepted')");
    $stmt->execute([
        'user' => $userId,
        'friend' => $friendId
    ]);
    return (bool) $stmt->fetch();
}

function getFriendStatus(PDO $pdo, int $userId, int $profileId): string
{
    $stmt = $pdo->prepare("
        SELECT user_id, friend_id, status FROM friends 
        WHERE 
            (user_id = :user AND friend_id = :profile)
         OR (user_id = :profile AND friend_id = :user)
    ");
    $stmt->execute(['user' => $userId, 'profile' => $profileId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return 'none';

    if ($row['status'] === 'accepted') return 'accepted';

    if ($row['status'] === 'pending') {
        if ((int)$row['user_id'] === $userId) {
            return 'pending_sent';     // we sent the request
        } else {
            return 'pending_received'; // they sent it to us
        }
    }

    if ($row['status'] === 'stalker') {
        if ($row['user_id'] == $_SESSION['user_id']) {
            return 'stalker'; // I’m the stalker
        } else {
            return 'followed_by'; // You denied them, they follow you
        }
    }

    return 'none'; // fallback
}

function redirectBackWithParam($key, $value)
{
    $referer = $_SERVER['HTTP_REFERER'];
    $urlParts = parse_url($referer);

    // Keep path + query separately
    $baseUrl = $urlParts['path'];
    parse_str($urlParts['query'] ?? '', $queryParams);

    // Replace or add `request`
    $queryParams[$key] = $value;

    // Build final redirect
    $finalUrl = $baseUrl . '?' . http_build_query($queryParams);

    return $finalUrl;
}


function validateFields($data)
{
    $error = '';
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $error .= "$key is empty!<br>";
        }
    }

    return $error ?: "";
}
