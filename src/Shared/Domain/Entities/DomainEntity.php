<?php

namespace Cart\Shared\Domain\Entities;


use Cart\Shared\Domain\Contracts\IdentifierInterface;
use Cart\Shared\Domain\Enums\DomainEnum;
use Cart\Shared\Framework\ObjectHelper;
use ReflectionClass;
use ReflectionProperty;

abstract class DomainEntity
{

    /**
     * @param array $array
     * @return static
     */
    public static function hydrate(array $array = []): self
    {
        $entity = new static();
        $entityProperties = (new ReflectionClass($entity))->getProperties();

        foreach ($array as $key => $item) {

            foreach($entityProperties as $property)
            {
                if($property->name === $key){
                    $entity->{$key} = $item;
                }
            }
        }
        return $entity;
    }


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


    public function getAttributesWithValues(array $names = null, array $except = []): array
    {
        $values = [];
        if (null === $names) {
            $names = $this->getPublicAttributeArray();
        }
        foreach ($names as $name) {
            $values[$name] = $this->{$name};
        }
        foreach ($except as $name) {
            unset($values[$name]);
        }

        return $values;
    }

    /**
     * @return array<string>
     */
    public function getPublicAttributeArray(): array
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
