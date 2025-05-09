<?php

function getUserFromSession(): ?array
{
    if (isset($_SESSION['user_id'])) {
        return [
            'id' => $_SESSION['user_id'],
            'display_name' => $_SESSION['display_name'] ?? '',
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
