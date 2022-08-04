<?php

namespace Cart\Core\Cart\Domain\Entities;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Cart\Domain\Enums\CartStatusEnum;
use Cart\Core\Cart\Domain\Events\CartCreatedEvent;
use Cart\Core\Cart\Domain\Events\ProductAddedEvent;
use Cart\Core\Cart\Domain\Events\ProductRemovedEvent;
use Cart\Core\Cart\Domain\Exceptions\MaxProductsExceededException;
use Cart\Core\Cart\Domain\Exceptions\MaxQuantityExceededPerProductException;
use Cart\Core\Cart\Domain\Exceptions\ProductInCartNotFound;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Cart\Domain\ValueObjects\CartProduct;
use Cart\Core\Product\Domain\Entities\Product;
use Cart\Core\Product\Domain\Repositories\ProductRepositoryContract;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\Entities\DomainEntity;
use Cart\Shared\Domain\ValueObjects\Money\Money;

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
        $instance->status = CartStatusEnum::open();

        $instance->recordEvent(CartCreatedEvent::create($instance));

        return $instance;
    }

    /**
     * @param Product $product
     * @param ProductQuantity $quantity
     * @return void
     */
    public function addProduct(Product $product, ProductQuantity $quantity): void
    {
        $this->canBeAdded($product);

        $newQuantity = $this->calculateNewQuantity($product, $quantity);
        $this->products[$product->id->getValue()] = new CartProduct($product->id, $newQuantity, $this->hasDiscount($product, $newQuantity));

        $this->recordEvent(ProductAddedEvent::create($product, $this->id, $quantity));
    }


    /**
     * @param Product $product
     * @return void
     */
    public function removeProduct(Product $product): void
    {
        $this->canBeRemoved($product);

        unset($this->products[$product->id->getValue()]);

        $this->recordEvent(ProductRemovedEvent::create($product, $this->id));
    }


    /**
     * @param ProductRepositoryContract $productRepository
     * @param bool $withDiscounts
     * @return Money
     */
    public function calculateTotalAmount(ProductRepositoryContract $productRepository, bool $withDiscounts = true): Money
    {
        $amount = Money::createEmpty();

        foreach($this->products as $cartProduct){

            $product = $productRepository->byIdOrFail($cartProduct->productId);

            $productPrice = $product->price($cartProduct->quantity, $withDiscounts);    //Obtain individual price of product
            $cartProductPrice = $productPrice->multiply($cartProduct->quantity->getValue());    //Price of cart line (cartproduct)

            $amount = $amount->sum($cartProductPrice);    //Acumulate prices of cart
        }

        return $amount;
    }


    /**
     * @return int
     */
    public function countProducts(): int
    {
        return count($this->products);
    }


    /**
     * @param Product $product
     * @return void
     */
    private function canBeAdded(Product $product): void
    {
        if(!$this->existsProduct($product)){

            if($this->countProducts() >= CartSettings::MAX_DIFFERENT_PRODUCTS){
                throw MaxProductsExceededException::create();
            }
        }
    }


    /**
     * @param Product $product
     * @return void
     */
    private function canBeRemoved(Product $product): void
    {
        if (!$this->existsProduct($product)) {
            throw ProductInCartNotFound::fromProductAndCart($product->id, $this->id);
        }
    }


    /**
     * @param Product $product
     * @param ProductQuantity $newQuantity
     * @return ProductQuantity
     */
    private function calculateNewQuantity(Product $product, ProductQuantity $newQuantity): ProductQuantity
    {
        if($this->existsProduct($product)) {
            $cartProduct = $this->products[$product->id->getValue()];
            $newQuantity = $cartProduct->quantity->sum($newQuantity);
        }

        if($newQuantity->getValue() > CartSettings::MAX_PER_PRODUCT){
            throw MaxQuantityExceededPerProductException::fromQuantity($newQuantity->getValue());
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

    /**
     * @param Product $product
     * @param ProductQuantity $newQuantity
     * @return false
     */
    private function hasDiscount(Product $product, ProductQuantity $newQuantity)
    {
        return false;
    }
    }
