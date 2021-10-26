<?php
namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Http\Request;

interface OrderRepositoryInterface
{
    public function create(array $request): Order;
}
