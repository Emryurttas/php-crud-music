<?php

declare(strict_types=1);

use Entity\Collection\ArtistCollection;
use Html\AppWebPage;

try {
    $webPage = new AppWebPage();
    $webPage->appendCssUrl('/css/index.css');

    $webPage->setTitle("Artistes");

    $webPage->addToMenu('<a href="/admin/artist-form.php" class="btn-create">Créer un artiste</a>');

    $webPage->appendContent('<ul class="list">');

    $artists = ArtistCollection::findAll();

    foreach ($artists as $artist) {
        $artistId = $artist->getId();
        $artistName = $webPage->escapeString($artist->getName());
        $webPage->appendContent("<li class='artist'>
                                            <a class='artist_item' href='artist.php?artistId=$artistId'>$artistName</a>
                                         </li>");
    }

    $webPage->appendContent('</ul>');

    echo $webPage->toHTML();

} catch (Exception $e) {
    http_response_code(500);
    echo "An error occurred: ";
    exit;
}

