<?php

namespace App\Services;

use App\Models\Product;
use App\Services\Contracts\ProductImagesServiceInterface;

class ProductImagesService implements ProductImagesServiceInterface
{
    public static function attach(Product $product, array $images = [])
    {
        if(!empty($images)) {
            foreach($images as $image) {
                $path = ImageService::upload($image);
                $product->gallery()->create(['path' => $path]);
            }
        }
    }
}
