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

$webPage->setTitle($webPage->escapeString($artist->getName()));

$webPage->appendContent('<header class="header"><h1>' . $webPage->escapeString($artist->getName()) . '</h1></header>');
$webPage->appendContent('<main class="content"><ul class="list">');


$albums = $artist->getAlbums();
foreach ($albums as $album) {
    $albumName = $webPage->escapeString($album->getName());
    $webPage->appendContent("<li class='album'>
                                        <span class='album__year'>{$album->getYear()} </span>
                                        <span class='album__name'>$albumName</span>
                                    </li>\n");
}

if (empty($albums)) {
    http_response_code(404);
    $webPage->appendContent("<p>Aucun album trouvé pour cet artiste.</p>\n");
}

$webPage->appendContent('</ul></main>');

echo $webPage->toHTML();
