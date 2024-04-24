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
    $userId = $session->getId(); // ID do usuário atual
    $pairs = Chat::getUsersChats($db, (int) $userId);

?>

    <section class="chats">
        <h2>Chats</h2>
        <?php
            foreach ($pairs as $pair) {
                echo "<article>";
                $otherUserId = (int)$pair['otherUserId'];
                $itemId = (int)$pair['idItem'];

                $otherUser = User::getUserById($db, $otherUserId);
                $item = Item::getItemById($db, $itemId);
                $otherUserImage = $otherUser->getProfileImage($db);
                if ($otherUserImage) {
                    echo "<a href='../pages/chat_messages.php?otherUserId={$otherUserId}&itemId={$itemId}'><img src='{$otherUserImage}' alt='User Image'></a>";
                } 
                else {
                    echo "<a href='../pages/chat_messages.php?otherUserId={$otherUserId}&itemId={$itemId}'><img src='../docs/images/default_profile_picture.png' alt='User Image'></a>";
                }

                echo "<a class='user_select' href='../pages/chat_messages.php?otherUserId={$otherUserId}&itemId={$itemId}'>{$otherUser->name} - {$item->name}</a>";
                echo "</article>";
            }
        ?>
    </section>

<?php drawFooter(); ?>
