<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Poster;
use Html\AppWebPage;
use Entity\Collection\SaisonCollection;
use Entity\Serie;
use Html\WebPage;

if (!isset($_GET['serieId']) || (!ctype_digit($_GET['serieId']))) {
    header("Location:/index.php");
    exit;
}

try {
    $tvShowId = (int)$_GET['serieId'];

    $stmt = Serie::findById($tvShowId);

    $webPage = new AppWebPage("Séries TV : {$stmt->getName()}");

    $webPage->appendToHead('<div class="raccourci">');
    $webPage->appendToHead("<a class='retour' onclick='history.back()'> ↩ </a>");
    $webPage->appendToHead("<a class='home' href='index.php'>HOME</a>");
    $webPage->appendToHead('</div>');


    $webPage->appendMenu("<li><a class='modifier' href=\"admin/serie-form.php?serieId={$tvShowId}\">Modifier</a></li>");
    $webPage->appendMenu("<li><a class='supprimer' href=\"admin/serie-delete.php?serieId={$tvShowId}\">Supprimer</a></li>");


    $stmt = SaisonCollection::findByTvShowId($tvShowId);

    $page = <<<HTML
    <div class='intro__serie'>
HTML;
    $serie = Serie::findById($tvShowId);
    if ($serie->getPosterId() == null) {
        $page.= '<img class="intro__image" src="img/default.png" alt="image par defaut">';
    } else {
        $idS = Poster::findById($serie->getPosterId());
        $page .= "<img class='intro__image' src='poster.php?posterId={$idS->getId()}' alt='poster>'>\n";
    }
    $page .= <<<PAGE
           <div class='infos__desc'>
                <div class='names'>
                    <div class='nom_serie'><strong>{$serie->getName()}</strong></div>
                    <div class='original__serie'>{$serie->getOriginalName()}</div>
                </div>
                <div class='desc__serie'>{$serie->getOverview()}</div>
           </div>
    </div>
PAGE;
    $webPage->appendContent($page);


    foreach ($stmt as $s) {
        $elmt = <<<HTML
            <div class='saison'onclick="location.href='saison.php?serieId={$serie->getId()}&seasonId={$s->getId()}';">
HTML;
        $webPage->appendContent($elmt);
        $name = WebPage::escapeString($s->getName());
        $id = Poster::findById($s->getPosterId());
        $content = <<<HTML
                <div class = "episode">
                        <img src='poster.php?posterId={$id->getId()}' alt='poster>'>\n
                        <div class="season__name">
                        <div class="serie__nom" >{$name}</div>
                        </div>
                </div>
                HTML;
        $webPage->appendContent($content);
        $webPage->appendContent("</div>");
    }
} catch (EntityNotFoundException) {
    return http_response_code(404);
}


echo $webPage->toHTML();
