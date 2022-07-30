<?php

namespace Cart\Shared\Domain\Contracts;

interface IdentifierInterface
{

    /**
     * @param int|string $value
     * @return IdentifierInterface
     */
    public static function create(int|string $value): self;

    /**
     * @return string|int
     */
    public function getValue(): int|string;
}
