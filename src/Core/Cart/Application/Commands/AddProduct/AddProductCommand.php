<?php

namespace Cart\Core\Cart\Application\Commands\AddProduct;

use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandContract;

/**
 * @see AddProductHandler
 */
final class AddProductCommand implements CommandContract
{
    public ProductId $productId;
    public ProductQuantity $quantity;
    public CartId $cartId;

    /**
     * @param CartId $cartId
     * @param ProductId $productId
     * @param ProductQuantity $quantity
     */
    public function __construct(CartId $cartId, ProductId $productId, ProductQuantity $quantity)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}
