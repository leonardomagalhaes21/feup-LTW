<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    exit();
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/condition.class.php');

$db = getDatabaseConnection();

$conditionId = isset($_POST['conditionId']) ? (int)$_POST['conditionId'] : 0;
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    exit();
}
if ($conditionId === 0) {
    echo "Invalid condition id";
    header("Location: ../pages/user-profile.php?idUser=" . $_SESSION['id']);
    exit();
} else {
    $condition = Condition::getConditionById($db, $conditionId);
    if ($condition !== null) {
        $condition->removeCondition($db, $condition->idCondition);
        header("Location: ../pages/user-profile.php?idUser=" . $_SESSION['id']);
        exit();
    } else {
        echo "Condition not found";
    }
}
?>
