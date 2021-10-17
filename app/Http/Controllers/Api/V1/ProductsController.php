<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::available()
            ->with('category')
            ->get(['id', 'category_id', 'title', 'price', 'short_description', 'discount', 'thumbnail']);

        $products = $products->each(function(Product $product) {
            $product->thumbnail = url($product->thumbnail);
        });

        return response()->json(['products' => $products]);
    }

    public function show(Product $product)
    {
        $product->thumbnail = url($product->thumbnail);

        return response()->json(['product' => $product]);
    }
}
