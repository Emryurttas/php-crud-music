<?php

declare(strict_types=1);

use Entity\Cover;
use Entity\Exception\EntityNotFoundException;


$id = $_GET['id'];

try {
    $poster = cover::findById((int)$id);
    $image = $poster->getJpeg();

    if (empty($image)) {
        throw new EntityNotFoundException('image unavailable ');
    }
} catch (EntityNotFoundException) {
    exit;
} catch(Exception){
    http_response_code(500);
    exit;
}

header("Content-Type: image/jpeg");
echo $image;
