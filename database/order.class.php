<?php
declare(strict_types=1);

require_once 'connection.db.php';
require_once 'users.class.php';

class Order {
    public int $idOrder;
    public int $idBuyer;
    public float $totalPrice;
    public string $orderDate;
    public string $status;

    public function __construct(int $idOrder, int $idBuyer, float $totalPrice, string $orderDate, string $status) {
        $this->idOrder = $idOrder;
        $this->idBuyer = $idBuyer;
        $this->totalPrice = $totalPrice;
        $this->orderDate = $orderDate;
        $this->status = $status;
    }

    public static function getOrderById(int $idOrder): ?Order {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM Orders WHERE idOrder = ?');
        $stmt->execute([$idOrder]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($order === false) {
            return null;
        }
        return new Order(
            $order['idOrder'],
            $order['idBuyer'],
            $order['totalPrice'],
            $order['orderDate'],
            $order['status']
        );
    }

    public function getBuyer(): ?User {
        return User::getUserById(getDatabaseConnection(), $this->idBuyer);
    }

}
?>
