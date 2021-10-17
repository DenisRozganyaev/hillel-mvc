<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function store(CreateOrderRequest $request, OrderRepositoryInterface $orderRepository)
    {
        try {
            $order = $orderRepository->create($request);

            Cart::instance('cart')->destroy();
            return redirect()->route('home')->with(["status" => "Your order [{$order->id}] was successfully created"]);
        } catch (\Exception $exception) {
            dd($exception->getCode() . ' - ' . $exception->getMessage());
        }
    }
}
