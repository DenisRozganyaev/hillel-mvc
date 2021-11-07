<?php
namespace App\Services;

use App\Models\Order;
use App\Services\Contracts\InvoicesServiceInterface;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Facades\Invoice as InvoiceFacade;
use LaravelDaily\Invoices\Invoice;

class InvoicesService implements InvoicesServiceInterface
{

    /**
     * @param Order $order
     * @param InvoicesServiceInterface $invoicesService
     */
    public function generate(Order $order): Invoice
    {
        $customer = new Buyer([
            'name'          => $order->name . ' ' . $order->surname,
            'custom_fields' => [
                'email' => $order->email,
                'phone' => $order->phone,
                'country' => $order->country,
                'city' => $order->city,
                'address' => $order->address,
            ],
        ]);

        $items = [];

        foreach ($order->products()->get() as $product) {
            $items[] = (new InvoiceItem())
                ->title($product->title)
                ->pricePerUnit($product->pivot->single_price)
                ->quantity($product->pivot->quantity)
                ->units('шт');
        }

        $invoice = InvoiceFacade::make()
            ->status($order->status->name)
            ->serialNumberFormat($order->id)
            ->buyer($customer)
            ->taxRate(config('cart.tax'))
            ->filename('Invoice_' . time() . '_' . $order->user->id . '_' . $order->id)
            ->logo('https://xl-static.rozetka.com.ua/assets/img/design/logo_n.svg')
            ->addItems($items);

        if ($order->status->name === config('constants.db.order_status.in_process')) {
            $invoice->payUntilDays(3);
        }

        return $invoice;
    }
}
