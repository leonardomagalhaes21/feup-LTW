<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();


    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../database/size.class.php');
    require_once(__DIR__ . '/../database/condition.class.php');
    require_once(__DIR__ . '/../database/item.class.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/item.tpl.php');

    $db = getDatabaseConnection();

    $categories = Category::getCategories($db);
    $sizes = Size::getSizes($db);
    $conditions = Condition::getConditions($db);
    $items = Item::getItems($db, 10); //limitado a 10 items por enquanto

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        
        $search = isset($_GET["search"]) ? $_GET["search"] : '';
        $category = isset($_GET["category"]) ? $_GET["category"] : 'all';
        $size = isset($_GET["size"]) ? $_GET["size"] : 'all';
        $condition = isset($_GET["condition"]) ? $_GET["condition"] : 'all';
        $order = isset($_GET["order"]) ? $_GET["order"] : 'default';

        $items = Item::searchItems($db, $search, $category, $size, $condition, $order);
    } 
    else {
        $items = Item::getItems($db, 10);
    }

    drawHeader($session);
    drawCategories($categories);
    drawSearchAndFilter($categories, $sizes, $conditions);
    drawItems($items, $db, true);
    drawFooter();
?>