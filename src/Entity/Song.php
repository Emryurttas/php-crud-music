<?php

namespace Entity;

use Database\MyPDO;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Song
{
    private int $id;
    private string $name;

    /**
     * Récupère l'identifiant de la chanson.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le nom de la chanson.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Recherche une chanson par son identifiant.
     *
     * @param int $id L'identifiant de la chanson à rechercher.
     * @return Song La chanson trouvée.
     * @throws EntityNotFoundException Si la chanson n'est pas trouvée.
     */
    public static function findById(int $id): Song
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name
            FROM song
            WHERE id = :id
            SQL
        );

        $stmt->execute(['id' => $id]);
        $songData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$songData) {
            throw new EntityNotFoundException("Song $id not found");
        }

        $song = new Song();
        $song->id = $songData['id'];
        $song->name = $songData['name'];

        return $song;
    }
}
