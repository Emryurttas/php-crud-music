<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\SongCollection;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Album
{
    private int $id;
    private string $name;
    private int $year;
    private int $artistId;
    private int $genreId;
    private int $coverId;

    /**
     * @return int id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int year
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return int artistId
     */
    public function getArtistId(): int
    {
        return $this->artistId;
    }

    /**
     * @return int GenreId
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /**
     * @return int coverId
     */
    public function getCoverId(): int
    {
        return $this->coverId;
    }
    public function getArtist(): Artist
    {
        return Artist::findById($this->artistId);
    }

    public function getGenre(): Genre
    {
        return Genre::findById($this->genreId);
    }

    /**
     * Récupère la liste des morceaux associés à cet album.
     *
     * @return array La liste des morceaux de cet album.
     */
    public function getSongs(): array
    {
        return SongCollection::findByAlbumId($this->id);
    }

    public static function findById(int $id): Album
    {
        $pdo = MyPDO::getInstance();
        $stmt = $pdo->prepare(
            <<<SQL
            SELECT id, name, year, artistId, genreId, coverId
            FROM album
            WHERE id = :id
            SQL
        );
        $stmt->execute(['id' => $id]);
        $albumData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$albumData) {
            throw new EntityNotFoundException("Album $id non trouvé");
        }

        $album = new Album();
        $album->id = (int)$albumData['id'];
        $album->name = $albumData['name'];
        $album->year = (int)$albumData['year'];
        $album->artistId = (int)$albumData['artistId'];
        $album->genreId = (int)$albumData['genreId'];
        $album->coverId = (int)$albumData['coverId'];

        return $album;
    }
}
