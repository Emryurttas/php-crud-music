<?php

declare(strict_types=1);

use Entity\Artist;
use Html\AppWebPage;

$webPage = new AppWebPage();

$artistId = $_GET['artistId'];

if (empty($artistId) || !is_numeric($artistId)) {
    header('Location: http://localhost:8000/', true, 302);
    exit;
}

$artist = Artist::findById((int)$artistId);

$webPage->appendContent('<header><h1>' .  $webPage->escapeString($artist->getName()) . '</h1></header>');

$webPage->appendContent('<main><ul class="album-list">');



$albums = $artist->getAlbums();
foreach ($albums as $album) {
    $albumName = $webPage->escapeString($album->getName());
    $webPage->appendContent("<li class='album-item'>
                                        <a class='album'>
                                         {$album->getYear()} $albumName
                                        </a>
                                    </li>\n");
}

if (empty($albums)) {
    http_response_code(404);
    $webPage->appendContent("<p>Aucun album trouvé pour cet artiste.</p>\n");
}
$webPage->appendContent('</main></ul>');

echo $webPage->toHTML();
