<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

$db = getDatabaseConnection();

$message = '';

$idItem = Item::getHighestItemId($db) + 1;
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$introduction = $_POST['introduction'] ?? '';
$brand = $_POST['brand'] ?? '';
$model = $_POST['model'] ?? '';
$price = intval($_POST['price'] ?? 0);
$idCategory = intval($_POST['idCategory'] ?? 0);
$idCondition = intval($_POST['idCondition'] ?? 0);
$idSize = intval($_POST['idSize'] ?? 0);
$idSeller = intval($_SESSION['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $targetDir = "../docs/itemImages/";
    $imageName = uniqid() . '_' . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $imageName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['message'] = "File is not an image.";
        header("Location: ../pages/add_publication.php");
        exit();
    }

    if ($_FILES["image"]["size"] > 500000) {
        $_SESSION['message'] = "Your file is too large.";
        header("Location: ../pages/add_publication.php");
        exit();
    }

    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    ) {
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG files are allowed.";
        header("Location: ../pages/add_publication.php");
        exit();
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $_SESSION['message'] = "Sorry, there was an error uploading your file.";
        header("Location: ../pages/add_publication.php");
        exit();
    }
}

try {
    $stmt = $db->prepare('INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition, price, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($idSeller, $name, $introduction, $description, $idCategory, $brand, $model, $idSize, $idCondition, $price, true));

    $lastInsertedItemId = $db->lastInsertId();

    $stmt = $db->prepare('INSERT INTO Images (imagePath) VALUES (?)');
    $stmt->execute(array($targetFile));

    $lastInsertedImageId = $db->lastInsertId();

    $stmt = $db->prepare('INSERT INTO ItemImages (idItem, idImage, isMain) VALUES (?, ?, ?)');
    $stmt->execute(array($lastInsertedItemId, $lastInsertedImageId, true));

    header("Location: ../pages/index.php");
} catch (PDOException $e) {
    $_SESSION['message'] = "Error adding item: " . $e->getMessage();
    header("Location: ../pages/add_publication.php");
}
?>