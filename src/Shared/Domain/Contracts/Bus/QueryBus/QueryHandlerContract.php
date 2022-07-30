<?php

namespace Cart\Shared\Domain\Contracts\Bus\QueryBus;

interface QueryHandlerContract
{
    public static function handle(QueryContract $command);
}
