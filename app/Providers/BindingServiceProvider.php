<?php

namespace App\Providers;

use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Core\Cart\Domain\Services\CurrencyExchangeProviderContract;
use Cart\Core\Cart\Infrastructure\Repositories\EloquentCartRepository;
use Cart\Core\Cart\Infrastructure\Services\EuropeanCentralBankCurrencyExchanger;
use Cart\Core\Product\Domain\Repositories\ProductRepositoryContract;
use Cart\Core\Product\Infrastructure\Repositories\EloquentProductRepository;
use Cart\Shared\Domain\Contracts\ApiXmlProviderContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandBusContract;
use Cart\Shared\Domain\Contracts\Bus\EventBus\EventBusContract;
use Cart\Shared\Domain\Contracts\Bus\EventBus\EventDispatcherContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryBusContract;
use Cart\Shared\Domain\Contracts\DependencyContainerContract;
use Cart\Shared\Domain\Contracts\Repositories\DomainEventRepositoryContract;
use Cart\Shared\Infrastructure\Bus\CommandBus;
use Cart\Shared\Infrastructure\Bus\EventBus;
use Cart\Shared\Infrastructure\Bus\QueryBus;
use Cart\Shared\Infrastructure\Repositories\EloquentEventStore;
use Cart\Shared\Infrastructure\Services\LaravelDependencyContainer;
use Cart\Shared\Infrastructure\Services\LaravelEventDispatcher;
use Cart\Shared\Infrastructure\Services\SimpleXmlProvider;
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
        $this->app->bind(DomainEventRepositoryContract::class, EloquentEventStore::class);
        $this->app->bind(CartRepositoryContract::class, EloquentCartRepository::class);
        $this->app->bind(ProductRepositoryContract::class, EloquentProductRepository::class);

        // Bus
        $this->app->bind(CommandBusContract::class, CommandBus::class);
        $this->app->bind(QueryBusContract::class, QueryBus::class);
        $this->app->bind(EventBusContract::class, EventBus::class);

        // Service Providers
        $this->app->bind(DependencyContainerContract::class, LaravelDependencyContainer::class);
        $this->app->bind(EventDispatcherContract::class, LaravelEventDispatcher::class);
        $this->app->bind(CurrencyExchangeProviderContract::class, EuropeanCentralBankCurrencyExchanger::class);
        $this->app->bind(ApiXmlProviderContract::class, SimpleXmlProvider::class);
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
