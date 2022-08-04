<?php

namespace Tests\Unit\Core\Product;

use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Infrastructure\Repositories\EloquentProduct;
use Cart\Shared\Domain\ValueObjects\Money\Currency;
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
                'priceAmount'        => FakerMother::price(50),
                'priceCurrency'      => Currency::DEFAULT,
                'priceWithDiscountAmount' => FakerMother::price(40),
                'minForDiscount'     => FakerMother::quantity(1, 5)
            ], $params)
        );

        $eloquentProduct->save();
        return $eloquentProduct;
    }
}
