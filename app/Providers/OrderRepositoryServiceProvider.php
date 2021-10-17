<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OrderRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Contracts\OrderRepositoryInterface::class,
            \App\Repositories\OrderRepository::class
        );
    }
}
