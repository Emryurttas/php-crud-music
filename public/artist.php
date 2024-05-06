<?php

declare(strict_types=1);

use Database\MyPdo;
use Html\WebPage;
require_once '../vendor/autoload.php';

MyPDO::setConfiguration('mysql:host=mysql;dbname=cutron01_music;charset=utf8', 'web', 'web');


$webPage = new WebPage();
$artistId = 17;

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT name
    FROM artist
    WHERE id = 
SQL
);

$stmt->execute();

while (($line = $stmt->fetch()) !== false) {
    $escape = $webPage->escapeString($line['name']);
    $webPage->appendContent("<div>$escape</div>\n");
}



echo $webPage->toHTML();
