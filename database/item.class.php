<?php
declare(strict_types=1);

require_once 'connection.db.php';
require_once 'category.class.php';
require_once 'size.class.php';
require_once 'condition.class.php';
require_once 'users.class.php'; 

class Item {
    public int $idItem;
    public ?int $idSeller;
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

    public static function getHighestItemId(PDO $db): int {
        $stmt = $db->prepare('SELECT MAX(idItem) FROM Items');
        $stmt->execute();
        $maxId = $stmt->fetch();
        if (!empty($maxId) && isset($maxId[0])) {
            return (int) $maxId[0];
        } else {
            return 0;
        }
    }

    public function getMainImage(PDO $db) {
        $stmt = $db->prepare('SELECT Images.imagePath 
                              FROM Images 
                              JOIN ItemImages ON Images.idImage = ItemImages.idImage 
                              WHERE ItemImages.idItem = ? AND ItemImages.isMain = 1');
        $stmt->execute(array($this->idItem));
        $mainImage = $stmt->fetch();
        return $mainImage ? $mainImage['imagePath'] : null;
    }

    function getSecondaryImages(PDO $db) {
        $stmt = $db->prepare('SELECT Images.imagePath 
                                FROM Images 
                                JOIN ItemImages ON Images.idImage = ItemImages.idImage 
                                WHERE ItemImages.idItem = ? AND ItemImages.isMain = 0');
        $stmt->execute(array($this->idItem));
        $images = $stmt->fetchAll();
    
        return $images;
    }

    public static function searchItems(PDO $db, $search, $category, $size, $condition, $order) {
        $query = "SELECT * FROM Items WHERE name LIKE ?";
        $search = $search . '%';
        $parameters = array($search);
        if ($category != 'all') {
            $query = $query .  " AND idCategory = ?";
            $parameters[] = $category;
        }
        if ($size != 'all') {
            $query = $query . " AND idSize = ?";
            $parameters[] = $size;
        }
        if ($condition != 'all') {
            $query = $query . " AND idCondition = ?";
            $parameters[] = $condition;
        }

        if ($order == 'price_asc') {
            $query = $query . " ORDER BY price ASC";
        } elseif ($order == 'price_desc') {
            $query = $query . " ORDER BY price DESC";
        }

        $stmt = $db->prepare($query);
        $stmt->execute($parameters);

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

    public function save(PDO $db) {
        $stmt = $db->prepare('INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition, price, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute(array($this->idSeller, $this->name, $this->introduction, $this->description, $this->idCategory, $this->brand, $this->model, $this->idSize, $this->idCondition, $this->price, $this->active));
    }
}
?>
