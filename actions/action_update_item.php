<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    exit();
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idItem'])) {
    $itemId = intval($_POST['idItem']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $brand = $_POST['brand'];
    $category = intval($_POST['category']);
    $model = $_POST['model'];
    $condition = intval($_POST['condition']);

    $item = Item::getItemById($db, $itemId);

    if ($item) {
        $item->name = $name;
        $item->description = $description;
        $item->price = $price;
        $item->brand = $brand;
        $item->idCategory = $category;
        $item->model = $model;
        $item->idCondition = $condition;

        Item::updateItem($db, $item);

        header("Location: ../pages/item.php?idItem=$itemId");
        exit;
    } else {
        header("Location: ../pages/index.php");
        exit;
    }
} else {
    header("Location: ../pages/add_publication.php");
    exit;
}
?>
