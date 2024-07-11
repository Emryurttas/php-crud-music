<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Escapes a string.
     *
     * @param string|null $text The text to escape.
     * @return string The escaped string.
     */
    public function escapeString(?string $text): string
    {
        if ($text === null) {
            return '';
        }
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}