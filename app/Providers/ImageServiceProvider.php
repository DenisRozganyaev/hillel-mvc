<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
          \App\Services\Contracts\ImageServiceInterface::class,
          \App\Services\ImageService::class
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
