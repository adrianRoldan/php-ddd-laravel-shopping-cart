<?php

namespace Cart\Core\Product\Infrastructure\Repositories;

use Cart\Core\Product\Domain\Entities\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\ValueObjects\Money\Amount;
use Cart\Shared\Domain\ValueObjects\Money\Money;


final class EloquentProductMapper
{
    public static function hydrate(EloquentProduct $elProduct): Product
    {
        return Product::hydrate([
            'id'          => ProductId::create($elProduct->id),
            'name'        => $elProduct->name,
            'description' => $elProduct->description,
            'price'               => Money::fromValues($elProduct->priceAmount, $elProduct->priceCurrency),
            'priceWithDiscount'   => Amount::fromValue($elProduct->priceWithDiscountAmount),
            'minForDiscount'      => new ProductQuantity($elProduct->minForDiscount)
        ]);
    }
}
