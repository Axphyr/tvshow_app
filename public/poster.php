<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Poster;

try {
    if (isset($_GET['posterId']) && ctype_digit($_GET['posterId'])) {
        $posterId = (int)$_GET['posterId'];
        $tmp = Poster::findById($posterId);
        header('Content-Type:image/jpg');
        echo $tmp->getJpeg();
    } else {
        echo '<img src="img/default.png" alt="image par defaut">';
        exit;
    }
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
