<?php

namespace Tests\Helper;

use Codeception\Exception\ModuleException;
use Database\MyPdo;

class Crud extends \Codeception\Module
{
    public function _initialize($settings = []): void
    {
        try {
            MyPdo::setConfiguration($this->getModule('Db')->_getConfig('dsn'));
        } catch (ModuleException $moduleException) {
            $this->fail('Codeception DB module not found');
        }
    }
}
