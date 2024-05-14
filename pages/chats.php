<?php 
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if(!$session->isLoggedIn()) 
        die(header('Location: ../pages/login.php'));

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../database/chats.class.php'); // Importa a classe Chat

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/chat.tpl.php');

    $db = getDatabaseConnection();

    $categories = Category::getCategories($db);
    // Buscar e exibir mensagens agrupadas por chat
    $userId = $session->getId(); // ID do usuário atual
    $pairs = Chat::getUsersChats($db, (int) $userId);

    drawHeader($session);
    drawCategories($categories);
    drawChats($pairs, $db);
    drawFooter();

?>

