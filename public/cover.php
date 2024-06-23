<?php

declare(strict_types=1);

use Entity\Cover;
use Entity\Exception\EntityNotFoundException;

$id = $_GET['id'];

try {
    if (empty($id) || !is_numeric($id)) {
        throw new InvalidArgumentException('Invalid cover ID');
    }

    $poster = Cover::findById((int)$id);
    $image = $poster->getJpeg();

    if (empty($image)) {
        throw new EntityNotFoundException('Image not found');
    }

} catch (InvalidArgumentException) {
    http_response_code(400);
    exit;

} catch (EntityNotFoundException) {
    http_response_code(404);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    exit;
}

header("Content-Type: image/jpeg");
echo $image;