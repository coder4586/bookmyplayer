<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h1>Razorpay Payment Integration</h1>
    <button onclick="makePayment()">Pay Now</button>

    <script>
        function makePayment() {
            $.ajax({
                url: '/create-order',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: 7000 
                },
                success: function(response) {
                    var options = {
                        "key": response.razorpay_key,
                        "amount": 7000,
                        "currency": "INR",
                        "name": "bookmyplayer",
                        "description": "Test Transaction",
                        "order_id": response.order_id,
                        "handler": function (response) {
                            $.ajax({
                                url: '/verify-payment',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_signature: response.razorpay_signature
                                },
                                success: function(result) {
                                    console.log(result.success ? "Payment successful" : "Payment failed");
                                }
                            });
                        },
                    };
                    var rzp = new Razorpay(options);
                    rzp.open();
                }
            });
        }
    </script>
</body>
</html>
