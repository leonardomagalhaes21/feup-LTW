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
    public int $idCategory;
    public ?string $brand;
    public ?string $model;
    public int $idSize;
    public int $idCondition;
    public float $price;
    public bool $active;

    public function __construct(int $idItem, int $idSeller, string $name, ?string $introduction, ?string $description, int $idCategory, ?string $brand, ?string $model, int $idSize, int $idCondition, float $price, bool $active) {
        $this->idItem = $idItem;
        $this->idSeller = $idSeller;
        $this->name = $name;
        $this->introduction = $introduction;
        $this->description = $description;
        $this->idCategory = $idCategory;
        $this->brand = $brand;
        $this->model = $model;
        $this->idSize = $idSize;
        $this->idCondition = $idCondition;
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
            (int) $item['idCategory'],
            $item['brand'],
            $item['model'],
            (int) $item['idSize'],
            (int) $item['idCondition'],
            $item['price'],
            (bool) $item['active']
          );
        }
    
        return $items;
    }

    public static function getItemById(PDO $db ,int $idItem): ?Item { // mudar estes nulls
        $stmt = $db->prepare('SELECT * FROM Items WHERE idItem = ?');
        $stmt->execute(array($idItem));

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
            (int) $item['idCategory'],
            $item['brand'],
            $item['model'],
            (int) $item['idSize'],
            (int) $item['idCondition'],
            $item['price'],
            (bool) $item['active']
        );
    }

    public function getSeller(): ?User {
        return User::getUserById(getDatabaseConnection(), $this->idSeller);
    }

}
?>
