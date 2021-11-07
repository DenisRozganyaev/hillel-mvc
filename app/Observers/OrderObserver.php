<?php

namespace App\Observers;

use App\Jobs\OrderCreatedNotificationJob;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStatusChangedNotification;

class OrderObserver
{
    public function created(Order $order)
    {
        OrderCreatedNotificationJob::dispatch($order->user()->first(), $order)->onQueue('email');
        $admin = User::where('role_id', '=', 1)->first();
        OrderCreatedNotificationJob::dispatch($admin, $order)->onQueue('email'); //->delay(60);
    }

    public function updated(Order $order)
    {
        if ($order->status_id != $order->getOriginal('status_id'))
        {
            $order->notify(
                (new OrderStatusChangedNotification($order))->onQueue('email')
            );
        }
    }
}
