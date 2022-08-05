<?php

namespace Cart\Shared\Domain\Exceptions;

use Cart\Shared\Domain\Contracts\DomainExceptionContract;
use DomainException;
use Throwable;

abstract class BaseDomainException extends DomainException implements DomainExceptionContract
{
    /** @var int $code */
    protected $code;

    final function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromMessage(string $message): static
    {
        return new static($message);
    }
}
