<?php

namespace Cart\Core\Product\Infrastructure\Repositories;

use Cart\Core\Product\Domain\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;


final class EloquentProductMapper
{
    public static function hydrate(EloquentProduct $elProduct): Product
    {
        return Product::hydrate([
            'id'          => ProductId::create($elProduct->id),
            'name'        => $elProduct->name,
            'description' => $elProduct->description,
            'price'       => $elProduct->price,
            'priceWithDiscount'   => $elProduct->priceWithDiscount,
            'minToDiscount'       => new ProductQuantity($elProduct->minToDiscount)
        ]);
    }
}
