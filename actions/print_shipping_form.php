<?php
declare(strict_types = 1);

if (!isset($_GET['orderId']) || !isset($_GET['itemId'])) {
    header('Location: ../pages/index.php');
    exit();
}



require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$orderId = (int)$_GET['orderId'];
$itemId = (int)$_GET['itemId'];

$query = "SELECT 
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
                O.idOrder = ? AND 
                OI.idItem = ? AND 
                O.status = 'Pending'";
    
$stmt = $db->prepare($query);
$stmt->execute(array($orderId, $itemId));
$order = $stmt->fetch();

if (!$order) {
    header('Location: ../pages/index.php');
    exit();
}

$content = "
    <h1>Shipping Form</h1>
    <h2>Order Details</h2>
    <p>Order ID: {$order['idOrder']}</p>
    <p>Order Date: {$order['orderDate']}</p>
    <p>Item: {$order['itemName']}</p>
    <p>Brand: {$order['brand']}</p>
    <p>Model: {$order['model']}</p>
    <p>Price: {$order['price']}</p>
    <h2>Buyer Information</h2>
    <p>Username: {$order['buyerUsername']}</p>
    <p>Name: {$order['buyerName']}</p>
    <p>Email: {$order['buyerEmail']}</p>
    <h2>Shipping Address</h2>
    <p>{$order['address']}, {$order['city']}, {$order['zipCode']}</p>";

echo $content;

echo '<script>window.print();</script>';
?>