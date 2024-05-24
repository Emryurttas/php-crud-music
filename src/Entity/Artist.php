<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\AlbumCollection;
use PDO;

class Artist
{
    private int $id;
    private string $name;
    /**
     * @return int id
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return string Name
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function findByArtistId(int $id): Artist
    {
        $stmtArtistId = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name
            FROM artist
            WHERE id = :id
            SQL
        );
        $stmtArtistId->execute(['id' => $id]);
        $artistData = $stmtArtistId->fetch(PDO::FETCH_ASSOC);

        if (!$artistData) {
            throw new EntityNotFoundException("Artist $id pas trouvé");
        }
        return new Artist($artistData['id'], $artistData['name']);
    }
    public function getAlbums(): array
    {
        return AlbumCollection::findByArtistId($this->id);
    }

}
