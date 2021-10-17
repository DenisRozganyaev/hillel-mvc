<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class WishListController extends Controller
{

    public function add(Product $product)
    {
        auth()->user()->addToWish($product);

        $cartItem = Cart::instance('wishlist')->add(
          $product->id,
          $product->title,
          1,
          $product->getPrice()
        );
        $cartItem->associate($product);

        return redirect()->back()->with(["status" => "The product '{$product->title}' was added to wish list!"]);
    }

    public function delete(Request $request, Product $product)
    {
        auth()->user()->removeFromWish($product);

        if (!empty($request->rowId)) {
           Cart::instance('wishlist')->remove($request->rowId);
        } else {
            $content = Cart::instance('wishlist')->content();

            foreach ($content as $item) {
                if ($item->id === $product->id) {
                    Cart::instance('wishlist')->remove($item->rowId);
                }
            }
        }

        return redirect()->back()->with(["status" => "The product '{$product->title}' was removed from wish list!"]);
    }
}
