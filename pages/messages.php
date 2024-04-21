<?php 
declare(strict_types = 1); 

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/users.class.php'); // Adicionado para buscar o nome do remetente
require_once(__DIR__ . '/../database/chats.class.php'); // Importa a classe Chat

require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();

$categories = Category::getCategories($db);
$items = Item::getItems($db, 10); //limitado a 10 items por enquanto

drawHeader($session);
drawCategories($categories);

// Buscar e exibir mensagens agrupadas por chat
$userId = $_SESSION['idUser']; // ID do usuário atual
$chats = []; // Array para armazenar os chats

// Busca mensagens recebidas e enviadas pelo usuário atual
$receivedMessages = Chat::getReceivedMessages($db, $userId);
$sentMessages = Chat::getSentMessages($db, $userId);

// Agrupa as mensagens por chat
foreach ($receivedMessages as $message) {
    $chatId = $message['idChat'];
    if (!isset($chats[$chatId])) {
        // Se este chat ainda não foi adicionado ao array, adiciona-o
        $chats[$chatId] = ['messages' => [], 'participants' => []];
    }
    $chats[$chatId]['messages'][] = $message;
    $chats[$chatId]['participants'][] = $message['idSender']; // Adiciona o remetente como participante do chat
}

foreach ($sentMessages as $message) {
    $chatId = $message['idChat'];
    if (!isset($chats[$chatId])) {
        // Se este chat ainda não foi adicionado ao array, adiciona-o
        $chats[$chatId] = ['messages' => [], 'participants' => []];
    }
    $chats[$chatId]['messages'][] = $message;
    $chats[$chatId]['participants'][] = $message['idRecipient']; // Adiciona o destinatário como participante do chat
}

?>

<section>
    <h2>Messages</h2>
    <div class="messages">
        <?php foreach ($chats as $chatId => $chatData) { ?>
            <div class="chat">
                <?php foreach ($chatData['messages'] as $message) { ?>
                    <div class="message">
                        <p>From: <?php echo User::getUsernameById($db, $message['idSender']); ?></p>
                        <p><?php echo $message['message']; ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<?php drawFooter(); ?>
