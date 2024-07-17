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

    $webPage->appendCssUrl('/css/artist.css');
    $webPage->setTitle($pageTitle);

    $editUrl = "/admin/artist-form.php?tvShowId=$artistId";
    $deleteUrl = "/admin/artist-delete.php?tvShowId=$artistId";

    $webPage->appendContent('<div class="menu">
                                    <a href="index.php" class="btn-home">Retour à l\'accueil</a>
                                    <a href="' . $editUrl . '" class="btn-edit">Modifier</a>
                                    <a href="' . $deleteUrl . '" class="btn-delete">Supprimer</a>
                                    </div>');

    $webPage->appendContent('<ul class="list">');

    $albums = $artist->getAlbums();
    foreach ($albums as $album) {
        $albumName = $webPage->escapeString($album->getName());
        $coverId = $album->getCoverId();
        $albumId = $album->getId();

        try {
            $poster = Cover::findById((int)$coverId);
            $albumPosterUrl = "cover.php?coverId=" . $poster->getId();
        } catch (EntityNotFoundException $e) {
            $albumPosterUrl = '';
        }

        $link = "album.php?albumId=$albumId";
        $webPage->appendContent("<li class='album'>
                                            <a class='album_link' href='$link'>
                                                <img src='$albumPosterUrl' alt='Poster de $albumName'/>
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
