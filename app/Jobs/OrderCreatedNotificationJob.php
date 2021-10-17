<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreatedNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $orderId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, int $orderId)
    {
        $this->user = $user;
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new OrderCreatedNotification($this->user, $this->orderId));
    }
}
