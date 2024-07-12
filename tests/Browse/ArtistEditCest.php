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
    /**
     * @depends loadNewArtistFormPage
     */
    public function insertArtist(BrowseTester $I): void
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/admin/artist-form.php');
        $I->submitForm('form', ['name' => 'NewArtist']);
        $I->seeInCurrentUrl('/admin/artist-save.php');
        $I->seeResponseCodeIs(302);
        $I->seeNumRecords(1, 'artist', ['name' => 'NewArtist']);
    }

    /**
     * @depends loadNewArtistFormPage
     */
    public function insertArtistWithMissingName(BrowseTester $I): void
    {
        $I->amOnPage('/admin/artist-form.php');
        $I->submitForm('form', ['name' => '']);
        $I->seeInCurrentUrl('/admin/artist-save.php');
        $I->seeResponseCodeIs(400);
        $I->seeNumRecords(0, 'artist', ['name' => '']);
    }

    /**
     * @depends loadExistingArtistFormPage
     */
    public function updateArtist(BrowseTester $I): void
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/admin/artist-form.php?artistId=4');
        $I->submitForm('form', ['name' => 'UpdatedArtist']);
        $I->seeInCurrentUrl('/admin/artist-save.php');
        $I->seeResponseCodeIs(302);
        $I->seeNumRecords(1, 'artist', [
            'id' => 4,
            'name' => 'UpdatedArtist'
        ]);
    }

    /**
     * @depends loadExistingArtistFormPage
     */
    public function updateArtistWithMissingName(BrowseTester $I): void
    {
        $I->amOnPage('/admin/artist-form.php?artistId=4');
        $I->submitForm('form', ['name' => '']);
        $I->seeInCurrentUrl('/admin/artist-save.php');
        $I->seeResponseCodeIs(400);
        $I->seeNumRecords(1, 'artist', [
            'id' => 4,
            'name' => 'Slipknot'
        ]);
    }
    public function deleteArtist(BrowseTester $I): void
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/admin/artist-delete.php?artistId=4');
        $I->seeResponseCodeIs(302);
        $I->seeNumRecords(0, 'artist', [
            'id' => 4,
        ]);
    }

    public function deleteArtistWithoutId(BrowseTester $I): void
    {
        $I->amOnPage('/admin/artist-delete.php');
        $I->seeResponseCodeIs(400);
        $I->seeNumRecords(8, 'artist');
    }

    /**
     * @example { "id": "", "code": 400 }
     * @example { "id": "1000", "code": 404 }
     * @example { "id": "id", "code": 400 }
     */

    public function deleteArtistWithWrongId(BrowseTester $I, Example $example): void
    {
        $I->amOnPage('/admin/artist-delete.php?artistId=' . $example['id']);
        $I->seeResponseCodeIs($example['code']);
        $I->seeNumRecords(8, 'artist');
    }
}
