<?php

declare(strict_types=1);

namespace Tests\Helper;

use Codeception\Module;
use Codeception\Util\Locator;
use DOMDocument;
use DOMXPath;

class Dom extends \Codeception\Module
{
    private DOMXPath $domXPath;

    public function amTestingPartialHtmlContent(string $partialHtmlContent): void
    {
        $this->domXPath = $this->createDomXPathFromHtmlString($partialHtmlContent);
    }

    /**
     * Creates a DomXPath from a partial HTML string.
     *
     * @param string $htmlString partial HTML content
     */
    protected function createDomXPathFromHtmlString(string $htmlString): DOMXPath
    {
        libxml_use_internal_errors(false);
        libxml_clear_errors();

        $domDocument = new DOMDocument();
        $domDocument->strictErrorChecking = true;
        if ('' === $htmlString) {
            $this->fail('HTML string is empty');
        }
        if (false === @$domDocument->loadHTML($htmlString, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_PEDANTIC)) {
            $this->fail('unable to load partial HTML from string');
        }
        if (($lastError = libxml_get_last_error()) !== false) {
            $this->fail('unable to load partial HTML from string: '.$lastError->message);
        }

        return new DOMXPath($domDocument);
    }

    /**
     * Locates an element containing a text inside. Either CSS or XPath locator can be passed, however they will be converted to XPath.
     *
     * @see https://codeception.com/docs/reference/Locator#contains
     */
    public function seeElementContainingText(string $element, string $text): void
    {
        $this->assertCount(
            1,
            $this->domXPath->query(Locator::contains($element, $text))
        );
    }

    /**
     * Locates first element of group elements. Either CSS or XPath locator can be passed as locator, Equal to Locator::elementAt($locator, 1).
     *
     * @see https://codeception.com/docs/reference/Locator#firstElement
     */
    public function seeElement(string $element): void
    {
        $this->assertCount(
            1,
            $this->domXPath->query(Locator::firstElement($element))
        );
    }

    /**
     * Locates first element of group elements. Either CSS or XPath locator can be passed as locator, Equal to Locator::elementAt($locator, 1).
     *
     * @see https://codeception.com/docs/reference/Locator#firstElement
     */
    public function dontSeeElement(string $element): void
    {
        $this->assertCount(
            0,
            $this->domXPath->query(Locator::firstElement($element))
        );
    }
}
