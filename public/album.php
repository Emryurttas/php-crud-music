<?php

declare(strict_types=1);

use Entity\Album;
use Entity\Cover;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

try {
    $webPage = new AppWebPage();

    if (empty($_GET['albumId']) || !is_numeric($_GET['albumId'])) {
        echo 'Invalid albumId';
        header('Location: index.php', true, 302);
        exit;
    }

    $albumId = (int)$_GET['albumId'];

    try {
        $album = Album::findById($albumId);
    } catch (EntityNotFoundException $e) {
        http_response_code(404);
        echo 'Album non trouvé';
        exit;
    }
    $albumName = $webPage->escapeString($album->getName());

    $pageTitle = "Morceaux de l'album : $albumName";
    $webPage->setTitle($pageTitle);

    $webPage->appendCssUrl('/css/album.css');
    $editUrl = "/admin/artist-form.php?tvShowId=$albumId";
    $deleteUrl = "/admin/artist-delete.php?tvShowId=$albumId";

    $webPage->appendContent('<div class="menu">
                                    <a href="index.php" class="btn-home">Retour à l\'accueil</a>
                                    <a href="' . $editUrl . '" class="btn-edit">Modifier</a>
                                    <a href="' . $deleteUrl . '" class="btn-delete">Supprimer</a>
                                    </div>');
    $coverId = $album->getCoverId();
    try {
        $poster = Cover::findById($coverId);
        $albumPosterUrl = "cover.php?coverId=" . $poster->getId();
    } catch (EntityNotFoundException $e) {
        $albumPosterUrl = '';
    }

    $webPage->appendContent("<div class='album'>
                                            <a class='album_link' href='$albumPosterUrl'>
                                                <img src='$albumPosterUrl' alt='Poster de $albumName'/>
                                            </a></div>");


    $webPage->appendContent('<ul class="song-list">');

    $songs = $album->getSongs();
    if (empty($songs)) {
        echo 'No songs found for this album';
    } else {
        foreach ($songs as $song) {
            $songName = $webPage->escapeString($song->getSongName());
            $disk = $song->getDuration();
            $webPage->appendContent("
            <li class='song'>
                <div>$songName</div>
            </li>");
        }
    }

    $webPage->appendContent('</ul>');
    echo $webPage->toHTML();

} catch (EntityNotFoundException ) {
    http_response_code(404);
    echo 'Album non trouvé';
    exit;
} catch (Exception) {
    http_response_code(500);
    echo 'Erreur serveur: ';
    exit();
}
