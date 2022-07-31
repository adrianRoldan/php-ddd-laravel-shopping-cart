<?php

namespace Cart\Core\Cart\Application\Commands\AddProduct;

use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandContract;

/**
 * @see AddProductHandler
 */
final class AddProductCommand implements CommandContract
{
    public ProductId $productId;
    public int $quantity;

    /**
     * @param ProductId $productId
     * @param int $quantity
     */
    public function __construct(ProductId $productId, int $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}
