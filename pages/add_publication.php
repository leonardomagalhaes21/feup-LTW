<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/size.class.php');
require_once(__DIR__ . '/../database/condition.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();
drawHeader($session);

$categories = Category::getCategories($db);
$sizes = Size::getSizes($db);
$conditions = Condition::getConditions($db);

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idItem = Item::getHighestItemId($db) + 1;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $introduction = $_POST['introduction'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';
    $price = intval($_POST['price'] ?? 0);
    $idCategory = intval($_POST['idCategory'] ?? 0);
    $idCondition = intval($_POST['idCondition'] ?? 0);
    $idSize = intval($_POST['idSize'] ?? 0);
    $idSeller = intval($_SESSION['id']);
    
    $newItem = new Item($idItem, $idSeller, $name, $introduction, $description, $idCategory, $brand, $model, $idSize, $idCondition, $price, true);

    if ($newItem->save($db)) {
        $message = "Item added successfully!";
    } else {
        $message = "Error adding item!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Publication</title>
</head>
<body>
    <h1>Add New Publication</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description"><br>
        <label for="introduction">Introduction:</label><br>
        <input type="text" id="introduction" name="introduction"><br>
        <label for="brand">Brand:</label><br>
        <input type="text" id="brand" name="brand"><br>
        <label for="model">Model:</label><br>
        <input type="text" id="model" name="model"><br>
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price"><br>
        <label for="idCategory">Category:</label><br>
        <select id="idCategory" name="idCategory">
            <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category->idCategory; ?>"><?php echo $category->categoryName; ?></option>
            <?php } ?>
        </select><br>
        <label for="idCondition">Condition:</label><br>
        <select id="idCondition" name="idCondition">
            <?php foreach ($conditions as $condition) { ?>
                <option value="<?php echo $condition->idCondition; ?>"><?php echo $condition->conditionName; ?></option>
            <?php } ?>
        </select><br>
        <label for="idSize">Size:</label><br>
        <select id="idSize" name="idSize">
            <?php foreach ($sizes as $size) { ?>
                <option value="<?php echo $size->idSize; ?>"><?php echo $size->sizeName; ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" value="Submit">
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>
