<?php

namespace Cart\Shared\Domain\Contracts\Bus\QueryBus;


interface QueryBusContract
{
    public static function dispatch(QueryContract $query);
}
