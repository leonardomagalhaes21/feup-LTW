<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $categoryName = $_POST['categoryName'] ?? '';

    if (empty($categoryName)) {
        exit();
    }

    try {
        $category = new Category($categoryName);

        $category->save(getDatabaseConnection());
        header("Location: /pages/user-profile.php?idUser=" . $_SESSION['id']);
        exit();
    } catch (PDOException $e) {
        exit();
    }
} else {
    exit();
}
?>
