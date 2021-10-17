<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Observers\OrderObserver;
use App\Observers\ProductImageObserver;
use App\Observers\ProductObserver;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        ProductImage::observe(ProductImageObserver::class);
        Product::observe(ProductObserver::class);
        Order::observe(OrderObserver::class);
    }
}
