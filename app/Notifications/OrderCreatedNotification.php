<?php

namespace App\Notifications;

use App\Mail\Orders\Created\Admin;
use App\Mail\Orders\Created\Customer;
use App\Models\Order;
use App\Services\AwsPublicLink;
use App\Services\InvoicesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
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
        return !empty($this->user->telegram_user_id)
            ? ['telegram', 'mail']
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
        logs()->info('INIT::toTelegram');
        $service = new InvoicesService();
        $pdf = $service->generate(Order::find($this->orderId))->save('s3');
        $fileLink = AwsPublicLink::generate($pdf->filename);

        $test = TelegramFile::create()
            ->to($this->user->telegram_user_id)
            ->content(
                "Привет, твой заказ № '$this->orderId' оформлен. \n" .
                "И находиться в статус 'In Process'. \n" .
                "Детальней о заказе на странице заказа в аккаунте."
            )
            ->options(['parse_mode' => ''])
            ->document($fileLink, $pdf->filename)
            ->button('Order details', route('account.orders.show', $this->orderId));
        logs()->info($test->jsonSerialize());
        logs()->info('END::toTelegram');
        return $test;
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
