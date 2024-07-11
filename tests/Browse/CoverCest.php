<?php

namespace Tests\Browse;

use Codeception\Example;
use Exception;
use Tests\BrowseTester;

class CoverCest
{
    public function loadCoverWithoutParameter(BrowseTester $I): void
    {
        $I->amOnPage('/Cover.php');
        $I->seeResponseCodeIs(400);
    }

    /**
     * @dataProvider wrongParameterProvider
     */
    public function loadCoverWithWrongParameter(BrowseTester $I, Example $example): void
    {
        $I->amOnPage('/Cover.php?coverId='.$example['id']);
        $I->seeResponseCodeIs($example['response']);
    }

    protected function wrongParameterProvider(): array
    {
        return [
            ['id' => '', 'response' => 400],
            ['id' => 'bad_id_value', 'response' => 400],
            ['id' => (string) PHP_INT_MAX, 'response' => 404],
        ];
    }

    /**
     * @throws Exception
     */
    public function loadCoverWithCorrectParameter(BrowseTester $I): void
    {
        $I->amOnPage('/Cover.php?coverId=411');
        $I->seeResponseCodeIs(200);
        $I->haveHttpHeader('Content-Type', 'image/jpeg');
        $I->seeResponseContentIs(file_get_contents(codecept_data_dir().'/cover/cover411.jpeg'));
    }
}
