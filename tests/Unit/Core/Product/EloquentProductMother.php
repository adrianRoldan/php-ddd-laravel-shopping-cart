<?php

namespace Tests\Unit\Core\Product;

use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Infrastructure\Repositories\EloquentProduct;
use Exception;
use Tests\FakerMother;

final class EloquentProductMother
{

    /**
     * @throws Exception
     */
    public static function random(array $params = []): EloquentProduct
    {
        $eloquentProduct = EloquentProduct::make(
            array_merge([
                'id'           => ProductId::random()->getValue(),
                'name'         => FakerMother::productName(),
                'description'  => FakerMother::text(),
                'price'        => FakerMother::price(50)
            ], $params)
        );

        $eloquentProduct->save();
        return $eloquentProduct;
    }
}
