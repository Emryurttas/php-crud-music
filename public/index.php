<?php

declare(strict_types=1);

use Entity\Collection\ArtistCollection;
use Html\AppWebPage;

$webPage = new AppWebPage();

$webPage->setTitle("Ma Musique");

$webPage->appendContent('<header><h1>' . $webPage->getTitle() . '</h1></header>');

$webPage->appendContent('<main><ul class="artist-list">');

$artists = ArtistCollection::findAll();

foreach ($artists as $artist) {
    $artistId = $artist->getId();
    $artistName = $webPage->escapeString($artist->getName());
    $webPage->appendContent("<li class='artist-item'><a class='artist-link' href='artist.php?artistId=$artistId'>$artistName</a></li>");
}
$webPage->appendContent('</ul></main>');

echo $webPage->toHTML();
