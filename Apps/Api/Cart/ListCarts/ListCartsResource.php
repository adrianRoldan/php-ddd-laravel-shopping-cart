<?php

namespace Apps\Api\Cart\ListCarts;

use Apps\Shared\Http\Response\ResourceContract;
use Cart\Core\Cart\Domain\Dtos\CartDto;

class ListCartsResource implements ResourceContract
{
    /**
     * @var CartDto[]
     */
    private array $carts;

    /**
     * @param CartDto[] $carts
     */
    public function __construct(array $carts)
    {
        $this->carts = $carts;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_map(static function(CartDto $cartDto){

            $products = [];
            foreach($cartDto->products as $cartProduct){
                $products[] = [
                    "productId" => $cartProduct->productId->getValue(),
                    "quantity"  => $cartProduct->quantity->getValue()
                ];
            }
            return [
                "id"        => $cartDto->id,
                "userId"    => $cartDto->userId,
                "status"    => $cartDto->status,
                "products"  => $products
            ];
        }, $this->carts);
    }
}
