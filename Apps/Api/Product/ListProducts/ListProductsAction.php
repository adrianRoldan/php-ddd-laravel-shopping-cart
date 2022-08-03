<?php

namespace Apps\Api\Product\ListProducts;

use Apps\Shared\ControllerAction;
use Cart\Core\Product\Application\Queries\ListProducts\ListProductsQuery;
use Cart\Core\Product\Domain\Dtos\ProductDto;

class ListProductsAction extends ControllerAction
{
    /**
     * @return ListProductsResource
     */
    public function __invoke(): ListProductsResource
    {
        /** @var ProductDto[] $products */
        $products = $this->queryBus->dispatch(new ListProductsQuery());

        return new ListProductsResource($products);
    }
}
