<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();
drawHeader($session);
drawFooter();
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idItem'])) {
    $itemId = intval($_GET['idItem']);

    $item = Item::getItemById($db, $itemId);
    

    if ($item) {
        ?>
        <html>
        <head>
            <title>Edit Item</title>
        </head>
        <body>
            <h2>Edit Item</h2>
            <form action="../actions/action_update_item.php" method="post">
                <input type="hidden" name="idItem" value="<?php echo $item->idItem; ?>">
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" value="<?php echo $item->name; ?>"><br>
                <label for="description">Description:</label><br>
                <input type="text" id="description" name="description" value="<?php echo $item->description; ?>"><br>
                <label for="price">Price:</label><br>
                <input type="number" id="price" name="price" value="<?php echo $item->price; ?>"><br>
                <label for="brand">Brand:</label><br>
                <input type="text" id="brand" name="brand" value="<?php echo $item->brand; ?>"><br>
                <label for="category">Category:</label><br>
                <input type="text" id="category" name="category" value="<?php echo $item->idCategory; ?>"><br>
                <label for="model">Model:</label><br>
                <input type="text" id="model" name="model" value="<?php echo $item->model; ?>"><br>
                <label for="condition">Condition:</label><br>
                <input type="text" id="condition" name="condition" value="<?php echo $item->idCondition; ?>"><br>
                <button type="submit">Save Changes</button>
            </form>
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
