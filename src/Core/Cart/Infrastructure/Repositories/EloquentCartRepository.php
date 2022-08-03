<?php

namespace Cart\Core\Cart\Infrastructure\Repositories;

use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Core\Cart\Domain\Enums\CartStatusEnum;
use Cart\Core\Cart\Domain\Exceptions\CartNotFoundException;
use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Infrastructure\Repositories\EloquentBaseRepository;

class EloquentCartRepository extends EloquentBaseRepository implements CartRepositoryContract
{

    public function store(Cart $cart): void
    {
        $this->upsert($cart, EloquentCart::class, $cart->serialize());
        $this->syncCartProducts($cart);
    }

    /**
     * @param CartId $cartId
     * @return Cart
     */
    public function byIdOrFail(CartId $cartId): Cart
    {
        /** @var  EloquentCart|null $elCart */
        $elCart = EloquentCart::query()->find($cartId->getValue());

        if(null === $elCart){
            throw CartNotFoundException::fromCartId($cartId);
        }

        return EloquentCartMapper::hydrate($elCart, $this->getCartProducts($elCart));
    }

    /**
     * @param UserId $userId
     * @return Cart
     */
    public function openByUserOrFail(UserId $userId): Cart
    {
        /** @var EloquentCart|null $elCart */
        $elCart = EloquentCart::query()
            ->where('userId', $userId->getValue())
            ->whereIn('status', [CartStatusEnum::open()->getValue(), CartStatusEnum::pending()->getValue()])
            ->first();

        if(null === $elCart){
            throw CartNotFoundException::fromUserId($userId);
        }
        return EloquentCartMapper::hydrate($elCart, $this->getCartProducts($elCart));
    }


    public function all(): array
    {
        /** @var EloquentCart[] $eloquentCarts */
        $eloquentCarts = EloquentCart::query()->get()->all();

        /** @var Cart[] $carts */
        $carts = array_map(function(EloquentCart $elCart){
            return EloquentCartMapper::hydrate($elCart, $this->getCartProducts($elCart));
        }, $eloquentCarts);

        return $carts;
    }


    /**
     * @param EloquentCart $elCart
     * @return EloquentCartProduct[]
     */
    private function getCartProducts(EloquentCart $elCart): array
    {
        /** @var EloquentCartProduct[] $cartProducts */
        $cartProducts = EloquentCartProduct::query()->where('cartId', $elCart->id)->get()->all();
        return $cartProducts;
    }


    /**
     * @param Cart $cart
     * @return void
     */
    private function syncCartProducts(Cart $cart)
    {
        /** @var EloquentCartProduct[] $currentCartProducts */
        $currentCartProducts = EloquentCartProduct::query()->where('cartId', $cart->id->getValue())->get()->keyBy('productId')->all();

        foreach($cart->products as $cartProduct)
        {
            if(isset($currentCartProducts[$cartProduct->productId->getValue()])){   //If exists in database
                $currentElCartProduct = $currentCartProducts[$cartProduct->productId->getValue()];    //Obtain the EloquentCartProduct instance

                if($currentElCartProduct->quantity !== $cartProduct->quantity->getValue()){   //Update the quantities if is necessary
                    EloquentCartProduct::query()
                        ->where(['cartId' => $cart->id->getValue(), 'productId' => $cartProduct->productId->getValue()])
                        ->update(['quantity' => $cartProduct->quantity->getValue()]);
                }
                unset($currentCartProducts[$cartProduct->productId->getValue()]);

            }else{  //If not exists, then we created it
                EloquentCartProduct::create([
                    'productId' => $cartProduct->productId->getValue(),
                    'cartId'    => $cart->id->getValue(),
                    'quantity'  => $cartProduct->quantity->getValue(),
                ]);
            }
        }

        //If there is still something left in the array, it is removed because it means the Domain Cart doesn't have it.
        foreach ($currentCartProducts as $elCartProduct) {
            EloquentCartProduct::query()
                ->where(['cartId' => $cart->id->getValue(), 'productId' => $elCartProduct->productId])
                ->delete();
        }
    }
}
