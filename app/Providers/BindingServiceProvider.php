<?php

namespace App\Providers;

use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandBusContract;
use Cart\Shared\Domain\Contracts\DependencyContainerContract;
use Cart\Shared\Infrastructure\Bus\CommandBus;
use Cart\Shared\Infrastructure\LaravelDependencyContainer;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Repositories

        // Bus
        $this->app->bind(CommandBusContract::class, CommandBus::class);

        // Service Providers
        $this->app->bind(DependencyContainerContract::class, LaravelDependencyContainer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
