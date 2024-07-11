<?php

namespace Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;

class Browse extends \Codeception\Module
{
    /**
     * @throws ModuleException
     */
    public function seeResponseContentIs(string $expected, string $message = 'Response content does not match'): void
    {
        $this->assertEquals($expected, $this->getModule('PhpBrowser')->_getResponseContent(), $message);
    }
}
