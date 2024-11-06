<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h2>Checkout</h2>
    <form id="checkout-form">
        <label for="amount">Enter Amount:</label>
        <input type="number" name="amount" id="amount" required>

        <button type="submit">Proceed to Pay</button>
    </form>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const amount = document.getElementById('amount').value;

            // Prepare form data to send to PHP backend
            const formData = new FormData();
            formData.append('amount', amount);

            fetch('process-checkout.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Initialize Razorpay payment options
                    const options = {
                        "key": "rzp_test_Iw8r8nMkJjd1P1",  // Your API Key ID
                        "amount": amount * 100,  // Amount in paise
                        "currency": "INR",
                        "name": "Your Store Name",
                        "description": "Purchase",
                        "order_id": data.order_id,
                        "handler": function (response) {
                            alert("Payment Successful!");
                            window.location.href = "products.php";  // Redirect after successful payment
                        },
                        "prefill": {
                            "name": "Your Customer Name",
                            "email": "customer@example.com",
                            "contact": "1234567890"
                        },
                        "theme": {
                            "color": "#3399cc"
                        }
                    };

                    const rzp = new Razorpay(options);
                    rzp.open();
                } else {
                    alert('Error creating order: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
