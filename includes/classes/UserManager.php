<?php

class UserManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserFromSession(): ?array
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

    public function getLoggedInUser(): ?array
    {
        if (!isset($_SESSION['username'])) {
            return null;
        }

        $stmt = $this->pdo->prepare(
            "SELECT * 
                    FROM users 
                    WHERE username = :username"
        );
        $stmt->execute(['username' => $_SESSION['username']]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getUserByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * 
                    FROM users 
                    WHERE username = :username"
        );
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
    public function getUserByUserId(string $user_id): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * 
                    FROM users 
                    WHERE id = :user_id"
        );
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function redirectIfNotLoggedIn($BASE_URL, $currentPage)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['u'])) {
            // if logged in display logged in user
            if (isset($_SESSION["username"])) {
                header('Location: ' . $BASE_URL . '/pages/' . $currentPage . '.php?u=' . $_SESSION['username']);
            }
            // else redirect to login
            else {
                header('Location: ' . $BASE_URL . '/pages/login.php');
            }
        }
    }
}
