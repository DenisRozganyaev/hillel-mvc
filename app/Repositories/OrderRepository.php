<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $request): Order
    {
        $result = DB::transaction(function () use ($request) {
            $total = Cart::instance('cart')->total(2, '.', '');
            $user = auth()->user();

            $status = OrderStatus::where('name', '=', Config::get('constants.db.order_status.in_process'))->first();

            $request['status_id'] = $status->id;
            $request['total'] = $total;

            $order = $user->orders()->create($request);

            $this->addProductsToOrder($order);

            return $order;
        });

        return $result;
    }

    private function addProductsToOrder(Order $order)
    {
        Cart::instance('cart')->content()->groupBy('id')->each(function ($item) use ($order) {
            $product = $item[0];
            $order->products()->attach(
                $product->model,
                [
                    'quantity' => $product->qty,
                    'single_price' => $product->model->getPrice()
                ]
            );
            $in_stock = $product->model->in_stock - $product->qty;

            if (!$product->model->update(['in_stock' => $in_stock])) {
                throw new \Exception("Something wrong with product id={$product->id} updating process", 200);
            }
        });
    }
}
