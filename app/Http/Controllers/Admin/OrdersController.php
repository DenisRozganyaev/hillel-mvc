<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'status'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin/orders/index', compact('orders'));
    }

    public function edit(Order $order)
    {
        $statuses = OrderStatus::all();
        $products = $order->products()->get();
        return view('admin/orders/edit', compact('order', 'products', 'statuses'));
    }
}
