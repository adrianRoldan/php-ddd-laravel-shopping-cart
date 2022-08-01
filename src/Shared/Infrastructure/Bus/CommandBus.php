<?php

namespace Cart\Shared\Infrastructure\Bus;

use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandBusContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;
use Cart\Shared\Domain\Contracts\DependencyContainerContract;
use Cart\Shared\Domain\Exceptions\CommandHandlerNotFound;

final class CommandBus implements CommandBusContract
{
    private DependencyContainerContract $container;

    /**
     * @param DependencyContainerContract $container
     */
    public function __construct(DependencyContainerContract $container)
    {
       $this->container = $container;
    }


    /**
     * Simple implementation of a command bus that automatically matches a command with its handler via name
     * Ex: AddProductToCartCommand matches with AddProductToCartHandler
     *
     * @param CommandContract $command
     * @return void
     */
    public function dispatch(CommandContract $command): void
    {
        $commandClass = get_class($command);
        $commandHandlerName = preg_replace('/Command$/', 'Handler', $commandClass);

        if (null === $commandHandlerName || !class_exists($commandHandlerName)) {
            throw CommandHandlerNotFound::fromCommandClass($commandClass);
        }
        /** @var CommandHandlerContract $commandHandler */
        $commandHandler = $this->container->resolve($commandHandlerName);
        $commandHandler->handle($command);
    }
}
