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
    public function create(Request $request): Order
    {
        $result = DB::transaction(function () use ($request) {
            $total = Cart::instance('cart')->total(2, '.', '');
            $user = auth()->user();

            if ($user->balance < $total) {
                throw new \Exception('Not enough money', 200);
            }

            $status = OrderStatus::where('name', '=', Config::get('constants.db.order_status.in_process'))->first();
            $orderData = $request->validated();

            $orderData['status_id'] = $status->id;
            $orderData['total'] = $total;

            $order = $user->orders()->create($orderData);

            $this->addProductsToOrder($order);

            $userData = [
                'balance' => $user->balance - $total
            ];

            if (!$user->update($userData)) {
                throw new \Exception("Something wrong with user updating process", 200);
            }

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
