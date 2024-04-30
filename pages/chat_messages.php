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
    <header><?php
            $otherUser = User::getUserById($db, (int)$otherUserId);
            $otherUserImage = $otherUser->getProfileImage($db);
            $item = Item::getItemById($db, (int)$itemId);
            if ($otherUserImage) {
                echo "<a href='../pages/user-profile.php?idUser={$otherUserId}'><img src='{$otherUserImage}' alt='User Image'></a>";
            } 
            else {
                echo "<a href='../pages/user-profile.php?idUser={$otherUserId}'><img src='../docs/images/default_profile_picture.png' alt='User Image'></a>";
            }
            ?>
        <div>
            <h3>Chat with <?=User::getUserById($db,(int) $otherUserId)->name?></h3>
            <h4><?=$item->name?></h4>
        </div>
    </header>
        <?php foreach ($chats as $chat) { ?>
            <div class="message_<?php echo $chat['idSender'] === $userId ? 'outgoing' : 'incoming'; ?>">
                <h4><?= htmlentities(User::getUserById($db, $chat['idSender'])->name) ?></h4>
                <p class="message_content"><?= htmlentities($chat['message']) ?></p>
                <p class="hint"><?= htmlentities(date('d/m/Y H:i', strtotime($chat['timestamp']))) ?></p>
            </div>
        <?php } ?>   
        <form action="../actions/action_send_message.php" method="post" class="message-form">
            <input type="hidden" name="otherUserId" value="<?php echo $otherUserId; ?>">
            <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">
            <div class="message-input">
                <input type="text" name="message" placeholder="Type your message here..." required>
                <button type="submit"><img src="../docs/images/icon_send.svg" alt="Send"></button>
            </div>
        </form>

</section>

<?php drawFooter(); ?>
