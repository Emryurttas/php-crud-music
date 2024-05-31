<?php

declare(strict_types=1);

use Entity\Collection\ArtistCollection;
use Html\AppWebPage;

$webPage = new AppWebPage();

$webPage->setTitle("Mes Musiques");

$webPage->appendContent('<header><h1>' . $webPage->getTitle() . '</h1></header>');

$webPage->appendContent('<main class="content"><ul class="list">');

$artists = ArtistCollection::findAll();
foreach ($artists as $artist) {
    $artistId = $artist->getId();
    $artistName = $webPage->escapeString($artist->getName());
    $webPage->appendContent("<div class='artist'>
                                        <a class='artist_item' href='artist.php?artistId=$artistId'>
                                        $artistName</a>
                                    </div>");
}
$webPage->appendContent('</ul></main>');

echo $webPage->toHTML();
