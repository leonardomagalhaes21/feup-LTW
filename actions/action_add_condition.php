<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/condition.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conditionName = $_POST['conditionName'] ?? '';

    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        exit();
    }
    if (empty($conditionName)) {
        exit();
    }

    try {
        $db = getDatabaseConnection();
        $highestConditionId = Condition::getHighestConditionId($db);
        $condition = new Condition($highestConditionId + 1, $conditionName);
        $condition->save($db);
        header("Location: ../pages/user-profile.php?idUser=" . $_SESSION['id']);
        exit();
    } catch (PDOException $e) {
        exit();
    }
} else {
    exit();
}

?>
