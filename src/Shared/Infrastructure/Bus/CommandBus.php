<?php

namespace Cart\Shared\Infrastructure\Bus;

use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandBusContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;
use Cart\Shared\Domain\Contracts\DependencyContainerContract;
use Cart\Shared\Domain\Exceptions\CommandHandlerNotFound;

final class CommandBus implements CommandBusContract
{
    /** @var array <string> */
    public static array $routes = [];
    private DependencyContainerContract $container;

    /**
     * @param DependencyContainerContract $container
     */
    public function __construct(DependencyContainerContract $container)
    {
       $this->container = $container;
    }


    /**
     * @param CommandContract $command
     * @return string
     */
    public function dispatch(CommandContract $command): string
    {
        $commandClass = get_class($command);
        $commandHandlerName = self::$routes[$commandClass] ?? preg_replace('/Command$/', 'Handler', $commandClass);
        if (null === $commandHandlerName) {
            throw CommandHandlerNotFound::fromMessage('Handler not found for ' . $commandClass);
        }
        /** @var CommandHandlerContract $commandHandler */
        $commandHandler = $this->container->resolve($commandHandlerName);
        return $commandHandler->handle($command);
    }
}
