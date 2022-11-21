<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    use StringEscaper;

    private string $head = "";
    private string $title = "";
    private string $body = "";

    /** Constructeur.
     * @param string $title Titre de la page
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /** Retourne le contenu de $this->head.
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /** Retourne le contenu de $this->title.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** Affecter le titre de la page.
     * @param string $title Le titre
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /** Retourne le contenu de $this->body.
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /** Ajouter un contenu dans $this->head.
     * @param string $content Le contenu à ajouter
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /** Ajouter un contenu CSS dans $this->head.
     * @param string $css Le contenu CSS à ajouter
     */
    public function appendCss(string $css): void
    {
        $this->head .= "<style>" . $css . "</style>";
    }

    /** Ajouter l'URL d'un script CSS dans $this->head.
     * @param string $url L'URL du script CSS
     */
    public function appendCssUrl(string $url): void
    {
        $this->head .= '<link href="'.$url.'" rel="stylesheet">'; //prise en compte comme code css : rel='stylesheet'
    }

    /** Ajouter un contenu JavaScript dans $this->head.
     * @param string $js Le contenu JavaScript à ajouter
     */
    public function appendJs(string $js): void
    {
        $this->head .= "<script>" . $js . "</script>";
    }

    /** Ajouter l'URL d'un script JavaScript dans $this->head.
     * @param string $url L'URL du script JavaScript
     */
    public function appendJsUrl(string $url): void
    {
        $this->head .= "<script src='$url'>" . "</script>";
    }

    /** Ajouter un contenu dans $this->body.
     * @param string $content Le contenu à ajouter
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /** Produire la page Web complète.
     * @return string
     */
    public function toHTML(): string
    {
        $res = <<<HTML
                <!DOCTYPE html>
                <html lang="fr">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>{$this->getTitle()}</title>
                        {$this->getHead()}
                    </head>
                    <body>
                        {$this->getBody()}
                    </body>
                </html>
                HTML;

        return $res;
    }

    /** Donner la date et l'heure de la dernière modification du script principal.
     * @return string
     */
    public static function getLastModification(): string
    {
        return date("F d Y H:i:s.", getlastmod());
    }
}
