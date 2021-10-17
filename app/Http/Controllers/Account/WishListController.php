<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function index()
    {
        return view('account/wishlist/index');
    }
}
