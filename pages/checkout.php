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
        if ($item->active) {
            $items[] = $item;
            $totalPrice += $item->price;
        } else {
            $session->removeFromCart($item->idItem);
        }
    }
}
?>

<section id="checkout">
    <h2>Checkout</h2>
    <div class="total-price">
        <p>Total: $<?= htmlentities((string)number_format($totalPrice, 2)) ?></p>
    </div>
    <form action="../actions/action_complete_order.php" method="post" value="<?=$_SESSION['csrf']?>">
        <label>
            Address: <input type="text" id="address" name="address" required>
        </label><br>
        <label>
            City: <input type="text" id="city" name="city" required>
        </label><br>
        <label>
            Zip Code: <input type="text" id="zipcode" name="zipcode" required>
        </label><br>
        <label>
            Payment Method:
            <select id="payment_method" name="payment_method" required>
                <option value="credit_card">Credit Card</option>
                <option value="mbway">MBWay</option>
                <option value="paypal">PayPal</option>
            </select>
        </label><br>
        <input type="hidden" name="total_price" value="<?= htmlentities((string)$totalPrice) ?>">
        <button type="submit">Complete Order</button>
    </form>

</section>

<?php
drawFooter();
?>
