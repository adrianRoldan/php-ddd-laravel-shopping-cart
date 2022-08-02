<?php

namespace Cart\Core\Cart\Domain\ValueObjects;

use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\ValueObjects\ValueObject;

final class CartProduct extends ValueObject
{
    public ProductId $productId;
    public ProductQuantity $quantity;
    public bool $discount;

    /**
     * @param ProductId $productId
     * @param ProductQuantity $quantity
     * @param bool $discount
     */
    public function __construct(ProductId $productId, ProductQuantity $quantity, bool $discount)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->discount = $discount;
    }
}
