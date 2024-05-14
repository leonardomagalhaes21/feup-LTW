<?php 
declare(strict_types = 1); 

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) 
    die(header('Location: ../pages/login.php'));

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/users.class.php'); // Adicionado para buscar o nome do remetente
require_once(__DIR__ . '/../database/chats.class.php'); // Importa a classe Chat

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/chat.tpl.php');

$db = getDatabaseConnection();

$categories = Category::getCategories($db);
$userId = $session->getId(); // ID do usuário atual
$otherUserId = $_GET['otherUserId'];
$itemId = $_GET['itemId'];
$chats = Chat::getChatByUserAndItem($db, (int)$userId, (int)$otherUserId, (int)$itemId);


drawHeader($session, ['chat']);
drawCategories($categories);
drawChatMessages($db, $chats, $userId, $otherUserId, $itemId);
drawFooter();
?>

<script>
    const otherUserId = <?= $otherUserId ?>;
    const itemId = <?= $itemId ?>;
    const userId = <?= $userId ?>;
</script>
