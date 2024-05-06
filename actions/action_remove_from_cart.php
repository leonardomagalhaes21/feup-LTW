<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    exit();
}
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        exit();
    }
    if (isset($_POST['idItem'])) {
        $idItem = (int)$_POST['idItem'];

        $db = getDatabaseConnection();
        $session->removeFromCart($idItem);

        header("Location: ../pages/cart.php");
        exit();
    }
}else{
    exit();
}
?>