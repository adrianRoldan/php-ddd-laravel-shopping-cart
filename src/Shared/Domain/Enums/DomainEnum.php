<?php

namespace Cart\Shared\Domain\Enums;

use Cart\Shared\Domain\Exceptions\InvalidEnumException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;

abstract class DomainEnum
{
    private string $value;

    final protected function __construct()
    {
    }


    /**
     * @return static
     * @throws ReflectionException
     *
     */
    public static function random(): self
    {
        $values = self::obtainValues();
        return self::fromValue($values[array_rand($values)]);
    }

    /**
     * @param string $value
     * @return static
     * @throws InvalidEnumException
     */
    public static function fromValue(string $value): self
    {
        $enum = new static();
        try {
            if (self::isValidValue($value, false === is_numeric($value))) {
                $enum->value = $value;
            } else {
                throw InvalidEnumException::fromMessage("Invalid enum: ".static::class . ' - ' . self::class . ' - ' . $value);
            }
        } catch (ReflectionException $e) {
            Log::error($e->getMessage());
        }
        return $enum;
    }


    /**
     * @param int|string $value
     * @param bool $strict
     * @return bool
     * @throws ReflectionException
     */
    public static function isValidValue($value, bool $strict = true): bool
    {
        $values = array_values(self::obtainConstants());
        return in_array($value, $values, $strict);
    }


    /**
     * @return array<string,string>
     * @throws ReflectionException
     */
    public static function obtainConstants(): array
    {
        $calledClass = static::class;
        return (new ReflectionClass($calledClass))->getConstants();
    }

    /**
     * @return array<int,string>
     * @throws ReflectionException
     */
    public static function obtainValues(): array
    {
        return array_values(self::obtainConstants());
    }

    /**
     * @param string $name
     * @return static
     * @throws InvalidEnumException
     */
    public static function fromName(string $name): self
    {
        $enum = new static();
        try {
            if (self::isValidName($name)) {
                $constants = self::obtainConstants();
                $enum->value = $constants[$name];
            } else {
                throw new InvalidEnumException(static::class . ' - ' . self::class . ' - ' . $name);
            }
        } catch (ReflectionException $e) {
            Log::error($e->getMessage());
        }
        return $enum;
    }

    /**
     * @param string $name
     * @param bool $strict
     * @return bool
     * @throws ReflectionException
     */
    public static function isValidName(string $name, bool $strict = false): bool
    {
        $constants = self::obtainConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map(static function ($item) {

            return mb_strtolower($item);

        }, array_keys($constants));
        return in_array(strtolower($name), $keys, false);
    }


    /**
     * @param string $name
     * @param mixed $args
     * @return static
     * @throws InvalidEnumException
     */
    public static function __callStatic(string $name, $args): self
    {
        if (method_exists(static::class, $name)) {
            return self::$name($args);
        }

        $constantName = strtoupper(Str::snake($name));
        return static::fromName($constantName);
    }
}
