<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Serie;
use Html\AppWebPage;
use Html\Form\SerieForm;

try {
    if (!(isset($_GET["serieId"]))) {
        $serie = null;
        $html = new AppWebPage("Ajouter une série");
    } else {
        if (!ctype_digit($_GET["serieId"])) {
            throw new ParameterException();
        } else {
            $serie = Serie::findById((int)$_GET["serieId"]);
            $html = new AppWebPage("Modifier une série");
        }
    }
    $artistForm = new SerieForm($serie);
    $html->appendContent($artistForm->getHtmlForm("serie-save.php"));

    #Affichage
    echo $html->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
