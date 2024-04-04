<?php
declare(strict_types=1);

require_once 'connection.db.php';
require_once 'order.class.php';
require_once 'item.class.php'; 

class OrderItem {
    public int $idOrderItem;
    public int $idOrder;
    public int $idItem;

    public function __construct(int $idOrderItem, int $idOrder, int $idItem) {
        $this->idOrderItem = $idOrderItem;
        $this->idOrder = $idOrder;
        $this->idItem = $idItem;
    }

    public static function getOrderItemsByOrderId(int $idOrder): array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM OrderItems WHERE idOrder = ?');
        $stmt->execute([$idOrder]);
        $orderItems = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orderItems[] = new OrderItem(
                $row['idOrderItem'],
                $row['idOrder'],
                $row['idItem']
            );
        }
        return $orderItems;
    }

    public function getOrder(): ?Order {
        return Order::getOrderById($this->idOrder);
    }

    public function getItem(): ?Item {
        return Item::getItemById($this->idItem);
    }

}
?>
