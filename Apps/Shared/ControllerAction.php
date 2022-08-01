<?php

namespace Apps\Shared;

use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandBusContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryBusContract;

class ControllerAction
{
    protected CommandBusContract $commandBus;
    protected QueryBusContract $queryBus;

    /**
     * @param CommandBusContract $commandBus
     * @param QueryBusContract $queryBus
     */
    public function __construct(CommandBusContract $commandBus, QueryBusContract $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }
}
