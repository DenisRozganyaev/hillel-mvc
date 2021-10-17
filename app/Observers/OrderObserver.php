<?php

namespace App\Observers;

use App\Jobs\OrderCreatedNotificationJob;
use App\Models\Order;
use App\Models\User;

class OrderObserver
{
    public function created(Order $order)
    {
        logs()->info('start order created');
        OrderCreatedNotificationJob::dispatch($order->user()->first(), $order->id)->onQueue('email')->delay(120);
        logs()->info('get admin');
        $admin = User::where('role_id', '=', 1)->first();
        OrderCreatedNotificationJob::dispatch($admin, $order->id)->onQueue('email')->delay(240);
        logs()->info('observer finish');
    }
}
