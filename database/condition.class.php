<?php
declare(strict_types=1);

require_once 'connection.db.php';

class Condition {
    public int $idCondition;
    public string $conditionName;

    public function __construct(int $idCondition, string $conditionName) {
        $this->idCondition = $idCondition;
        $this->conditionName = $conditionName;
    }

    public static function getConditionById(int $idCondition): ?Condition {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM Conditions WHERE idCondition = ?');
        $stmt->execute([$idCondition]);
        $condition = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($condition === false) {
            return null;
        }
        return new Condition($condition['idCondition'], $condition['conditionName']);
    }
}
?>
