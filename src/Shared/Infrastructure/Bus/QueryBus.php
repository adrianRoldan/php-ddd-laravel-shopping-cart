<?php

namespace Cart\Shared\Infrastructure\Bus;

use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryBusContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryHandlerContract;
use Cart\Shared\Domain\Contracts\DependencyContainerContract;

class QueryBus implements QueryBusContract
{
    private static DependencyContainerContract $container;

    public function __construct(DependencyContainerContract $container)
    {
        self::$container = $container;
    }


    public static function dispatch(QueryContract $query)
    {
        $key = get_class($query);
        $queryHandlerName = preg_replace('/Query$/', 'Handler', $key);
        /** @var QueryHandlerContract $queryHandler */
        $queryHandler = self::$container->resolve($queryHandlerName);
        return $queryHandler->handle($query);
    }
}
