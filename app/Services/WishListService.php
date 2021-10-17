<?php

namespace App\Services;

use App\Models\Product;
use App\Services\Contracts\WishListServiceContract;

class WishListService implements WishListServiceContract
{

    public function isUserFollowed(Product $product)
    {
        $followers = $product->followers()->get()->pluck('id');

        return $followers->contains(auth()->id());
    }
}
