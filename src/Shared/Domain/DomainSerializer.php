<?php

namespace Cart\Shared\Domain;

use Cart\Shared\Domain\Contracts\IdentifierInterface;
use Cart\Shared\Domain\Entities\DomainEntity;
use Cart\Shared\Domain\Enums\DomainEnum;
use Cart\Shared\Domain\Events\DomainEvent;
use Cart\Shared\Framework\ObjectHelper;
use ReflectionClass;
use ReflectionProperty;

/**
 * Uses Reflection API
 */
final class DomainSerializer
{

    private DomainEntity|DomainEvent $classToSerialize;

    public function __construct(DomainEntity|DomainEvent $classToSerialize)
    {
        $this->classToSerialize = $classToSerialize;
    }

    /**
     * Returns a Domain Entity or Event serializated in array
     * @return array
     */
    public function serialize(): array
    {
        $attributesTransformed = [];
        $attributes = $this->getAttributesWithValues();

        /**
         * @var string $key
         * @var mixed $value
         */
        foreach ($attributes as $key => $value) {
            $valueTransformed = $value;
            if (is_array($value)) {
                $valueTransformed = json_encode($value);
            }
            if ($value instanceof DomainEnum) {
                $valueTransformed = $value->getValue();
            }
            if (is_object($value) && ObjectHelper::implements($value, IdentifierInterface::class)) {
                /** @var IdentifierInterface $value */
                $valueTransformed = $value->getValue();
            }
            $attributesTransformed[$key] = $valueTransformed;
        }
        return $attributesTransformed;
    }

    /**
     * Returns a Domain Entity or Event serializated in json
     * @return string
     */
    public function serializeJson(): string
    {
        return json_encode($this->serialize());
    }

    /**
     * @return array
     */
    private function getAttributesWithValues(): array
    {
        $values = [];
        $names = $this->getPublicAttributeArray();

        foreach ($names as $name) {
            $values[$name] = $this->classToSerialize->{$name};
        }

        return $values;
    }

    /**
     * @return array<string>
     */
    private function getPublicAttributeArray(): array
    {
        $class = new ReflectionClass($this->classToSerialize);
        $names = [];
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        return $names;
    }
}
