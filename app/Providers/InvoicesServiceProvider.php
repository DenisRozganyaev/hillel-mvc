<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\InvoicesServiceInterface::class,
            \App\Services\InvoicesService::class
        );
    }
}
