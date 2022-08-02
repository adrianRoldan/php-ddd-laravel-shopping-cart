<?php

namespace Cart\Shared\Domain\ValueObjects;

use ReflectionClass;
use ReflectionProperty;

abstract class ValueObject
{

    /**
     * This functions helps to hydrate the entities with a valueObjects that has properties
     * @return array<int,mixed>
     */
    public function attributes(): array
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        return $names;
    }
}
