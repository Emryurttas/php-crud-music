<?php

declare(strict_types=1);

use Database\MyPdo;
use Html\WebPage;

$webPage = new WebPage();

$artistId = 17;

if (isset($_GET['artistId'])) {
    header('Location:http://localhost:8000/artist.php');
}

// Fetch artist name
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT name
    FROM artist
    WHERE id = ?
SQL
);
$stmt->execute([$artistId]);

$artist = $stmt->fetch();
$artistName = $webPage->escapeString($artist['name']);
$webPage->setTitle("Albums de $artistName");
$webPage->appendContent("<h1>Albums de $artistName</h1>\n");


$stmtAlbums = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT title, year
    FROM album
    WHERE id = ?
    ORDER BY year DESC
SQL
);
$stmtAlbums->execute([$artistId]);

while (($album = $stmtAlbums->fetch()) !== false) {
    $escapedTitle = $webPage->escapeString($album['title']);
    $escapedYear = $webPage->escapeString((string) $album['year']);
    $webPage->appendContent("<div>$escapedTitle ($escapedYear)</div>\n");
}


echo $webPage->toHTML();
