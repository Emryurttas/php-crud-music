<?php

namespace Tests\Crud;

use Entity\Cover;
use Entity\Exception\EntityNotFoundException;
use Tests\CrudTester;

class CoverCest
{
    public function findById(CrudTester $I): void
    {
        $cover = Cover::findById(411);
        $I->assertSame(411, $cover->getId());
        $I->assertSame(file_get_contents(codecept_data_dir().'/cover/cover411.jpeg'), $cover->getJpeg());
    }

    public function findByIdThrowsExceptionIfCoverDoesNotExist(CrudTester $I): void
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Cover::findById(PHP_INT_MAX);
        });
    }
}
