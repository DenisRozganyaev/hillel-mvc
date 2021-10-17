<?php

namespace App\Services\Contracts;

use App\Models\Product;

interface ProductImagesServiceInterface
{
    public static function attach(Product $product, array $image);
}
