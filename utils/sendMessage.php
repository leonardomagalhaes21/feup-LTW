<?php 
declare(strict_types=1);

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
require_once(__DIR__ . '/../database/chats.class.php'); // Importe a classe Chat

require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();

$categories = Category::getCategories($db);
$items = Item::getItems($db, 10); //limitado a 10 items por enquanto

drawHeader($session);
drawCategories($categories);
drawSearchAndFilter();
drawItems($items, $db);

// Buscar e exibir mensagens recebidas e enviadas pelo usuário atual
$userId = $_SESSION['idUser']; // ID do usuário atual
$receivedMessages = Chat::getReceivedMessages($db, $userId); // Busca mensagens recebidas pelo usuário atual
$sentMessages = Chat::getSentMessages($db, $userId); // Busca mensagens enviadas pelo usuário atual

?>

<section>
  <h2>Received Messages</h2>
  <div class="messages">
    <?php foreach ($receivedMessages as $message) { ?>
      <div class="message">
        <p>From: <?php echo User::getUsernameById($db, $message['idSender']); ?></p>
        <p><?php echo $message['message']; ?></p>
      </div>
    <?php } ?>
  </div>
</section>

<section>
  <h2>Sent Messages</h2>
  <div class="messages">
    <?php foreach ($sentMessages as $message) { ?>
      <div class="message">
        <p>To: <?php echo User::getUsernameById($db, $message['idRecipient']); ?></p>
        <p><?php echo $message['message']; ?></p>
      </div>
    <?php } ?>
  </div>
</section>

<?php drawFooter(); ?>
