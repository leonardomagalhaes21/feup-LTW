<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['idItem'])) {
        $idItem = (int)$_POST['idItem'];

        $db = getDatabaseConnection();
        Item::removeFromWishlist($db, $_SESSION['id'],$idItem);
        
        header("Location: /pages/user-profile.php");
        exit();
    }
}else{
    header("Location: /pages/user-profile.php");
    exit();
}