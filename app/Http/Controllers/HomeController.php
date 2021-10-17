<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all()->take(5);
        $products = Product::all()->take(5);

        // ['categories' => $categories, 'products' => $products]
        return view('home', compact('categories', 'products'));
    }
}
