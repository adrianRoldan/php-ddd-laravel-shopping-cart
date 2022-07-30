<?php

namespace Cart\Shared\Infrastructure;

use Cart\Shared\Domain\Contracts\DependencyContainerContract;
use Illuminate\Support\Facades\App;

class LaravelDependencyContainer implements DependencyContainerContract
{

    public function resolve(string $class): mixed
    {
        return App::make($class);
    }
}
