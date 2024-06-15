<?php

declare(strict_types=1);

use Entity\Artist;
use Html\AppWebPage;

$webPage = new AppWebPage();



try {
    $artistId = $_GET['artistId'];

    if (empty($artistId) || !is_numeric($artistId)) {
        header('Location: index.php', true, 302);
        exit;
    }
    $webPage->appendCssUrl('/css/style.css');
    $artist = Artist::findById((int)$artistId);

    $artistName = $webPage->escapeString($artist->getName());
    $pageTitle = "Albums de " . $artistName;
    $webPage->setTitle($pageTitle);
    $webPage->appendContent('<main class="content"><ul class="list">');

    $albums = $artist->getAlbums();
    foreach ($albums as $album) {
        $albumName = $webPage->escapeString($album->getName());
        $webPage->appendContent("<li class='album'>
                                            <span class='album__year'>{$album->getYear()} </span>
                                            <span class='album__name'>$albumName</span>
                                        </li>\n");
    }

    $webPage->appendContent('</ul></main>');

    if (empty($albums)) {
        http_response_code(404);
        exit;
    }

    echo $webPage->toHTML();
} catch (Exception $e) {
    header('Location: error.php', true, 302);
    exit;
}
