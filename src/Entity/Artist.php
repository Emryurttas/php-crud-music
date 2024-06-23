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

    /**
     * Trouve un artiste par son ID.
     *
     * @param int $id L'ID de l'artiste à rechercher.
     * @return Artist L'objet Artist correspondant.
     * @throws EntityNotFoundException Si aucun artiste n'est trouvé avec l'ID donné.
     */
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

    /**
     * Récupère la liste des albums associés à cet artiste.
     *
     * @return array La liste des albums de cet artiste.
     */
    public function getAlbums(): array
    {
        return AlbumCollection::findByArtistId($this->id);
    }
    /**
     * Supprime cet artiste de la base de données.
     *
     * @return Artist L'instance actuelle de l'artiste après suppression.
     * @throws ParameterException Si l'ID de l'artiste est null, donc non enregistré.
     */
    public function delete():Artist
    {
        if ($this->id === null){
            throw new ParameterException("on ne peut pas supprimer un artist pas enregistré");
        }
        $stmtDelete = MyPdo::getInstance()->prepare(
            <<<'SQL'
            DELETE FROM ARTIST
            WHERE id = ?
            SQL
        );
        $stmtDelete->execute([$this->id]);
        $this->id = null;
        return $this;
    }
}
