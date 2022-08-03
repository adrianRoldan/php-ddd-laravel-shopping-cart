<?php

namespace Apps\Api\Cart\ShowCart;

use Apps\Shared\Http\Response\ResourceContract;
use Cart\Core\Cart\Domain\Dtos\CartDto;

final class ShowCartResource implements ResourceContract
{
    private CartDto $cartDto;

    public function __construct(CartDto $cartDto)
    {
        $this->cartDto = $cartDto;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $products = [];
        foreach($this->cartDto->products as $cartProduct){
            $products[] = [
                "productId" => $cartProduct->productId->getValue(),
                "quantity"  => $cartProduct->quantity->getValue()
            ];
        }

        return [
            "id"        => $this->cartDto->id,
            "userId"    => $this->cartDto->userId,
            "status"    => $this->cartDto->status,
            "products"  => $products
        ];
    }
}
