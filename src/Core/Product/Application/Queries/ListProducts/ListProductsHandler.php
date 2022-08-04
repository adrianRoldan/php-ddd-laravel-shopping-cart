<?php

namespace Cart\Core\Product\Application\Queries\ListProducts;


use Cart\Core\Product\Domain\Dtos\ProductDto;
use Cart\Core\Product\Domain\Entities\Product;
use Cart\Core\Product\Domain\Repositories\ProductRepositoryContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryHandlerContract;


final class ListProductsHandler implements QueryHandlerContract
{
    private ProductRepositoryContract $repository;

    /**
     * @param ProductRepositoryContract $repository
     */
    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ListProductsQuery $query
     * @return ProductDto[]
     */
    public function handle(ListProductsQuery $query): array
    {
        $products = $this->repository->all();

        return array_map(static function(Product $product){

            return new ProductDto(
                $product->id->getValue(),
                $product->name,
                $product->description,
                $product->price->getAmountValue(),
                $product->priceWithDiscount->getValue(),
                $product->price->currency->getValue(),
                $product->minForDiscount->getValue());
        }, $products);
    }
}
