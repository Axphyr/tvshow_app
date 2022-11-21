<?php

namespace Html;

class AppWebPage extends WebPage
{
    private string $menu = "";

    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl('/css/style.css');
    }

    /**
     * @return string Menu
     */
    public function getMenu(): string
    {
        return $this->menu;
    }

    /**
     * @param string $menu Ajoute au menu
     */
    public function appendMenu(string $menu)
    {
        $this->menu .= $menu;
    }


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
                        <header class="header">
                        <h1>{$this->getTitle()}</h1>
                        </header>
                        
                        
                        <div class="content">
                                <ul class="menu">
                                    {$this->getMenu()}
                                </ul>
                                
                           <div class="list">
                        
                        {$this->getBody()}
                            
                           </div>
                                
                        </div>
                            
                            
                        <footer class="footer">
                        <p>Dernière modification : {$this->getLastModification()}</p>
                        </footer>
                    </body>
                </html>
                HTML;

        return $res;
    }
}
