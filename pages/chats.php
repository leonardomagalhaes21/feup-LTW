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

    <section>
        <h2>Chats</h2>
        <div class="chats">
            <?php
                foreach ($pairs as $pair) {
                    $otherUserId = (int)$pair['otherUserId'];
                    $itemId = (int)$pair['idItem'];

                    $otherUser = User::getUserById($db, $otherUserId);
                    $item = Item::getItemById($db, $itemId);

                    echo "<a href='../pages/chat_messages.php?otherUserId={$otherUserId}&itemId={$itemId}'>{$otherUser->username} - {$item->name}</a> <br>";
                }
            ?>
        </div>
    </section>

<?php drawFooter(); ?>
