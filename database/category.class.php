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

    static function getCategories(PDO $db): array {
        try {
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
        } catch (PDOException $e) {
            echo "Error fetching categories: " . $e->getMessage();
            return array(); 
        }
    }
    

    public static function getCategoryById(PDO $db, int $idCategory): ?Category {
        $stmt = $db->prepare('SELECT * FROM Categories WHERE idCategory = ?');
        $stmt->execute([$idCategory]);

        $category = $stmt->fetch();

        if ($category === false) {
            return null;
        }
        
        return new Category($category['idCategory'], $category['categoryName']);
    }
    public function save(PDO $db): void {
        try {
            // Check if the category already exists in the database
            $existingCategory = self::getCategoryById($db, $this->idCategory);
    
            if ($existingCategory) {
                // If the category already exists, update its details
                $stmt = $db->prepare('UPDATE Categories SET categoryName = ? WHERE idCategory = ?');
                $stmt->execute([$this->categoryName, $this->idCategory]);
            } else {
                // If the category doesn't exist, insert a new record
                $stmt = $db->prepare('INSERT INTO Categories (categoryName) VALUES (?)');
                $stmt->execute([$this->categoryName]);
            }
        } catch (PDOException $e) {
            // Handle any database errors here (you might want to log or display the error)
            echo "Error saving category: " . $e->getMessage();
        }
    }
    
}
?>
