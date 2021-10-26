<!-- Set up a container element for the button -->
<div id="paypal-button-container"></div>

<!-- Include the PayPal JavaScript SDK -->
<script
    src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.' . env('PAYPAL_MODE') . '.client_id') }}&currency=USD"
></script>

<script>
    // Render the PayPal button into #paypal-button-container
    var errorsExists = false;
    var fields = {};

    function getFields() {
        return $('#order-form').serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
    }

    function isEmptyFields() {
        const fields = getFields();

        for (const [key, value] of Object.entries(fields)) {
            if (value.length < 1) {
                return true;
            }
        }
        return false;
    }

    paypal.Buttons({
        // onClick: function () {
        //     if (isEmptyFields()) {
        //     }
        // },
        // Call your server to set up the transaction
        createOrder: function (data, actions) {
            errorsExists = false;

            const fields = getFields();
            //
            // const errorClass = 'is-invalid';
            // let errorTemplate = `<span class="invalid-feedback" role="alert">
            //                         <strong>The ___ field is required.</strong>
            //                     </span>`;
            //
            // $('.invalid-feedback').remove();

            // for (const [key, value] of Object.entries(fields)) {
            //     let $input = $(`input[name="${key}"]`);
            //     $input.removeClass(errorClass);
            //     if (value.length < 1) {
            //         $input.addClass(errorClass);
            //         $input.after(errorTemplate.replace('___', key));
            //         errorsExists = true;
            //     }
            // }

            return fetch('/paypal/order/create/', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(fields)
            }).then(function(res) {
                return res.json();
            }).then(function(orderData) {
                return orderData.vendor_order_id;
            });
        },

        // Call your server to finalize the transaction
        onApprove: function (data, actions) {
            console.log(data);
            if (!errorsExists) {
                return fetch('/paypal/order/' + data.orderID + '/capture/', {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    }
                }).then(function (res) {
                    return res.json();
                }).then(function (orderData) {
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you

                    // This example reads a v2/checkout/orders capture response, propagated from the server
                    // You could use a different API or structure for your 'orderData'
                    var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        return actions.restart(); // Recoverable state, per:
                        // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                    }

                    if (errorDetail) {
                        var msg = 'Sorry, your transaction could not be processed.';
                        if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                        if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                        return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                    }

                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    // Replace the above to show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }
        }

    }).render('#paypal-button-container');
</script>
