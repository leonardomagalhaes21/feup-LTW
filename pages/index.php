<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();


    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../database/item.class.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/item.tpl.php');

    $db = getDatabaseConnection();

    $categories = Category::getCategories($db);
    $items = Item::getItems($db, 10); //limitado a 10 items por enquanto

    drawHeader($session);
    drawCategories($categories);
    drawSearchAndFilter();
    drawItems($items);
    drawFooter();
?>