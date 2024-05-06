<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;

MyPDO::setConfiguration('mysql:host=mysql;dbname=cutron01_music;charset=utf8', 'web', 'web');

$webPage = new WebPage();

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT id, name
    FROM artist
    ORDER BY name
SQL
);

$stmt->execute();

while (($line = $stmt->fetch()) !== false) {
    $escape = $webPage->escapeString($line['name']);
    $webPage->appendContent("<div>$escape</div>\n");
}



echo $webPage->toHTML();
