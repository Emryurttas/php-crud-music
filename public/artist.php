<?php

declare(strict_types=1);

use Database\MyPdo;
use Html\WebPage;

$webPage = new WebPage();

if (!isset($_GET['artistId']) || !is_numeric($_GET['artistId'])) {
    header("Location: artist.php", true, 302);
    exit;
}

$artistId = ($_GET['artistId']);

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT name
    FROM artist
    WHERE id = ?
SQL
);

$stmt->execute([$artistId]);

$artistName = "nom de l'artiste";
if ($line = $stmt->fetch()) {
    $artistName = $webPage->escapeString($line['name']);
}

$webPage->setTitle("Albums de $artistName");
$webPage->appendContent("<h1>Albums de $artistName</h1>\n");

$stmtAlbums = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT name,year
    FROM album
    WHERE artistId = ?
    ORDER BY year DESC,name
SQL
);
$stmtAlbums->execute([$artistId]);

$artist = $stmtAlbums->fetch();

if ($artist === false) {
    http_response_code(404);
    exit;
}

while (($album = $stmtAlbums->fetch()) !== false) {
    $webPage->appendContent("<div>{$album['year']} {$album['name']}</div>\n");
}

echo $webPage->toHTML();
