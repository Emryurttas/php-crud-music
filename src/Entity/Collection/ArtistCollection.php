<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Artist;
use PDO;

class ArtistCollection
{
    /**
     * Cette méthode affiche tous les noms des artistes triés par ordre alphabétique des noms
    * @return Artist[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name
            FROM artist
            ORDER BY name
            SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Artist::class);
    }
}
