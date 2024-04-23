<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $categoryName = $_POST['categoryName'] ?? '';
    $category = Category::getCategoryByName($db, $categoryName);
    $category->removeCategory($db, $category->categoryName);
    header("Location: /pages/user-profile.php?idUser=" . $_SESSION['id']);
    exit();
} else {
    exit();
}
?>
