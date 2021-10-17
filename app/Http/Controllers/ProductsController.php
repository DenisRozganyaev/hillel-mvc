<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::available()->with('category')->paginate(3);
        return view('products/index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products/show', compact('product'));
    }
}
