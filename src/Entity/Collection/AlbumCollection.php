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
        $stmtAlbum = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id,name,year,artistId,genreId,coverId
            FROM album
            WHERE artistId=:id
            ORDER BY year DESC, name
            SQL
        );
        $stmtAlbum->execute(['id' => $artistId]);
        return $stmtAlbum->fetchAll(PDO::FETCH_CLASS, Album::class);
    }
}
