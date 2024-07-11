<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Cover
{
    private int $id;
    private string $jpeg;

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
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): Cover
    {
        $stmtCoverId = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, jpeg
            FROM cover
            WHERE id = ?
            SQL
        );
        $stmtCoverId->execute([$id]);

        if (($poster = $stmtCoverId->fetchObject(Cover::class)) === false) {
            throw new EntityNotFoundException("Le poster {$id} n'\est pas trouvé");
        }
        return $poster;
    }
}
