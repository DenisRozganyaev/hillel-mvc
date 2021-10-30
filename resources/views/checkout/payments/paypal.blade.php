<!-- Set up a container element for the button -->
<div id="paypal-button-container"></div>

<!-- Include the PayPal JavaScript SDK -->
<script
    src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.' . env('PAYPAL_MODE') . '.client_id') }}&currency=USD"
></script>
<script src="{{ asset('js/paypal-payments.js') }}" type="text/javascript"></script>
