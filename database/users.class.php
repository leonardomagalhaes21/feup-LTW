<?php
declare(strict_types = 1);

class User {
    public int $idUser;
    public string $name;
    public string $username;
    public string $password;
    public string $email;

    public function __construct(int $idUser, string $name, string $username, string $password, string $email) {
        $this->idUser = $idUser;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public static function getUserById(PDO $db, int $idUser): ?User {
        $stmt = $db->prepare('SELECT * FROM Users WHERE idUser = ?');
        $stmt->execute([$idUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User($user['idUser'], $user['name'], $user['username'], $user['password'], $user['email']);
    }

    public static function getByUsername(PDO $db, string $username): ?User {
        $stmt = $db->prepare('SELECT * FROM Users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User($user['idUser'], $user['name'], $user['username'], $user['password'], $user['email']);
    }
}
?>