<?php

declare(strict_types=1);

use Database\MyPdo;
use Html\WebPage;

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
