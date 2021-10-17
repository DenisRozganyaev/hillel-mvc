<?php

namespace App\Mail\Orders\Created;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Admin extends Mailable
{
    use Queueable, SerializesModels;

    protected $orderId, $full_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $orderId, string $user_fn)
    {
        $this->orderId = $orderId;
        $this->full_name = $user_fn;
        logs()->debug(self::class . ' => ' . $orderId . ' => ' . $user_fn);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.order_created.admin')
            ->with(['order_id' => $this->orderId, 'full_name' => $this->full_name]);
    }
}
