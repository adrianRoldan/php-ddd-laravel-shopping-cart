<?php

namespace Cart\Core\Product\Infrastructure\Repositories;

use Cart\Core\Product\Domain\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductId;


final class ProductMapper
{
    public static function hydrate(EloquentProduct $elProduct): Product
    {
        return Product::hydrate([
            'id'          => ProductId::create($elProduct->id),
            'name'        => $elProduct->name,
            'description' => $elProduct->description,
            'price'       => $elProduct->price
        ]);
    }
}
