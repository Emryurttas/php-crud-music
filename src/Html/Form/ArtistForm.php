<?php

namespace Html\Form;

use Entity\Artist;

class ArtistForm
{
    private ?Artist $artist;

    /**
     * Constructeur de la classe ArtistForm.
     *
     * @param Artist|null $artist L'instance de l'artiste à utiliser dans le formulaire, null par défaut.
     */
    public function __construct(?Artist $artist = null)
    {
        $this->artist = $artist;
    }

    /**
     * Retourne l'instance de l'artiste associée à ce formulaire.
     *
     * @return Artist|null L'instance de l'artiste ou null si aucune n'est définie.
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * Génère et retourne le formulaire HTML pour éditer ou créer un artiste.
     *
     * @param string $action L'URL de l'action du formulaire.
     * @return string Le code HTML du formulaire.
     */
    public function getHtmlForm(string $action): string
    {
        $id = $this->artist?->getId() ?? '';
        $name = htmlspecialchars($this->artist?->getName() ?? '', ENT_QUOTES | ENT_HTML5);

        // Génération du formulaire HTML
        return <<<HTML
            <form action="$action" method="post">
                <input type="hidden" name="artist_id" value="$id">
                <label for="artist_name">Nom:</label>
                <input type="text" id="artist_name" name="artist_name" value="$name" required>
                <button type="submit">Enregistrer</button>
            </form>
        HTML;
    }
}