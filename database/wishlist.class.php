<?php
declare(strict_types=1);

require_once 'connection.db.php';
require_once 'users.class.php'; 
require_once 'item.class.php'; 

class Wishlist {
    public int $idWishlist;
    public int $idUser;
    public int $idItem;

    public function __construct(int $idWishlist, int $idUser, int $idItem) {
        $this->idWishlist = $idWishlist;
        $this->idUser = $idUser;
        $this->idItem = $idItem;
    }

    public static function getWishlistByUserId(int $idUser): array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM Wishlists WHERE idUser = ?');
        $stmt->execute([$idUser]);
        $wishlists = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $wishlists[] = new Wishlist(
                $row['idWishlist'],
                $row['idUser'],
                $row['idItem']
            );
        }
        return $wishlists;
    }

    public function getUser(): ?User {
        return User::getUserById(getDatabaseConnection(), $this->idUser);
    }

    public function getItem(): ?Item {
        return Item::getItemById($this->idItem);
    }
    
}
?>
