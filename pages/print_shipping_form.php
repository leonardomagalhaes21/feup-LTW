<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!isset($_GET['orderId']) || !isset($_GET['itemId'])) {
    header('Location: ../pages/index.php');
    exit();
}



require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$orderId = (int)$_GET['orderId'];
$itemId = (int)$_GET['itemId'];
if ($_SESSION['csrf'] !== $_GET['csrf']) {
    exit();
}

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

$shippingAddress = htmlentities($order['address']) . ", " . htmlentities($order['city']) . ", " . htmlentities($order['zipCode']);
$qrCode = "http://api.qrserver.com/v1/create-qr-code/?data=". urlencode($shippingAddress) . "&size=300x300"; // goqr.me api

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Form</title>
    <link rel="icon" href="../docs/images/REuse-mini.png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../javascript/shipping_form.js" defer></script>
</head>
<body id="print-shipping-form">
    <div id="shipping-form">

        <div class="shipping-order-details"> 
            <h1>Shipping Form</h1>
            <h2>Order Details</h2>
            <p><strong>Order ID:</strong> <?= $order['idOrder'] ?></p>
            <p><strong>Order Date:</strong> <?= htmlentities($order['orderDate']) ?></p>
            <p><strong>Item:</strong> <?= htmlentities($order['itemName']) ?></p>
            <p><strong>Brand:</strong> <?= htmlentities($order['brand']) ?></p>
            <p><strong>Model:</strong> <?= htmlentities($order['model']) ?></p>
            <p><strong>Price:</strong> $<?= htmlentities((string)$order['price']) ?></p>
            <h2>Buyer Information</h2>
            <p><strong>Username:</strong> <?= htmlentities($order['buyerUsername']) ?></p>
            <p><strong>Name:</strong> <?= htmlentities($order['buyerName']) ?></p>
            <p><strong>Email:</strong> <?= htmlentities($order['buyerEmail']) ?></p>
        </div>
        <div class="shipping-address">
            <h2>Shipping Address</h2>
            <p><?= $shippingAddress ?></p>
            <img src="<?= $qrCode ?>" alt="Shipping Address QR Code">
        <div>
    </div>
</body>
</html>