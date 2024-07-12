<?php
declare(strict_types=1);

use Entity\Artist;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\AppWebPage;
use Html\Form\ArtistForm;

try {
    $artistId = $_GET['artistId'] ?? null;

    if ($artistId !== null) {
        if (!ctype_digit($artistId)) {
            throw new ParameterException("Paramètre invalide : artistId doit être numérique");
        }
        $artist = Artist::findById((int)$artistId);
    } else {
        $artist = null;
    }

    $artistForm = new ArtistForm($artist);

    $page = new AppWebPage($artist ? "Modifier l'artiste" : "Créer un artiste");
    $page->appendCssUrl('/css/form.css');
    $page->appendContent($artistForm->getHtmlForm("artist-save.php"));
    echo $page->toHTML();

} catch (ParameterException) {
    http_response_code(400);
    echo "Erreur de paramètre : ";
} catch (EntityNotFoundException) {
    http_response_code(404);
    echo "Artiste non trouvé.";
} catch (Exception) {
    http_response_code(500);
    echo "Erreur interne du serveur : ";
}

