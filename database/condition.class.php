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

    static function getConditions(PDO $db) : array {
        $stmt = $db->prepare('SELECT * FROM Conditions');
        $stmt->execute();
    
        $conditions = array();
        
        while ($condition = $stmt->fetch()) {
            $conditions[] = new Condition(
              $condition['idCondition'],
              $condition['conditionName']
            );
        }

        return $conditions;
    }

    public static function getConditionById(PDO $db, int $idCondition): ?Condition {
        $stmt = $db->prepare('SELECT * FROM Conditions WHERE idCondition = ?');
        $stmt->execute([$idCondition]);

        $condition = $stmt->fetch();

        if ($condition === false) {
            return null;
        }
        
        return new Condition($condition['idCondition'], $condition['conditionName']);
    }
}
?>
