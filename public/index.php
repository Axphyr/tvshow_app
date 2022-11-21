<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Collection\SerieCollection;
use Entity\Collection\SerieGenreCollection;
use Entity\Poster;
use Html\AppWebPage;
use Html\WebPage;

//création de la page
$webPage = new AppWebPage("Séries TV");


//récupération du genre
if (!(isset($_GET["idGenre"]) and ctype_digit($_GET["idGenre"]))) {
    $colSerie = SerieCollection::findAll();
    $findGenre = false;
} else {
    $serie = (int)$_GET["idGenre"];
    $colSerie = SerieGenreCollection::findAll($serie);
    $findGenre = true;
}

//récup des genres
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
            SELECT id, name
            FROM genre
            ORDER BY name
            SQL
);

$stmt->execute();


//création du formulaire à partir des genres
$webPage->appendMenu('
                    <form name="selectGenre" method="GET" action="index.php">
                    <label>
                      Choisir un genre
                      <select name="idGenre">
                        <option value="">Tous</option>'."\n");

foreach ($stmt->fetchAll() as $genre) {
    $name = WebPage::escapeString($genre['name']);
    if ($findGenre and $genre['id'] == $_GET["idGenre"]) {
        $webPage->appendMenu("<option value=\"{$genre['id']}\" selected>{$name}</option>\n");
    } else {
        $webPage->appendMenu("<option value=\"{$genre['id']}\">{$name}</option>\n");
    }
}

$webPage->appendMenu('
                      </select>
                    </label>
                    <button type="submit">Envoyer</button>				
                    </form>');

//création du menu pour ajouter une série
$webPage->appendMenu("<li><a class='ajouter' href=\"admin/serie-form.php\">Ajouter</a></li>");

//Affichage des Series
foreach ($colSerie as $serie) {
    $comp1 = WebPage::escapeString($serie->getName());
    $comp2 = WebPage::escapeString($serie->getOverview());
    $id = $serie->getId();
    $add = <<<HTML
    <div class='serie' onclick="location.href='serie.php?serieId=$id';">
HTML;
    $webPage->appendContent("$add\n");
    if ($serie->getPosterId() == null) {
        $webPage->appendContent('<img src="img/default.png" alt="image par defaut">');
    } else {
        $idP = Poster::findById($serie->getPosterId());
        $webPage->appendContent("<img src='poster.php?posterId={$idP->getId()}' alt='poster>'>\n");
    }
    $webPage->appendContent("                <div class='info__serie'>\n");
    $webPage->appendContent("                    <div class='nom__serie'><strong>{$comp1}</strong></div><br>\n");
    $webPage->appendContent("                    <div class='resume__serie'>{$comp2}</div>\n");
    $webPage->appendContent("                </div>\n");
    $webPage->appendContent("            </div>\n");
}

echo $webPage->toHTML();
