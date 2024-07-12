<?php

namespace Tests\Browse;

use Codeception\Example;
use Tests\BrowseTester;

class ArtistEditCest
{
    public function loadNewArtistFormPage(BrowseTester $I): void
    {
        $I->amOnPage('/admin/artist-form.php');
        $I->seeResponseCodeIs(200);
        $I->seeInFormFields('form', [
            'id' => '',
            'name' => '',
        ]);
    }

    public function loadExistingArtistFormPage(BrowseTester $I): void
    {
        $I->amOnPage('/admin/artist-form.php?artistId=4');
        $I->seeResponseCodeIs(200);
        $I->seeInFormFields('form', [
            'id' => '4',
            'name' => 'Slipknot',
        ]);
    }

    public function loadArtistFormWithUnknownArtistId(BrowseTester $I): void
    {
        $I->amOnPage('/admin/artist-form.php?artistId='.PHP_INT_MAX);
        $I->seeResponseCodeIs(404);
    }

    /**
     * @dataProvider wrongParameterProvider
     */
    public function loadArtistFormWithWrongParameter(BrowseTester $I, Example $example): void
    {
        $I->amOnPage('/admin/artist-form.php?artistId='.$example['id']);
        $I->seeResponseCodeIs(400);
    }

    protected function wrongParameterProvider(): array
    {
        return [
            ['id' => ''],
            ['id' => 'bad_id_value'],
        ];
    }
}
