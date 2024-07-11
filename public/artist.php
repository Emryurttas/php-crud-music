<?php

declare(strict_types=1);

use Entity\Artist;
use Entity\Cover;
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
    } catch (EntityNotFoundException $e) {
        http_response_code(404);
        echo 'Artist not found';
        exit;
    }

    $artistName = $webPage->escapeString($artist->getName());
    $pageTitle = "Albums de " . $artistName;

    $webPage->setTitle($pageTitle);

    $webPage->appendContent('<ul class="list">');

    $albums = $artist->getAlbums();
    foreach ($albums as $album) {
        $albumName = $webPage->escapeString($album->getName());
        $coverId = $album->getCoverId();

        try {
            $poster = Cover::findById((int)$coverId);
            $albumPosterUrl = "cover.php?id=" . $poster->getId();
        } catch (EntityNotFoundException $e) {
            $albumPosterUrl = '';
        }

        $link = "cover.php?coverId=$coverId";
        $webPage->appendContent("<li class='album'>
                                            <a class='album_link' href='$link'>
                                                <img src='$link' alt='Poster de $albumName'/>
                                            </a>
                                            <div class='album__info'>
                                                <div class='album__year'>{$album->getYear()}</div>
                                                <div class='album__name'>$albumName</div>
                                            </div>
                                        </li>");
                                        }

    $webPage->appendContent('</ul>');

    echo $webPage->toHTML();

} catch (EntityNotFoundException $e) {
    http_response_code(404);
    echo 'Artist not found';
    exit;
} catch (Exception $e) {
    http_response_code(500);
    exit;
}