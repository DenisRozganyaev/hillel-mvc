<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WishListProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\WishListServiceContract::class,
            \App\Services\WishListService::class
        );
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
