<?php

namespace Tests\Form;

use Codeception\Example;
use Codeception\Stub;
use Entity\Artist;
use Entity\Exception\ParameterException;
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

    /**
     * @throws Exception
     */
    public function escapeArtistName(FormTester $I): void
    {
        $artist = Stub::make(Artist::class, ['id' => 90, 'name' => 'Art&iste']);
        $I->amTestingPartialHtmlContent((new ArtistForm($artist))->getHtmlForm('go.php'));

        $I->seeElement('input[value="Art&iste"]');
    }

    /**
     * @dataProvider artistNameProvider
     * @throws ParameterException
     */
    public function getNewArtistDataFromQueryString(FormTester $I, Example $example): void
    {
        $_POST['id'] = '';
        $_POST['name'] = $example['name'];
        $form = new ArtistForm();
        $form->setEntityFromQueryString();
        $I->assertInstanceOf(Artist::class, $form->getArtist());
        $I->assertNull($form->getArtist()->getId());
        $I->assertSame($example['expectedName'], $form->getArtist()->getName());
    }

    /**
     * @dataProvider artistNameProvider
     * @throws ParameterException
     */
    public function getExistingArtistDataFromQueryString(FormTester $I, Example $example): void
    {
        $_POST['id'] = '90';
        $_POST['name'] = $example['name'];
        $form = new ArtistForm();
        $form->setEntityFromQueryString();
        $I->assertInstanceOf(Artist::class, $form->getArtist());
        $I->assertSame(90, $form->getArtist()->getId());
        $I->assertSame($example['expectedName'], $form->getArtist()->getName());
    }

    protected function artistNameProvider(): array
    {
        return [
            ['name' => 'Artist', 'expectedName' => 'Artist'],
            ['name' => '    Artist        ', 'expectedName' => 'Artist'],
            ['name' => 'Artist', 'expectedName' => 'Artist'],
            ['name' => '      Artist      ', 'expectedName' => 'Artist'],
        ];
    }

    public function missingArtistNameFromQueryStringThrowsException(FormTester $I): void
    {
        $I->expectThrowable(ParameterException::class, function () {
            $_POST['id'] = '';
            $_POST['name'] = '';
            (new ArtistForm())->setEntityFromQueryString();
        });
    }
}
