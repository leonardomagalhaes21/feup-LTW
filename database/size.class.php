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

    public static function getSizeById(int $idSize): ?Size {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM Sizes WHERE idSize = ?');
        $stmt->execute([$idSize]);
        $size = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($size === false) {
            return null;
        }
        return new Size($size['idSize'], $size['sizeName']);
    }
}
?>
