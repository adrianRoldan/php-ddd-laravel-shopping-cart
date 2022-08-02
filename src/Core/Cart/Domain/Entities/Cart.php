<?php

namespace Cart\Core\Cart\Domain\Entities;

use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\Product;
use Cart\Shared\Domain\Entities\DomainEntity;

class Cart extends DomainEntity
{
    public CartId $id;
    /** @var Product[] $products */
    public array $products;
    public CartStatusEnum $status;

}
