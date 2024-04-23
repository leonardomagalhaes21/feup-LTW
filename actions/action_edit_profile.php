<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/users.class.php');

$db = getDatabaseConnection();
$user = User::getUserById($db, $_SESSION['id']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    $user->name = $name;
    $user->email = $email;

    $user->save($db, $name, $email, $_SESSION['id']);
    header("Location: /pages/user-profile.php?idUser=" . $_SESSION['id']);
    exit();
}
?>
