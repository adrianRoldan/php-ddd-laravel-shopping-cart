<?php

namespace Cart\Shared\Domain\ValueObjects;

use Cart\Shared\Domain\Contracts\IdentifierInterface;
use Cart\Shared\Domain\Contracts\UuidProviderContract;
use Cart\Shared\Domain\Exceptions\ValidationUuidException;
use Cart\Shared\Infrastructure\Services\RamseyUuidProvider;


abstract class UuidValueObject implements IdentifierInterface
{
    private string $value;
    private static ?UuidProviderContract $uuidGenerator = null;

    final private function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }


    /**
     * @return static
     */
    public static function random(): self
    {
        $generator = self::getRamseyGenerator();
        return new static($generator->generateUuid());
    }


    /**
     * Create Uuid from value
     * @param string $value
     * @return static
     */
    public static function create($value): self
    {
        return new static($value);
    }


    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }


    /**
     * @return UuidProviderContract
     */
    protected static function getRamseyGenerator(): UuidProviderContract
    {
        if (null === self::$uuidGenerator) {
            $uuidProvider = new RamseyUuidProvider();
            self::$uuidGenerator = $uuidProvider;
        }

        return self::$uuidGenerator;
    }


    private function validate(string $value): void
    {
        if($value === "")
            throw ValidationUuidException::fromMessage("The ID is required");

        //Validates that value has the standar format of universal identifier
        if (!self::getRamseyGenerator()->isValid($value)) {
            throw ValidationUuidException::fromValue($value);
        }
    }
}
