<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(5);

        return view('account/orders/index', compact('orders'));
    }

    public function show(Order $order)
    {
        $isCancelAllowed = !in_array(
            $order->status->name,
            [
                config('constants.db.order_status.canceled'),
                config('constants.db.order_status.completed'),
            ]
        );

        return view('account/orders/show', compact('order', 'isCancelAllowed'));
    }

    public function cancel(Order $order)
    {
        if ($order->status->name !== config('constants.db.order_status.completed')) {
            $status = OrderStatus::where('name', '=', config('constants.db.order_status.canceled'))->first();

            if ($order->status->name === config('constants.db.order_status.paid')) {
                $order->user->update([
                    'balance' => $order->user->balance + $order->total
                ]);
            }

            $order->update(['status_id' => $status->id]);

            return redirect()->back()->with(['status' => 'Order was canceled!']);
        }

        return redirect()->back()->with(['warn' => 'This order already completed!']);
    }
}
