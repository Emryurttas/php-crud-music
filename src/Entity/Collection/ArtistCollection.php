<?php

declare(strict_types=1);

namespace Entity;

class ArtistCollection
{
    /**
     * Cette méthode affiche tous les noms des articles en alphabétique
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

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

}
