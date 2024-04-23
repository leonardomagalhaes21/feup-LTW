<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/users.class.php');
require_once (__DIR__ . '/../database/item.class.php');
require_once (__DIR__ . '/../database/order.class.php'); 

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/users.tpl.php');
require_once(__DIR__ . '/../templates/item.tpl.php');
require_once(__DIR__ . '/../templates/order.tpl.php');

$db = getDatabaseConnection();

$userId = $session->getId();

$user = User::getUserById($db, $userId);

$orders = Item::getOrdersFromUser($db, $userId);

drawOrders($orders, $db);


?>