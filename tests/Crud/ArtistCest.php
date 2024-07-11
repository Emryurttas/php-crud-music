<?php

namespace Tests\Crud;

use Entity\Artist;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Tests\CrudTester;

class ArtistCest
{
    public function findById(CrudTester $I): void
    {
        $artist = Artist::findById(4);
        $I->assertSame(4, $artist->getId());
        $I->assertSame('Slipknot', $artist->getName());
    }

    public function findByIdThrowsExceptionIfArtistDoesNotExist(CrudTester $I): void
    {
        $I->expectThrowable(\Entity\Exception\EntityNotFoundException::class, function () {
            Artist::findById(PHP_INT_MAX);
        });
    }

    /**
     * @throws ParameterException
     */
    public function delete(CrudTester $I): void
    {
        $artist = Artist::findById(4);
        $artist->delete();
        $I->cantSeeInDatabase('artist', ['id' => 4]);
        $I->cantSeeInDatabase('artist', ['name' => 'Slipknot']);
        $I->assertNull($artist->getId());
        $I->assertSame('Slipknot', $artist->getName());
    }
    public function update(CrudTester $I): void
    {
        $artist = Artist::findById(4);
        $artist->setName('Nœud Coulant');
        $artist->save();
        $I->canSeeNumRecords(1, 'artist', [
            'id' => 4,
            'name' => 'Nœud Coulant'
        ]);
        $I->assertSame(4, $artist->getId());
        $I->assertSame('Nœud Coulant', $artist->getName());
    }
    public function createWithoutId(CrudTester $I): void
    {
        $artist = Artist::create('Nœud Coulant');
        $I->assertNull($artist->getId());
        $I->assertSame('Nœud Coulant', $artist->getName());
    }

    public function createWithId(CrudTester $I): void
    {
        $artist = Artist::create('Nœud Coulant', 4);
        $I->assertSame(4, $artist->getId());
        $I->assertSame('Nœud Coulant', $artist->getName());
    }
}
