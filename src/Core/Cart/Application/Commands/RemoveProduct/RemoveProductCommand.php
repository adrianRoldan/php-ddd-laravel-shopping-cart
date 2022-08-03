<?php

namespace Cart\Core\Cart\Application\Commands\RemoveProduct;

use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandContract;

/**
 * @see RemoveProductHandler
 */
class RemoveProductCommand implements CommandContract
{
    public ProductId $productId;
    public UserId $userId;

    /**
     * @param ProductId $productId
     * @param UserId $userId
     */
    public function __construct(ProductId $productId, UserId $userId)
    {
        $this->productId = $productId;
        $this->userId = $userId;
    }
}
