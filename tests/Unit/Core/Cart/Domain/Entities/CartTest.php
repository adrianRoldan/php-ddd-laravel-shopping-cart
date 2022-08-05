<?php

namespace Core\Cart\Domain\Entities;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Core\Cart\Domain\Exceptions\MaxProductsExceededException;
use Cart\Core\Cart\Domain\Exceptions\MaxQuantityExceededPerProductException;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Cart\Domain\ValueObjects\CartProduct;
use Cart\Core\Cart\Infrastructure\Repositories\EloquentCartRepository;
use Cart\Core\Product\Domain\Entities\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Core\Product\Infrastructure\Repositories\EloquentProductMapper;
use Cart\Core\Product\Infrastructure\Repositories\EloquentProductRepository;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\ValueObjects\Money\Amount;
use Cart\Shared\Domain\ValueObjects\Money\Money;
use Exception;
use Tests\FakerMother;
use Tests\TestCase;
use Tests\Unit\Core\Product\EloquentProductMother;

class CartTest extends TestCase
{

    public function test_add_product_works()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random());
        $products = $this->createProducts(1);
        $quantity = new ProductQuantity(2);

        //When
        $cart->addProduct($products[0], $quantity);

        //Then
        $this->assertIsArray($cart->products);
        $this->assertEquals(1, $cart->countProducts());
        $this->assertInstanceOf(CartProduct::class, $cart->products[$products[0]->id->getValue()]);
        $this->assertSame($products[0]->id, $cart->products[$products[0]->id->getValue()]->productId);
        $this->assertSame($quantity, $cart->products[$products[0]->id->getValue()]->quantity);
    }


    public function test_add_product_when_stress_it()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random());
        $maxProducts = CartSettings::MAX_DIFFERENT_PRODUCTS;
        $products = $this->createProducts($maxProducts);

        //When
        foreach($products as $product){
            $cart->addProduct($product, new ProductQuantity(CartSettings::MAX_PER_PRODUCT));
        }

        //Then
        $this->assertIsArray($cart->products);
        $this->assertEquals($maxProducts, $cart->countProducts());
    }


    public function test_add_product_when_exceeds_products()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random()); //Instance with STUB to have different limit constants
        $products = $this->createProducts(CartSettings::MAX_DIFFERENT_PRODUCTS + 1);

        //Then
        $this->expectException(MaxProductsExceededException::class);

        //When
        foreach($products as $product){
            $cart->addProduct($product, new ProductQuantity(FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT)));
        }
    }


    public function test_add_product_when_exceeds_quantity_per_product()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random()); //Instance with STUB to have different limit constants
        $products = $this->createProducts(1);
        $quantity = CartSettings::MAX_PER_PRODUCT + 1;

        //Then
        $this->expectException(MaxQuantityExceededPerProductException::class);
        $this->expectExceptionMessage($quantity. " exceeds the maximum quantity per product allowed (". CartSettings::MAX_PER_PRODUCT .")");
        $this->assertEquals(0, $cart->countProducts());

        //When
        $cart->addProduct($products[0], new ProductQuantity($quantity));
    }


    public function test_remove_product_works()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random());
        $numProducts = 5;
        $products = $this->createProducts($numProducts);
        /** @var Product $productToRemove */
        $productToRemove = $products[1];
        foreach($products as $product){
            $cart->addProduct($product, new ProductQuantity(CartSettings::MAX_PER_PRODUCT));
        }

        //When
        $cart->removeProduct($productToRemove);

        //Then
        $this->assertIsArray($cart->products);
        $this->assertEquals($numProducts - 1, $cart->countProducts());
        $this->assertArrayNotHasKey($productToRemove->id->getvalue(), $cart->products);
    }


    /**
     * @throws Exception
     */
    public function test_calculate_total_amount_works_with_discounts()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random());
        $prices = $this->getPrices();
        $products = $this->createProductsManuallyAndStore($prices);

        foreach($products as $product){
            $cart->addProduct($product, new ProductQuantity(CartSettings::MAX_PER_PRODUCT));
        }
        $expectedAmount = ($prices['priceDiscount1'] * CartSettings::MAX_PER_PRODUCT) + ($prices['priceDiscount2'] * CartSettings::MAX_PER_PRODUCT);

        //When
        $total = $cart->calculateTotalAmount(new EloquentProductRepository());

        //Then
        $this->assertInstanceOf(Money::class, $total);
        $this->assertEquals($expectedAmount, $total->getAmountValue());
    }

    /**
     * @throws Exception
     */
    public function test_calculate_total_amount_works_without_discounts()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random());
        $prices = $this->getPrices();
        $products = $this->createProductsManuallyAndStore($prices);
        $nunmProductsPerLine = 2;

        foreach($products as $product){
            $cart->addProduct($product, new ProductQuantity($nunmProductsPerLine));
        }
        $expectedAmount = ($prices['price1'] * $nunmProductsPerLine) + ($prices['price2'] * $nunmProductsPerLine);

        //When
        $total = $cart->calculateTotalAmount(new EloquentProductRepository());

        //Then
        $this->assertInstanceOf(Money::class, $total);
        $this->assertEquals($expectedAmount, $total->getAmountValue());
    }


    /**
     * Create random products
     * @param int $numProducts
     * @return array
     */
    private function createProducts(int $numProducts): array
    {
        $products = [];
        for($i = 0; $i < $numProducts; $i++) {
            $products[] = Product::create(
                ProductId::random(),
                FakerMother::productName(),
                FakerMother::text(45),
                Money::fromFloat(FakerMother::price(50)),
                Amount::fromValue(FakerMother::price(40)),
                new ProductQuantity(4)
            );
        }

        return $products;
    }


    /**
     * @throws Exception
     */
    private function createProductsManuallyAndStore(array $prices): array
    {
        $products = [];
        $elProduct = EloquentProductMother::random([
            'priceAmount' => $prices['price1'],
            'priceWithDiscountAmount' => $prices['priceDiscount1'],
            'minForDiscount' => 3
        ]);
        $products[] = EloquentProductMapper::hydrate($elProduct);

        $elProduct = EloquentProductMother::random([
            'priceAmount' => $prices['price2'],
            'priceWithDiscountAmount' => $prices['priceDiscount2'],
            'minForDiscount' => 4
        ]);
        $products[] = EloquentProductMapper::hydrate($elProduct);

        return $products;
    }

    /**
     * @return int[]
     */
    private function getPrices(): array
    {
        return [
            'price1' => 10,
            'priceDiscount1' => 9,
            'price2' => 15,
            'priceDiscount2' => 10
        ];
    }
}
