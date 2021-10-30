<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\Transaction;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalPaymentController extends Controller
{

    protected $paypalClient;

    public function __construct()
    {
        $this->paypalClient = new PayPalClient();
        $this->paypalClient->setApiCredentials(config('paypal'));
        $token = $this->paypalClient->getAccessToken();
        $this->paypalClient->setAccessToken($token);
    }

    public function create(CreateOrderRequest $request, OrderRepositoryInterface $orderRepository)
    {
        $total = Cart::instance('cart')->total(2, '.', '');

        $paypalOrder = $this->paypalClient->createOrder([
           'intent' => 'CAPTURE',
           'purchase_units' => [
               [
                   'amount' => [
                       'currency_code' => 'USD',
                       'value' => $total
                   ]
               ]
           ]
        ]);
        $request = $request->validated();
        $request['vendor_order_id'] = $paypalOrder['id'];

        $order = $orderRepository->create($request);

        return response()->json($order);
    }

    public function capture(string $orderId, OrderRepositoryInterface $orderRepository)
    {
        DB::beginTransaction();
        try {
            $result = $this->paypalClient->capturePaymentOrder($orderId);

            if($result['status'] === 'COMPLETED') {
                $transaction = new Transaction;
                $transaction->vendor_order_id = $result['id'];
                $transaction->payment_system = 'PAYPAL';
                $transaction->user_id = auth()->user()->id;
                $transaction->status = $result['status'];
                $transaction->save();

                $orderRepository->setTransaction($result['id'], $transaction);
            }
            DB::commit();

            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function thankYou(string $orderId)
    {
        Cart::instance('cart')->destroy();

        $order = Order::with(['user', 'transaction', 'products'])->where('vendor_order_id', $orderId)->first();

        return view('thankyou/summary', compact('order'));
    }
}
