<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Exception\ParameterException;
use Entity\Serie;
use Html\StringEscaper;

class SerieForm extends Serie
{
    use StringEscaper;

    private ?Serie $serie;

    /**
     * @param Serie|null $Serie Serie
     */
    public function __construct(?Serie $Serie = null)
    {
        $this->serie = $Serie;
    }

    /**
     * @return Serie|null Serie
     */
    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    /**
     * @param string $action
     * @return string
     */
    public function getHtmlForm(string $action): string
    {
        if ($this->serie == null) {
            $id = null;
            $name = null;
            $originalName = null;
            $homepage = null;
            $overview = null;
            $posterId = null;
        } else {
            $id = $this->serie->getId();
            $name = self::escapeString($this->serie->getName());
            $originalName = self::escapeString($this->serie->getOriginalName());
            $homepage = self::escapeString($this->serie->getHomepage());
            $overview = self::escapeString($this->serie->getOverview());
            $posterId = $this->serie->getPosterId();
        }

        $html = <<<HTML
                <form name="SerieForm" method="post" action="{$action}">
                    <input name="id" type="hidden" value="{$id}">
                    <label> Nom de la série
                        <input name="name" type="text" value="{$name}" required>
                    </label><br>
                    <label> Nom Original de la série
                        <input name="originalName" type="text" value="{$originalName}">
                    </label><br>
                    <label> Page d'accueil de la série
                        <input name="homepage" type="text" value="{$homepage}">
                    </label><br>
                    <label> Résumé
                        <input name="overview" type="text" value="{$overview}">
                    </label><br>
                    <input name="posterId" type="hidden" value="{$posterId}">    
                        
                    <button type="submit">Enregistrer</button>
                </form>
               HTML;

        return $html;
    }

    /**
     * @return void
     */
    public function setEntityFromQueryString(): void
    {
        if (isset($_POST["id"]) and ctype_digit($_POST["id"])) {
            $id = (int)$_POST["id"];
        } else {
            $id = null;
        }
        if (isset($_POST["posterId"]) and ctype_digit($_POST["posterId"])) {
            $posterId = (int)$_POST["posterId"];
        } else {
            $posterId = null;
        }

        if (isset($_POST["name"]) and self::stripTagsAndTrim($_POST["name"]) != null) {
            $name = self::stripTagsAndTrim($_POST["name"]);
        } else {
            throw new ParameterException();
        }
        if (isset($_POST["originalName"]) and self::stripTagsAndTrim($_POST["originalName"]) != null) {
            $originalName = self::stripTagsAndTrim($_POST["originalName"]);
        } else {
            throw new ParameterException();
        }
        if (isset($_POST["homepage"]) and self::stripTagsAndTrim($_POST["homepage"]) != null) {
            $homepage = self::stripTagsAndTrim($_POST["homepage"]);
        } else {
            throw new ParameterException();
        }
        if (isset($_POST["overview"]) and self::stripTagsAndTrim($_POST["overview"]) != null) {
            $overview = self::stripTagsAndTrim($_POST["overview"]);
        } else {
            throw new ParameterException();
        }

        $serie = self::create($name, $originalName, $homepage, $overview, $id, $posterId);
        $this->serie = $serie;

        return;
    }
}
