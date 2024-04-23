<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: ../pages/login.php");
    exit;
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/chats.class.php'); // Import the Chat class

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if all required fields are set
    if (isset($_POST['recipient_id'], $_POST['message'])) {
        // Get the user ID of the sender from the session
        $senderId = $_SESSION['id'];
        
        // Get the recipient ID and message from the form
        $recipientId = $_POST['recipient_id'];
        $message = $_POST['message'];
        
        // Send the message
        $success = Chat::sendChatMessage($senderId, $recipientId, $message);
        
        if ($success) {
            header("Location: conversation.php?recipient_id=$recipientId");
            exit;
        } else {
            echo "Failed to send message.";
            exit;
        }
    } else {
        echo "Please provide recipient and message.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
