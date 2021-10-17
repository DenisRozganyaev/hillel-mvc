<?php

namespace App\Observers;

use App\Models\Product;
use App\Notifications\ProductUpdateNotification;
use App\Services\ImageService;

class ProductObserver
{

    /**
     * Handle the Product "updated" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        if ($product->getOriginal('in_stock') <= 0 && $product->in_stock > $product->getOriginal('in_stock')) {
            $product->followers()
                ->get()
                ->each
                ->notify(new ProductUpdateNotification($product));
        }
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        ImageService::remove($product->thumbnail);
    }
}
