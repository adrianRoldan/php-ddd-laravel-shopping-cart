<?php

namespace Apps\Api\Product\ListProducts;

use Apps\Shared\Http\Response\ResourceContract;
use Cart\Core\Product\Domain\Dtos\ProductDto;

class ListProductsResource implements ResourceContract
{
    /**
     * @var ProductDto[]
     */
    private array $products;

    /**
     * @param ProductDto[] $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->products;
    }
}
