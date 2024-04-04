<?php
declare(strict_types=1);

require_once 'connection.db.php';

class Category {
    public int $idCategory;
    public string $categoryName;

    public function __construct(int $idCategory, string $categoryName) {
        $this->idCategory = $idCategory;
        $this->categoryName = $categoryName;
    }

    public static function getCategoryById(int $idCategory): ?Category {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM Categories WHERE idCategory = ?');
        $stmt->execute([$idCategory]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($category === false) {
            return null;
        }
        return new Category($category['idCategory'], $category['categoryName']);
    }
}
?>
