<?php

declare(strict_types=1);

use Entity\Collection\ArtistCollection;
use Html\WebPage;

$webPage = new WebPage();

$artists = ArtistCollection::findAll();

foreach ($artists as $artist) {
    $artistId = $artist->getId();
    $artistName = $webPage->escapeString($artist->getName());
    $webPage->appendContent("<div><a href='artist.php?artistId={$artistId}'>$artistName</a></div>\n");
}

echo $webPage->toHTML();
