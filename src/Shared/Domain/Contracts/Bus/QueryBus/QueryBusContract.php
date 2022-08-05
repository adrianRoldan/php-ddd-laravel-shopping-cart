<?php

namespace Cart\Shared\Domain\Contracts\Bus\QueryBus;


interface QueryBusContract
{
    public function dispatch(QueryContract $query): mixed;
}
