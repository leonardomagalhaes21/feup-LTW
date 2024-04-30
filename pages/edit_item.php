<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();
drawHeader($session);
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idItem'])) {
    $itemId = intval($_GET['idItem']);

    $item = Item::getItemById($db, $itemId);
    

    if ($item) {
        ?>
        <body>
            <section id="edit-item"> 
                <h2>Edit Item</h2>
                <form id="edit-item-form" action="../actions/action_update_item.php" method="post" onsubmit="return validateEditItemForm()">
                    <input type="hidden" name="idItem" value="<?= $item->idItem ?>">
                    <label for="name">Name:
                        <input type="text" id="name" name="name" value="<?= htmlentities($item->name) ?>">
                    </label><br>
                    <label for="description">Description:
                        <input type="text" id="description" name="description" value="<?= htmlentities($item->description) ?>">
                    </label><br>
                    <label for="price">Price:
                        <input type="number" id="price" name="price" value="<?= htmlentities((string)$item->price) ?>">
                    </label><br>
                    <label for="brand">Brand:
                        <input type="text" id="brand" name="brand" value="<?= htmlentities($item->brand) ?>">
                    </label><br>
                    <label for="category">Category:
                        <input type="text" id="category" name="category" value="<?= $item->idCategory ?>">
                    </label><br>
                    <label for="model">Model:
                        <input type="text" id="model" name="model" value="<?= htmlentities($item->model) ?>">
                    </label><br>
                    <label for="condition">Condition:
                        <input type="text" id="condition" name="condition" value="<?= $item->idCondition ?>">
                    </label><br>
                    <button type="submit">Save Changes</button>
                </form>
            </section>
        </body>
        </html>
        <?php
    } else {
        header("Location: ../pages/index.php");
        exit;
    }
}else {
    echo "Error";
    exit;
}
?>
