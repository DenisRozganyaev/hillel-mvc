<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AwsPublicLinkProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\AwsPublicLinkInterface::class,
            \App\Services\AwsPublicLink::class
        );
    }
}
