<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\AlbumCollection;
use Entity\Exception\ParameterException;
use PDO;
use Entity\Exception\EntityNotFoundException;

class Artist
{
    private ?int $id = null;
    private string $name;

    /**
     * Récupère l'ID de l'entité.
     *
     * @return int|null L'ID de l'entité, ou null si non défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Définit l'ID de l'entité.
     *
     * @param int|null $id L'ID à définir, peut être null.
     * @return void
     */
    private function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Récupère le nom de l'entité.
     *
     * @return string Le nom de l'entité.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Définit le nom de l'entité.
     *
     * @param string $name Le nom à définir.
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
