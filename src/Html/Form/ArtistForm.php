<?php

namespace Html\Form;

use Entity\Artist;
use Entity\Exception\ParameterException;
use Html\StringEscaper;
use InvalidArgumentException;

class ArtistForm
{
    use StringEscaper;
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
        $name = $this->artist ? htmlspecialchars($this->artist->getName(), ENT_QUOTES | ENT_HTML5) : '';
        return <<<HTML
        <form action="$action" method="post">
            <input type="hidden" name="id" value="$id">
            <label for="artist_name">Nom:</label>
            <input type="text" id="artist_name" name="name" value="$name" required>
            <button type="submit">Enregistrer</button>
        </form>
    HTML;
    }
    /**
     * Définit l'entité à partir des paramètres de la chaîne de requête.
     *
     * Cette méthode extrait les données envoyées via la méthode POST pour créer
     * une instance de l'artiste. Elle effectue les vérifications suivantes :
     *
     * 1. Vérifie si un identifiant d'artiste est fourni et s'il est valide.
     * 2. Vérifie si le nom de l'artiste est présent et non vide.
     * 3. Supprime les balises HTML et les espaces autour du nom de l'artiste.
     * 4. Lance une exception si le nom de l'artiste est requis mais manquant ou vide.
     *
     * @throws ParameterException Si le nom de l'artiste est requis mais non fourni.
     */
    public function setEntityFromQueryString(): void
    {
        $artistId = null;

        if (!empty($_POST['id']) && ctype_digit($_POST['id'])) {
            $artistId = (int)$_POST['id'];
        }
        if (empty($_POST['name'])) {
            throw new ParameterException("Le nom de l'artiste est requis.");
        }

        $artistName = $this->stripTagsAndTrim($_POST['name']);

        if (empty($artistName)) {
            throw new ParameterException("Le nom de l'artiste est requis.");
        }
        $this->artist = Artist::create($artistName, $artistId);
    }

}