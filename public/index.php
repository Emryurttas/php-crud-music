<?php

declare(strict_types=1);

use Entity\Collection\ArtistCollection;
use Html\AppWebPage;

$webPage = new AppWebPage();

$webPage->setTitle("Artistes");
$webPage->appendContent('<header class="header"><h1>' . $webPage->escapeString($webPage->getTitle()) . '</h1></header>');
$webPage->appendContent('<main class="content"><ul class="list">');

$artists = ArtistCollection::findAll();
foreach ($artists as $artist) {
    $artistId = $artist->getId();
    $artistName = $webPage->escapeString($artist->getName());
    $webPage->appendContent("<li class='artist'><a class='artist_item' href='artist.php?artistId=$artistId'>$artistName</a></li>");
}
$webPage->appendContent('</ul></main>');
$webPage->appendContent('<footer class="footer">' . $webPage->getLastModification() . '</footer>');
echo $webPage->toHTML();
