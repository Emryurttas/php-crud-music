<?php

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }

    public function toHTML(): string
    {
        return <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    {$this->getHead()}
                    <title>{$this->getTitle()}</title>
                </head>
                <body>
                    <header>
                    </header>
                    <main>
                        {$this->getBody()}
                    </main>
                    <footer>
                        <div id="lastmodified">{$this->getLastModification()}</div>
                    </footer>
                </body>
            </html>
        HTML;
    }
}
