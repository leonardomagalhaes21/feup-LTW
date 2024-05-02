<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once (__DIR__ . '/../database/connection.db.php');
    require_once (__DIR__ . '/../database/users.class.php');
    require_once (__DIR__ . '/../templates/users.tpl.php');
    $db = getDatabaseConnection();

    $user = User::getUserById($db, $_SESSION['id']);
    drawUserDetails($user);

?>




