<?php

declare(strict_types=1);

use Entity\Artist;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

$webPage = new AppWebPage();

try {
    $artistId = $_GET['artistId'];

    if (empty($artistId) || !is_numeric($artistId)) {
        header('Location: index.php', true, 302);
        exit;
    }

    try {
        $artist = Artist::findById((int)$artistId);
    } catch (EntityNotFoundException) {
        http_response_code(404);
        exit;
    }

    $artistName = $webPage->escapeString($artist->getName());
    $pageTitle = "Albums de " . $artistName;

    $webPage->setTitle($pageTitle);

    $webPage->appendContent('<ul class="list">');

    $albums = $artist->getAlbums();
    foreach ($albums as $album) {
        $albumName = $webPage->escapeString($album->getName());
        $webPage->appendContent("<li class='album'>
                                    <span class='album__year'>{$album->getYear()}</span>
                                    <span class='album__name'>$albumName</span>
                                </li>\n");
    }
    $webPage->appendContent('</ul>');

    echo $webPage->toHTML();

} catch (EntityNotFoundException $e) {
    http_response_code(404);
    echo 'Artist not found';
    exit;
} catch (Exception) {
    http_response_code(500);
    exit;
}
