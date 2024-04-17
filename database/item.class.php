<?php
declare(strict_types=1);

require_once 'connection.db.php';
require_once 'category.class.php';
require_once 'size.class.php';
require_once 'condition.class.php';
require_once 'users.class.php'; 

class Item {
    public int $idItem;
    public int $idSeller;
    public string $name;
    public ?string $introduction;
    public ?string $description;
    public ?Category $category;
    public ?string $brand;
    public ?string $model;
    public ?Size $size;
    public ?Condition $condition;
    public float $price;
    public bool $active;

    public function __construct(int $idItem, int $idSeller, string $name, ?string $introduction, ?string $description, ?Category $category, ?string $brand, ?string $model, ?Size $size, ?Condition $condition, float $price, bool $active) {
        $this->idItem = $idItem;
        $this->idSeller = $idSeller;
        $this->name = $name;
        $this->introduction = $introduction;
        $this->description = $description;
        $this->category = $category;
        $this->brand = $brand;
        $this->model = $model;
        $this->size = $size;
        $this->condition = $condition;
        $this->price = $price;
        $this->active = $active;
    }

    static function getItems(PDO $db, int $count) : array {
        $stmt = $db->prepare('SELECT * FROM Items LIMIT ?');
        $stmt->execute(array($count));
    
        $items = array();
        while ($item = $stmt->fetch()) {
          $items[] = new Item(
            $item['idItem'],
            $item['idSeller'],
            $item['name'],
            $item['introduction'],
            $item['description'],
            null,
            $item['brand'],
            $item['model'],
            null,
            null,
            $item['price'],
            true
          );
        }
    
        return $items;
    }

    public static function getItemById(int $idItem): ?Item {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM Items WHERE idItem = ?');
        $stmt->execute([$idItem]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($item === false) {
            return null;
        }
        return new Item(
            $item['idItem'],
            $item['idSeller'],
            $item['name'],
            $item['introduction'],
            $item['description'],
            Category::getCategoryById($item['idCategory']),
            $item['brand'],
            $item['model'],
            Size::getSizeById($item['idSize']),
            Condition::getConditionById($item['idCondition']),
            $item['price'],
            $item['active']
        );
    }

    public function getSeller(): ?User {
        return User::getUserById(getDatabaseConnection(), $this->idSeller);
    }

}
?>
