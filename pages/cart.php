<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../templates/item.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();

$session = new Session();
$cartItems = $session->getCart();

drawHeader($session);

$items = [];
$totalPrice = 0;

foreach ($cartItems as $idItem) {
    $item = Item::getItemById($db, (int)$idItem);
    if ($item) {
        $items[] = $item;
        $totalPrice += $item->price;
    }
}

drawItems($items, $db, false, true);

?>
<section id="cart">
    <h2>Checkout</h2>
    <div class="total-price">
        <p>Total: $<?= number_format($totalPrice, 2) ?></p>
    </div>
    <?php if (count($items) > 0) { ?>
    <a href="../pages/checkout.php">Checkout</a>
    <?php } else { ?>
    <p>Your cart is empty</p>
    <?php } ?>
</section>
<?php

drawFooter();
?>