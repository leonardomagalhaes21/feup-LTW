<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/item.class.php');

    $db = getDatabaseConnection();

    $cart = $session->getCart();

    $cartItems = array();

    foreach ($cart as $itemId) {
        $item = Item::getItemById($db, $itemId);
        if ($item) {
            $cartItems[] = array(
                'id' => $item->idItem,
                'name' => $item->name,
                'price' => $item->price
            );
        }
    }

    echo json_encode($cartItems);
?>