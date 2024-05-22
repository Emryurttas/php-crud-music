<?php

declare(strict_types=1);

use Database\MyPdo;
use Html\WebPage;

$webPage = new WebPage();

$artistId = $_GET['artistId'];

if(empty($artistId) || !is_numeric($_GET['artistId'])) {
    header('Location: http://localhost:8000/', true, 302);
    exit;
}
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT id, name
    FROM artist
    WHERE id=:id
SQL
);

$stmt->execute(['id' => $artistId]);

while (($ligne = $stmt->fetch()) !== false) {
    $nom = $webPage->escapeString($ligne['name']);
    $webPage->appendContent("<p> Album de $nom\n");
    $webPage->setTitle("Album de {$ligne['name']}");
}

$stmt2 = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT year,name
    FROM album
    WHERE artistId=:id
    ORDER BY year DESC, name
SQL
);
$stmt2->execute(['id' => $artistId]);

while (($ligne = $stmt2->fetch()) !== false) {
    $nom = $webPage->escapeString($ligne['name']);
    $webPage->appendContent("<div>{$ligne['year']} $nom</div>\n");

}
if (!($ligne = $stmt2->fetch())) {
    http_response_code(404);
}
echo $webPage->toHTML();
