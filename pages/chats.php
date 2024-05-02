<?php 
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    // Verifica se o usuário está logado
    if (!$session->isLoggedIn()) {
        // Redireciona o usuário para a página de login se não estiver logado
        header("Location: ../pages/login.php");
        exit;
    }

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

