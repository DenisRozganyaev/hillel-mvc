<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Order
     */
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return !is_admin($this->order->user) && !empty($this->order->user->telegram_user_id)
            ? ['mail', 'telegram']
            : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
                    ->line("Dear {$this->order->name} {$this->order->surname},")
                    ->line("Your order #{$this->order->id} status was changed to {$this->order->status->name}")
                    ->line('Have a nice day!');
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($this->order->user->telegram_user_id)
            ->content(
                "Привет, статус твоего заказа №" . $this->order->id . " был измене на. \n" .
                "{$this->order->status->name}"
            )
            ->button('Order details', route('account.orders.show', $this->order));
    }
}