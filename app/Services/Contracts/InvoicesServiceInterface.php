<?php
namespace App\Services\Contracts;

use App\Models\Order;

interface InvoicesServiceInterface
{
    public function generate(Order $order);
}
