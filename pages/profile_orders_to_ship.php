<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$userId = (int)$_SESSION['id'];

$query =    "SELECT 
                O.idOrder,
                O.orderDate,
                CI.address,
                CI.city,
                CI.zipCode,
                OI.idItem,
                I.name AS itemName,
                I.brand,
                I.model,
                I.price,
                U.idUser AS buyerId,
                U.username AS buyerUsername,
                U.name AS buyerName,
                U.email AS buyerEmail
            FROM 
                Orders O
            JOIN 
                CheckoutInfo CI ON O.idOrder = CI.idOrder
            JOIN 
                OrderItems OI ON O.idOrder = OI.idOrder
            JOIN 
                Items I ON OI.idItem = I.idItem
            JOIN 
                Users U ON O.idBuyer = U.idUser
            WHERE 
                I.idSeller = ? AND
                O.status = 'Pending'";

$stmt = $db->prepare($query);
$stmt->execute(array($userId));
$orders = $stmt->fetchAll();

foreach ($orders as $order) {
    $orderId = $order['idOrder'];
    $itemId = $order['idItem'];

    echo "<h2>Shipping Form for Order #{$orderId}</h2>";
    echo "<p>Item: <a href='../pages/item.php?idItem={$order['idItem']}'>{$order['itemName']}</a></p>";
    echo "<p>Price: {$order['price']}</p>";
    echo "<p>Buyer: <a href='../pages/user-profile.php?idUser={$order['buyerId']}'>{$order['buyerName']}</a></p>";
    ?>
    <a href="../actions/print_shipping_form.php?orderId=<?= $order['idOrder'] ?>&itemId=<?= $order['idItem'] ?>" target="_blank">Print Shipping Form</a>
<?php } ?>



