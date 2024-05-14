<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) 
    die(header('Location: ../pages/login.php'));

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
<body>
    <div id="shipping-form">
        <table>
            <thead>
                <tr>
                    <th colspan="4">Shipping Form</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><h2>Order Details</h2></td>
                    <td colspan="2"><h2>Buyer Information</h2></td>
                </tr>
                <tr>
                    <td><strong>Order ID:</strong></td>
                    <td><?= $order['idOrder'] ?></td>
                    <td><strong>Username:</strong></td>
                    <td><?= htmlentities($order['buyerUsername']) ?></td>
                </tr>
                <tr>
                    <td><strong>Order Date:</strong></td>
                    <td><?= htmlentities($order['orderDate']) ?></td>
                    <td><strong>Name:</strong></td>
                    <td><?= htmlentities($order['buyerName']) ?></td>
                </tr>
                <tr>
                    <td><strong>Item:</strong></td>
                    <td><?= htmlentities($order['itemName']) ?></td>
                    <td><strong>Email:</strong></td>
                    <td><?= htmlentities($order['buyerEmail']) ?></td>
                </tr>
                <tr>
                    <td><strong>Brand:</strong></td>
                    <td><?= htmlentities($order['brand']) ?></td>
                    <th colspan="2">Shipping Address</th>
                </tr>
                <tr>
                    <td><strong>Model:</strong></td>
                    <td><?= htmlentities($order['model']) ?></td>
                    <td colspan="2" rowspan="2"><?= $shippingAddress ?></td>
                </tr>
                <tr>
                    <td><strong>Price:</strong></td>
                    <td>$<?= htmlentities((string)$order['price']) ?></td>
                </tr>
            </tbody>
        </table>
        <img src="<?= $qrCode ?>" alt="Shipping Address QR Code">
    </div>
</body>
</html>


