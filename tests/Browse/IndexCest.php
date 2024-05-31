<?php

namespace Tests\Browse;

use Tests\BrowseTester;

class IndexCest
{
    public function checkAppWebPageHtmlStructure(BrowseTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Artistes');
        $I->seeElement('.header');
        $I->seeElement('.header h1');
        $I->see('Artistes', '.header h1');
        $I->seeElement('.content');
        $I->seeElement('.footer');
    }

    public function listAllArtists(BrowseTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->see('Artistes', 'h1');
        $I->seeElement('.content .list');
        $I->assertEquals(
            [
                'Joe Cocker',
                'Justin Bieber',
                'Lance & Donna',
                'Metallica',
                'Pantera',
                'Slipknot',
                'System Of A Down',
                'ZZ Top',
            ],
            $I->grabMultiple('.content .list a[href]')
        );
        // Check if strings are escaped
        $I->seeInSource('Lance &amp; Donna');
    }

    public function clickOnArtistLink(BrowseTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->click('System Of A Down');
        $I->seeInCurrentUrl('/artist.php?artistId=26');
    }
}
