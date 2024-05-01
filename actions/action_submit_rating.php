<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header("Location: ../pages/login.php");
        exit;
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/users.class.php');

    $db = getDatabaseConnection();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];
            $userId = $_POST['idUser'];

            $stmt = $db->prepare("INSERT INTO Ratings (idUser, rating, comment) VALUES (?, ?, ?)");
            $stmt->execute(array($userId, $rating, $comment));

            header("Location: ../pages/user-profile.php?idUser={$userId}#comments");
            exit();
        } 
        catch (Exception $e) {
            $_SESSION['message'] = "Error: " . $e->getMessage();
            header("../pages/index.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid request.";
        header("Location: ../pages/user-profile.php?idUser={$userId}#comments");
        exit();
    }
?>