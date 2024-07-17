<?php

namespace Entity;

use Database\MyPDO;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Genre
{
    private int $id;
    private string $name;

    /**
     * Récupère l'ID du genre.
     *
     * @return int ID du genre
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le nom du genre.
     *
     * @return string Nom du genre
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Trouve un genre par son ID dans la base de données.
     *
     * @param int $id ID du genre à rechercher
     * @return Genre Objet Genre correspondant à l'ID spécifié
     * @throws EntityNotFoundException Si aucun genre correspondant à l'ID n'est trouvé
     */
    public static function findById(int $id): Genre
    {
        $stmtGenreId = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name
            FROM genre
            WHERE id = :id
            SQL
        );
        $stmtGenreId->execute(['id' => $id]);
        $genreData = $stmtGenreId->fetch(PDO::FETCH_ASSOC);

        if (!$genreData) {
            throw new EntityNotFoundException("Genre $id non trouvé");
        }

        $genre = new Genre();
        $genre->id = $genreData['id'];
        $genre->name = $genreData['name'];

        return $genre;
    }
}
