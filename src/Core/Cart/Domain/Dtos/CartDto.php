<?php

namespace Cart\Core\Cart\Domain\Dtos;

use Cart\Core\Cart\Domain\ValueObjects\CartProduct;

final class CartDto
{
    public string $id;
    public string $userId;
    /** @var CartProduct[] $products */
    public array $products;
    public string $status;

    /**
     * @param string $id
     * @param string $userId
     * @param CartProduct[] $products
     * @param string $status
     */
    public function __construct(string $id, string $userId, array $products, string $status)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->products = $products;
        $this->status = $status;
    }
}
