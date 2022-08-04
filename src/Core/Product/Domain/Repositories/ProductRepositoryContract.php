<?php

namespace Cart\Core\Product\Domain\Repositories;

use Cart\Core\Product\Domain\Entities\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductId;

interface ProductRepositoryContract
{
    public function store(Product $product): void;

    public function byIdOrFail(ProductId $productId): Product;

    /**
     * @return Product[]
     */
    public function all(): array;
}
