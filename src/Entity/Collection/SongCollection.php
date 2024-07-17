<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Track;
use PDO;

class SongCollection
{
    /**
     * Cette méthode affiche tous les morceaux de l'album triés par ordre chronologique par les noms
     * @param int $albumId
     * @return array Liste des morceaux de l'album
     */
    public static function findByAlbumId(int $albumId): array
    {
        $stmtSong = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT t.id, t.albumId, t.songId, t.diskNumber, t.number, t.duration, s.name as songName
            FROM track t
            JOIN song s ON t.songId = s.id
            WHERE t.albumId = :albumId
            ORDER BY t.number
            SQL
        );
        $stmtSong->execute(['albumId' => $albumId]);
        $stmtSong->setFetchMode(PDO::FETCH_CLASS, Track::class);
        return $stmtSong->fetchAll();
    }
}