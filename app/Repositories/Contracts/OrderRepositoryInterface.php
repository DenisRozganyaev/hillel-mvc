<?php
namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

interface OrderRepositoryInterface
{
    public function create(array $request): Order;

    public function setTransaction(string $transaction_order_id, Transaction $transaction);
}
