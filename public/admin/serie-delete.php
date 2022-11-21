<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Serie;

try {
    if (!(isset($_GET["serieId"]) and ctype_digit($_GET["serieId"]))) {
        throw new ParameterException();
    } else {
        $serie = Serie::findById((int)$_GET["serieId"]);
    }
    $serie->delete();

    header("Location:/index.php");
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
