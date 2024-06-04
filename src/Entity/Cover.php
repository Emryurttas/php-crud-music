<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Cover
{
    private int $id;
    private string $jpeg;

    // Constructeur privé
    private function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * Trouve une couverture par son ID
     *
     * @param int $id
     * @return Cover
     * @throws \Entity\Exception\EntityNotFoundException
     */
    public static function findById(int $id): Cover
    {
        $stmtCoverId = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, jpeg
            FROM cover
            WHERE id = :id
            SQL
        );
        $stmtCoverId->execute(['id' => $id]);
        $coverData = $stmtCoverId->fetch(PDO::FETCH_ASSOC);

        if (!$coverData) {
            throw new EntityNotFoundException("Cover $id pas trouvé");
        }
        $cover = new Cover();
        $cover->id = $coverData['id'];
        $cover->jpeg = $coverData['jpeg'];
        return $cover;
    }
}
