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
                    <main>
                        {$this->getBody()}
                    </main>
                </body>
            </html>
        HTML;
    }
}
