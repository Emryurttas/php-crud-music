<?php

declare(strict_types=1);

use Entity\Artist;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    $artistId = $_GET['artistId'] ?? null;
    if ($artistId === null || !ctype_digit($artistId)) {
        throw new ParameterException("Paramètre invalide : artistId doit être numérique.");
    }
    $artist = Artist::findById((int)$artistId);
    $artist->delete();
    header("Location: /index.php");
    exit;
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
