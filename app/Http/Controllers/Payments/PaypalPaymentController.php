<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
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

    public function capture(Request $request, string $orderId)
    {
        DB::beginTransaction();
        try {
            $result = $this->paypalClient->capturePaymentOrder($orderId);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        dd($result);
    }
}
