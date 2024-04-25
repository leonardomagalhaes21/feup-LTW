<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idOrder = (int) $_POST['idOrder'];
    $stmt = $db->prepare("UPDATE Orders SET status = 'Canceled' WHERE idOrder = ?");
    $stmt->execute(array($idOrder));
        
    header("Location: ../pages/index.php");
    exit();

}else{
    exit();
}

?>