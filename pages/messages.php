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
$userId = $_SESSION['id']; // ID do usuário atual
$chats = Chat::getMessagesInvolvingUser($db, $userId); // Obtém as mensagens para o chat atual

?>

<section>
    <h2>Messages</h2>
    <div class="messages">
        <?php foreach ($chats as $chatData) { ?>
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
