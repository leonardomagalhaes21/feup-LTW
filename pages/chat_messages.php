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
require_once(__DIR__ . '/../database/users.class.php'); // Adicionado para buscar o nome do remetente
require_once(__DIR__ . '/../database/chats.class.php'); // Importa a classe Chat

require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();

$categories = Category::getCategories($db);

drawHeader($session);
drawCategories($categories);

// Buscar e exibir mensagens agrupadas por chat
$userId = $session->getId(); // ID do usuário atual
$otherUserId = $_GET['otherUserId'];
$itemId = $_GET['itemId'];
$chats = Chat::getChatByUserAndItem($db, (int)$userId, (int)$otherUserId, (int)$itemId);

?>

<section class="chat">
    <?php
        if (isset($_SESSION['message'])) {
            echo "<p>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
        }
    ?>
    <div class="chat-messages">
        <?php foreach ($chats as $chat): ?>
            <div class="message <?php echo $chat['idSender'] === $userId ? 'outgoing' : 'incoming'; ?>">
                <div class="message-content">
                    <h4><?=User::getUserById($db, $chat['idSender'])->name?></h4>
                    <p><?=$chat['message']?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <form action="../actions/action_send_message.php" method="post" class="message-form">
        <input type="hidden" name="otherUserId" value="<?php echo $otherUserId; ?>">
        <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">
        <input type="text" name="message" placeholder="Type your message here..." required>
        <button type="submit">Send</button>
    </form>
</section>

<?php drawFooter(); ?>
