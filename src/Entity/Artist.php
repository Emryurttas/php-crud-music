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

    public static function findById(int $id): Artist
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
        $artist = new Artist();
        $artist->id = $artistData['id'];
        $artist->name = $artistData['name'];

        return $artist;
    }
    public function getAlbums(): array
    {
        return AlbumCollection::findByArtistId($this->id);
    }

}
