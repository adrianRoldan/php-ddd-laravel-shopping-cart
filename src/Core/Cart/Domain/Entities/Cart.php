<?php

namespace Cart\Core\Cart\Domain\Entities;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Cart\Domain\Enums\CartStatusEnum;
use Cart\Core\Cart\Domain\Events\CartCreatedEvent;
use Cart\Core\Cart\Domain\Events\ProductAddedEvent;
use Cart\Core\Cart\Domain\Exceptions\MaxProductsExceededException;
use Cart\Core\Cart\Domain\Exceptions\MaxQuantityExceededPerProductException;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Cart\Domain\ValueObjects\CartProduct;
use Cart\Core\Product\Domain\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\Entities\DomainEntity;

class Cart extends DomainEntity
{
    public CartId $id;
    public UserId $userId;
    /** @var CartProduct[] $products */
    public array $products;
    public CartStatusEnum $status;

    /**
     * @param CartId $id
     * @param UserId $userId
     * @return Cart
     */
    public static function create(CartId $id, UserId $userId): self
    {
        $instance = new self();
        $instance->id = $id;
        $instance->userId = $userId;
        $instance->products = [];
        $instance->status = CartStatusEnum::pending();

        $instance->recordEvent(CartCreatedEvent::create($instance));

        return $instance;
    }


    public function addProduct(Product $product, ProductQuantity $quantity): void
    {
        $this->canBeAdded($product);

        $newQuantity = $this->calculateNewQuantity($product, $quantity);
        $this->products[$product->id->getValue()] = new CartProduct($product->id, $newQuantity, $this->hasDiscount($product, $newQuantity));

        $this->recordEvent(ProductAddedEvent::create($product, $this->id, $quantity));
    }


    private function canBeAdded(Product $product): void
    {
        if(!$this->existsProduct($product)){

            if($this->countProducts() >= CartSettings::MAX_DIFFERENT_PRODUCTS){
                throw MaxProductsExceededException::create();
            }
        }
    }

    public function countProducts(): int
    {
        return count($this->products);
    }


    private function calculateNewQuantity(Product $product, ProductQuantity $newQuantity): ProductQuantity
    {
        if($this->existsProduct($product)) {
            $cartProduct = $this->products[$product->id->getValue()];
            $newQuantity = $cartProduct->quantity->sum($newQuantity);
        }

        if($newQuantity->getValue() > CartSettings::MAX_PER_PRODUCT){
            throw MaxQuantityExceededPerProductException::fromQuantity($newQuantity);
        }

        return $newQuantity;
    }

    /**
     * @param Product $product
     * @return bool
     */
    private function existsProduct(Product $product): bool
    {
        return isset($this->products[$product->id->getValue()]);
    }

    private function hasDiscount(Product $product, ProductQuantity $newQuantity)
    {
        return false;
    }
}
