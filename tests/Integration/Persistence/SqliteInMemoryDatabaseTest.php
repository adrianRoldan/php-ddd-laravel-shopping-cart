<?php

namespace Tests\Integration\Persistence;


use Exception;
use Tests\TestCase;
use Tests\Unit\Core\Product\EloquentProductMother;

class SqliteInMemoryDatabaseTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testSqliteInMemoryDatabaseWorks()
    {
        $elProduct = EloquentProductMother::random();

        //Check the product exists in database
        $this->assertDatabaseHas('products', [
            'id'    => $elProduct->id,
            'name'  => $elProduct->name,
            'description' => $elProduct->description,
            'priceAmount' => $elProduct->priceAmount,
            'createdAt'   => $elProduct->createdAt,
            'updatedAt'   => $elProduct->updatedAt
        ]);
    }
}
