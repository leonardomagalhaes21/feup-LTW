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

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/item.tpl.php');

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



    drawHeader($session, ['shipping-form']);
    drawPrintShippingForm($order, $shippingAddress, $qrCode);
    drawFooter();

?>



