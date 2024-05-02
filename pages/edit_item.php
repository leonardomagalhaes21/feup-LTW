<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/item.tpl.php');

$db = getDatabaseConnection();
drawHeader($session);
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idItem'])) {
    $itemId = intval($_GET['idItem']);

    $item = Item::getItemById($db, $itemId);
    

    if ($item) {
        drawEditItem($item);
        drawFooter();
    } else {
        header("Location: ../pages/index.php");
        exit;
    }
}else {
    echo "Error";
    exit;
}
?>
