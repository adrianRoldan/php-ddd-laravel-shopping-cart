<?php

namespace Cart\Shared\Domain\Contracts;

interface DependencyContainerContract
{
    public function resolve(string $class): mixed;
}
