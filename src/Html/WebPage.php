<?php

declare(strict_types=1);

namespace Html;

/**
 * Classe WebPage
 *
 * Représente une page web de base avec une section head, un titre et un corps.
 */

class WebPage
{
    private string $head = "";
    private string $title = "";
    private string $body = "";

    /**
     * Constructeur de la classe WebPage.
     *
     * @param string $title Le titre de la page web.
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Obtient le contenu de la section head.
     *
     * @return string Le contenu de la section head.
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Obtient le titre de la page.
     *
     * @return string Le titre de la page.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Définit le titre de la page.
     *
     * @param string $title Le titre à définir pour la page.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Obtient le contenu de la section body.
     *
     * @return string Le contenu de la section body.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Ajoute du contenu à la section head.
     *
     * @param string $content Le contenu à ajouter à la section head.
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Ajoute du CSS à la section head.
     *
     * @param string $css Le CSS à ajouter à la section head.
     */
    public function appendCss(string $css): void
    {
        $this->head .= "<style>$css</style>";
    }

    /**
     * Ajoute un lien vers un fichier CSS à la section head.
     *
     * @param string $url L'URL du fichier CSS à ajouter à la section head.
     */
    public function appendCssUrl(string $url): void
    {
        $this->head .= "<link rel='stylesheet' type='text/css' href='$url'>";
    }

    /**
     * Ajoute du JavaScript à la section body.
     *
     * @param string $js Le JavaScript à ajouter à la section body.
     */
    public function appendJs(string $js): void
    {
        $this->head .= "<script>$js</script>";
    }

    /**
     * Ajoute un lien vers un fichier JavaScript à la section body.
     *
     * @param string $url L'URL du fichier JavaScript à ajouter à la section body.
     */
    public function appendJsUrl(string $url): void
    {
        $this->head .= "<script src='$url'></script>";
    }

    /**
     * Ajoute du contenu directement à la section body.
     *
     * @param string $content Le contenu à ajouter à la section body.
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Génère le code HTML complet de la page.
     *
     * @return string Le code HTML complet de la page.
     */
    public function toHTML(): string
    {
        return <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    {$this->head}
                    <title>{$this->title}</title>
                </head>
                <body>
                     {$this->body}
                     <div id="lastmodified">{$this->getLastModification()}</div>
                </body>
            </html>
        HTML;
    }



    /**
     * Échappe une chaîne de caractères pour la rendre sûre à afficher dans une page HTML.
     *
     * @param string $string La chaîne de caractères à échapper.
     * @return string La chaîne de caractères échappée.
     */
    public function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * Obtient la date et l'heure de la dernière modification de la page.
     *
     * @return string La date et l'heure de la dernière modification de la page.
     */
    public function getLastModification(): string
    {
        return "Dernière modification de cette page le ". date("d/m/Y à H:i:s", getlastmod());
    }
}
