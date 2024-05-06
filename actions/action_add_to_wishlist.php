<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        exit();
    }
    if (isset($_POST['idItem'])) {
        $idItem = (int)$_POST['idItem'];

        $db = getDatabaseConnection();
        Item::addToWishlist($db, $_SESSION['id'] , $idItem);

        header("Location: ../pages/index.php");
        exit();
    }
}else{
    exit();
}

?>