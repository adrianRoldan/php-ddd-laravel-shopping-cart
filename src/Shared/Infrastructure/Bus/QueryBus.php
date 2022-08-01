<?php

namespace Cart\Shared\Infrastructure\Bus;

use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryBusContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryHandlerContract;
use Cart\Shared\Domain\Contracts\DependencyContainerContract;
use Cart\Shared\Domain\Exceptions\QueryHandlerNotFound;

class QueryBus implements QueryBusContract
{
    private DependencyContainerContract $container;

    public function __construct(DependencyContainerContract $container)
    {
        $this->container = $container;
    }


    /**
     * Simple implementation of a query bus that automatically matches a query with its handler via name
     * Ex: FindProductByIdQuery matches with FindProductByIdHandler
     *
     * @param QueryContract $query
     * @return mixed
     */
    public function dispatch(QueryContract $query): mixed
    {
        $queryClass = get_class($query);
        $queryHandlerName = preg_replace('/Query$/', 'Handler', $queryClass);

        if (null === $queryHandlerName || !class_exists($queryHandlerName)) {
            throw QueryHandlerNotFound::fromQueryClass($queryClass);
        }

        /** @var QueryHandlerContract $queryHandler */
        $queryHandler = $this->container->resolve($queryHandlerName);
        return $queryHandler->handle($query);
    }
}
