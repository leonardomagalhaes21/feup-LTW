<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    if (!$session->isLoggedIn()) 
        header('Location: ../pages/login.php');


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
                    I.idSeller = ?";
    
    $stmt = $db->prepare($query);
    $stmt->execute(array($userId));
    $orders = $stmt->fetchAll();

    echo json_encode($orders);
?>