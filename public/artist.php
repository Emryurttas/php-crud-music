<?php

declare(strict_types=1);

use Entity\Artist;
use Html\WebPage;

$webPage = new WebPage();

$artistId = $_GET['artistId'];

if (empty($artistId) || !is_numeric($artistId)) {
    header('Location: http://localhost:8000/', true, 302);
    exit;
}

$artist = Artist::findById((int)$artistId);

$artistName = $webPage->escapeString($artist->getName());
$webPage->appendContent("<p> Album de $artistName</p>\n");
$webPage->setTitle("Album de $artistName");

$albums = $artist->getAlbums();
foreach ($albums as $album) {
    $albumName = $webPage->escapeString($album->getName());
    $webPage->appendContent("<div>{$album->getYear()} $albumName</div>\n");
}

if (empty($albums)) {
    http_response_code(404);
    $webPage->appendContent("<p>Aucun album trouvé pour cet artiste.</p>\n");
}

echo $webPage->toHTML();
