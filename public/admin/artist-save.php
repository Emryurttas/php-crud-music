<?php

declare(strict_types=1);


use Entity\Exception\ParameterException;
use Html\Form\ArtistForm;

try {
    $artistForm = new ArtistForm();
    $artistForm->setEntityFromQueryString();
    $artist = $artistForm->getArtist();
    $artist->save();
    header("Location: /index.php");
    exit;
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
