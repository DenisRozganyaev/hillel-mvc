<?php

namespace App\Notifications;

use App\Mail\Orders\Created\Admin;
use App\Mail\Orders\Created\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $user, $orderId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, int $orderId)
    {
        $this->user = $user;
        $this->orderId = $orderId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return !is_admin($this->user) && !empty($this->user->telegram_user_id)
            ? ['mail', 'telegram']
            : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toMail($notifiable)
    {
        return is_admin($this->user)
            ? new Admin($this->orderId, $this->user->full_name)
            : new Customer($this->orderId, $this->user->full_name);
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($this->user->telegram_user_id)
            ->content(
                "Привет, твой заказ № '$this->orderId' оформлен. \n" .
                "И находиться в статус 'In Process'. \n" .
                "Детальней о заказе на странице заказа в аккаунте."
            )
            ->button('Order details', route('account.orders.show', $this->orderId));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
