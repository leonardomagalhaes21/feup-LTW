<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/order.class.php');
?>

<?php function drawOrders(array $orders, PDO $db) { ?>
    <section id="orders">
        <?php foreach ($orders as $order) {
            $items = $order->getItems($db);
            $buyer = $order->getBuyer();
            $date = htmlentities((string)$order->orderDate);
            $status = htmlentities((string)$order->status);
            ?>
            <article>
                <h2>Order #<?= $order->idOrder ?></h2>
                <p>Date: <?= $date ?></p>
                <p>Status: <span class="status <?= strtolower($status) ?>"><?= $status ?></span></p>
                <p>Total price: <?= htmlentities((string)$order->totalPrice) ?>€</p>
                <ul>
                    <?php foreach ($items as $item) { ?>
                        <?php
                        $quantity = array_count_values(array_map(function ($item) {
                            return $item->idItem;
                        }, $items));
                        ?>

                        <li> <a href="../pages/item.php?idItem=<?= $item->idItem ?>"><?= htmlentities($item->name) ?></a> x <?= $quantity[$item->idItem] ?> (<?= $item->price * $quantity[$item->idItem] ?>€)</li>
                    <?php } ?>
                </ul>
                <?php if($status === 'Pending') { ?>
                <form action="../actions/action_cancel_order.php" method="post">
                    <input type="hidden" name="idOrder" value="<?= $order->idOrder ?>">
                    <button type="submit">Cancel Order</button>
                </form>
                <?php } ?>
            </article>
        <?php } ?>
    </section>
<?php } ?>