<?php 
declare(strict_types=1);

require_once 'connection.db.php';
require_once 'users.class.php';

class Chat {
    public int $idChat;
    public int $idSender;
    public int $idRecipient;
    public string $message;
    public string $timestamp;

    public function __construct(int $idChat, int $idSender, int $idRecipient, string $message, string $timestamp) {
        $this->idChat = $idChat;
        $this->idSender = $idSender;
        $this->idRecipient = $idRecipient;
        $this->message = $message;
        $this->timestamp = $timestamp;
    }

    public static function getChatById(int $idChat): ?Chat {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM Chats WHERE idChat = ?');
        $stmt->execute([$idChat]);
        $chat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($chat === false) {
            return null;
        }
        return new Chat(
            $chat['idChat'],
            $chat['idSender'],
            $chat['idRecipient'],
            $chat['message'],
            $chat['timestamp']
        );
    }

    public static function getMessagesForChat(PDO $db, int $chatId): array {
        $stmt = $db->prepare('SELECT * FROM Chats WHERE idChat = ?');
        $stmt->execute([$chatId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMessagesInvolvingUser(PDO $db, int $userId): array {
        $stmt = $db->prepare('SELECT * FROM Chats WHERE idSender = ? OR idRecipient = ?');
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function getSender(): ?User {
        return User::getUserById(getDatabaseConnection(), $this->idSender);
    }

    public function getRecipient(): ?User {
        return User::getUserById(getDatabaseConnection(), $this->idRecipient);
    }

}
?>
