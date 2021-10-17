<?php

namespace App\Services\Contracts;

use App\Models\Product;

interface WishListServiceContract
{
    public function isUserFollowed(Product $product);
}
