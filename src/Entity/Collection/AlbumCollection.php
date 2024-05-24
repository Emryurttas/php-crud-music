<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Album;
use PDO;

class AlbumCollection
{
    /**
     * Cette méthode affiche tous les albums des artistes triés par ordre chronologique inverse puis par les noms
     * @param int $artistId L'ID de l'artiste
     * @return Album[] Liste des albums de l'artiste
     */
    public static function findByArtistId(int $artistId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT name, year
            FROM album
            WHERE artistId = :artistId
            ORDER BY year DESC, name
            SQL
        );

        $stmt->execute(['artistId' => $artistId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Album::class);
    }
}
