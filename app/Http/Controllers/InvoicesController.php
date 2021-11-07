<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Contracts\InvoicesServiceInterface;

class InvoicesController extends Controller
{
    public function __invoke(Order $order, InvoicesServiceInterface $invoicesService)
    {
        return $invoicesService->generate($order)->download();
    }
}
