<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Html\Form\SerieForm;

try {
    $serieForm = new SerieForm();
    $serieForm->setEntityFromQueryString();
    $serieForm->getSerie()->save();

    header("Location:/index.php");
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
