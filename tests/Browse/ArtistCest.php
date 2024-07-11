<?php

namespace Tests\Browse;

use Codeception\Example;
use Tests\BrowseTester;

class ArtistCest
{
    public function checkAppWebPageHtmlStructure(BrowseTester $I): void
    {
        $I->amOnPage('/artist.php?artistId=4');
        $I->seeResponseCodeIs(200);
        $I->seeElement('.header');
        $I->seeElement('.header h1');
        $I->seeElement('.content');
        $I->seeElement('.footer');
    }

    public function loadArtistPageWithoutParameter(BrowseTester $I): void
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/artist.php');
        $I->seeResponseCodeIsRedirection();
        $I->followRedirect();
        $I->seeInCurrentUrl('/index.php');
    }

    /**
     * @dataProvider wrongParameterProvider
     */
    public function loadArtistPageWithWrongParameter(BrowseTester $I, Example $example): void
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/artist.php?artistId='.$example['id']);
        $I->seeResponseCodeIsRedirection();
        $I->followRedirect();
        $I->seeInCurrentUrl('/index.php');
    }

    protected function wrongParameterProvider(): array
    {
        return [
            ['id' => ''],
            ['id' => 'bad_id_value'],
        ];
    }

    public function loadArtistPageWithUnknownArtistId(BrowseTester $I): void
    {
        $I->amOnPage('/artist.php?artistId='.PHP_INT_MAX);
        $I->seeResponseCodeIs(404);
    }

    public function loadArtistAndAlbumsWithCorrectParameter(BrowseTester $I): void
    {
        $I->amOnPage('/artist.php?artistId=17');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Albums de Metallica', '.header h1');
        $I->see('Albums de Metallica', '.header h1');
        $I->assertEquals([
            'The Big 4: Live From Sofia, Bulgaria',
            'Death Magnetic',
            '2004/10/15 Quebec City, QC',
            'St. Anger',
            'St. Anger DVD',
            'S&M',
            'Garage Inc.',
            'Live in Detroit',
            'Reload',
            'Load',
            'Live Shit: Binge & Purge in Mexico City',
            'Black Album',
            'Prowling Osaka',
            '...And Justice For All',
            'Master of Puppets',
            'Ride The Lightning',
            'Kill \'Em All',
            'Sucking My Love',
        ], $I->grabMultiple('.content .list .album .album__name'));
        $I->assertEquals([
            2010,
            2008,
            2004,
            2003,
            2003,
            1999,
            1998,
            1998,
            1997,
            1996,
            1993,
            1991,
            1989,
            1988,
            1986,
            1984,
            1983,
            1982,
        ], $I->grabMultiple('.content .list .album .album__year'));
        // Check if strings are escaped
        $I->seeInSource('S&amp;M');
    }
}
