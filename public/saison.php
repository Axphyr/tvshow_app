<?php

declare(strict_types=1);


use Entity\Collection\EpisodeCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Poster;
use Entity\Saison;
use Entity\Serie;
use Html\AppWebPage;
use Html\WebPage;

if (!(isset($_GET["serieId"]) and ctype_digit($_GET["serieId"])
        and isset($_GET["seasonId"]) and ctype_digit($_GET["seasonId"]))) {
    header("Location:/index.php");
    exit();
}

$serieId = (int)$_GET["serieId"]; # id de la série Tv
$seasonId = (int)$_GET["seasonId"]; # id de la saison


#Récupération de la saison selon id

try {
    $serie = Serie::findById($serieId);
    $saison = Saison::findById($serieId, $seasonId);
} catch (EntityNotFoundException) {
    return http_response_code(404);
}


$webPage = new AppWebPage("Série TV : {$serie->getName()} <br> {$saison->getName()}");

$webPage->appendToHead('<div class="raccourci">');
$webPage->appendToHead("<a class='retour' onclick='history.back()'>↩</a>");
$webPage->appendToHead("<a class='home' href='index.php'>HOME</a>");
$webPage->appendToHead('</div>');

#récupération des episodes de la saison de la serieTv

$saisonTv = EpisodeCollection::findByTvShowId($saison->getTvShow(), $saison->getId());


$idS = Poster::findById($serie->getPosterId());
$ep = <<<EP
        <div class="info__ep">
            <img class="intro__image" src='poster.php?posterId={$idS->getId()}' alt='poster'>
            <div class="long">
                <div class="episode__infos">
                    <div class="homepage"><a href="{$serie->getHomePage()}">{$serie->getName()}</a></div>
                    <div class="titre__saison">{$saison->getName()}</div>
                </div>
            </div>
        </div>
EP;

$webPage->appendContent($ep);

foreach ($saisonTv as $episode) : {
    $num = $episode->getEpisodeNumber();
    $titre = WebPage::escapeString($episode->getName());
    $description = WebPage::escapeString($episode->getOverview());
    $content = <<<HTML
                <div class="episode__liste">
                        <div class="episode__num"><strong>{$num} - {$titre}</strong></div>
                        <div class="episode__desc">{$description}</div>
                </div>
                HTML;
    $webPage->appendContent($content);
}endforeach;

#Affichage
echo $webPage->toHTML();
