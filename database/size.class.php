<?php
declare(strict_types=1);

require_once 'connection.db.php';

class Size {
    public int $idSize;
    public string $sizeName;

    public function __construct(int $idSize, string $sizeName) {
        $this->idSize = $idSize;
        $this->sizeName = $sizeName;
    }

    static function getSizes(PDO $db) : array {
        $stmt = $db->prepare('SELECT * FROM Sizes');
        $stmt->execute();
    
        $sizes = array();
        
        while ($size = $stmt->fetch()) {
            $sizes[] = new Size(
              $size['idSize'],
              $size['sizeName']
            );
        }

        return $sizes;
    }

    public static function getSizeById(PDO $db, int $idSize): ?Size {
        $stmt = $db->prepare('SELECT * FROM Sizes WHERE idSize = ?');
        $stmt->execute([$idSize]);

        $size = $stmt->fetch();

        if ($size === false) {
            return null;
        }
        
        return new Size($size['idSize'], $size['sizeName']);
    }
}
?>
