<?php

namespace Cart\Core\Product\Infrastructure\Repositories;

use Cart\Core\Product\Domain\Exceptions\ProductNotFoundException;
use Cart\Core\Product\Domain\Product;
use Cart\Core\Product\Domain\Repositories\ProductRepositoryContract;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Shared\Infrastructure\Repositories\EloquentBaseRepository;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepositoryContract
{

    public function store(Product $product): void
    {
        $this->upsert($product, EloquentProduct::class, $product->serialize());
    }

    public function byIdOrFail(ProductId $productId): Product
    {
        /** @var  EloquentProduct|null $elProduct */
        $elProduct = EloquentProduct::query()->find($productId->getValue());

        if(null === $elProduct){
            throw ProductNotFoundException::fromProductId($productId);
        }
        return EloquentProductMapper::hydrate($elProduct);
    }

    /**
     * @return Product[]
     */
    public function all(): array
    {
        /** @var EloquentProduct[] $eloquentProducts */
        $eloquentProducts = EloquentProduct::query()->get()->all();

        /** @var Product[] $products */
        $products = array_map(static function(EloquentProduct $elProduct){
            return EloquentProductMapper::hydrate($elProduct);
        }, $eloquentProducts);

        return $products;
    }
}
