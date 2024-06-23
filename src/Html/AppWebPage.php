<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = '')
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");

    }

    public function toHTML(): string
    {
        return " <!doctype html>
                  <html lang='fr'>
                  <head>
                    <meta charset = 'UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    {$this->getHead()}
                    <title>{$this->getTitle()}</title>
                  </head>
                  <body>
                    <header class='header'>
                        <h1>{$this->getTitle()}</h1>
                    </header>
                    <div class='content'>
                        {$this->getBody()}
                    </div>
                    <footer class='footer'>
                        {$this->getLastModification()}
                    </footer>
                  </body> 
                 </html>";
    }



}
