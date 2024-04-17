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

    static function getCategories(PDO $db) : array {
        $stmt = $db->prepare('SELECT * FROM Categories');
        $stmt->execute();
    
        $categories = array();
        
        while ($category = $stmt->fetch()) {
            $categories[] = new Category(
              $category['idCategory'],
              $category['categoryName']
            );
        }

        return $categories;
    }

    public static function getCategoryById(PDO $db, int $idCategory): Category {
        $stmt = $db->prepare('SELECT * FROM Categories WHERE idCategory = ?');
        $stmt->execute([$idCategory]);

        $category = $stmt->fetch();

        if ($category === false) {
            return null;
        }
        
        return new Category($category['idCategory'], $category['categoryName']);
    }
}
?>
