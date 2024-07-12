<?php

namespace Tests\Form;

use Codeception\Stub;
use Entity\Artist;
use Exception;
use Html\Form\ArtistForm;
use Tests\FormTester;

class ArtistFormCest
{
    /**
     * @throws Exception
     */
    public function correctBaseStructure(FormTester $I): void
    {
        $artist = Stub::make(Artist::class, ['id' => 90, 'name' => 'Artiste']);
        $I->amTestingPartialHtmlContent((new ArtistForm($artist))->getHtmlForm('go.php'));

        $I->seeElement('form[method="post"][action="go.php"]');
        $I->seeElement('form input[type="hidden"][name="id"  ]');
        $I->seeElement('form input[type="text"  ][name="name"][required]');
        $I->seeElement('form *[type="submit"]');
    }

    public function checkValuesOfNewArtist(FormTester $I): void
    {
        $I->amTestingPartialHtmlContent((new ArtistForm())->getHtmlForm('go.php'));

        $I->seeElement('form input[type="hidden"][name="id"  ][value=""]');
        $I->seeElement('form input[type="text"  ][name="name"][value=""][required]');
    }

    /**
     * @throws Exception
     */
    public function checkValuesOfExistingArtist(FormTester $I): void
    {
        $artist = Stub::make(Artist::class, ['id' => 90, 'name' => 'Artiste']);
        $I->amTestingPartialHtmlContent((new ArtistForm($artist))->getHtmlForm('go.php'));

        $I->seeElement('form input[type="hidden"][name="id"  ][value="90"     ]');
        $I->seeElement('form input[type="text"  ][name="name"][value="Artiste"][required]');
    }

    public function escapeArtistName(FormTester $I): void
    {
        $artist = Stub::make(Artist::class, ['id' => 90, 'name' => 'Art&iste']);
        $I->amTestingPartialHtmlContent((new ArtistForm($artist))->getHtmlForm('go.php'));

        $I->seeElement('input[value="Art&iste"]');
    }
}
