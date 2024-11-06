<?php
session_start();
require('vendor/razorpay/razorpay/Razorpay.php');  // path to the Razorpay PHP SDK
use Razorpay\Api\Api;

// Set up Razorpay API credentials
$keyId = "rzp_test_Iw8r8nMkJjd1P1";
$keySecret = "haOQ4PfPnb984NXid4ntHwwc";

// Fetch order amount from the frontend form submission
$amount = isset($_POST['amount']) ? $_POST['amount'] : null;

if ($amount === null || $amount <= 0) {
    echo json_encode(['error' => 'Invalid amount', 'success' => false]);
    exit;
}

// Backend logic: Razorpay order creation
$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt'         => 'order_rcptid_11',
    'amount'          => $amount * 100,  // Amount in paise
    'currency'        => 'INR',
    'payment_capture' => 1  // 1 for automatic capture, 0 for manual capture
];

try {
    // Create the Razorpay order
    $order = $api->order->create($orderData);
    $orderId = $order['id']; // Get the order ID

    // Return the order ID and success status to the frontend
    $orderCreated = true;
} catch (Exception $e) {
    // Return error message if order creation fails
    $orderCreated = false;
    $errorMessage = $e->getMessage();
}
?>

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

    <?php if ($orderCreated): ?>
        <!-- Show order ID and countdown to redirection -->
        <div id="order-details">
            <h3>Order Created Successfully!</h3>
            <p>Order ID: <span id="order-id"><?php echo $orderId; ?></span></p>
            <p>Redirecting to products page in <span id="countdown">5</span> seconds...</p>
        </div>

        <script>
            // Countdown timer for redirection
            let countdown = 5;
            const countdownElement = document.getElementById('countdown');
            const interval = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown === 0) {
                    clearInterval(interval);
                    window.location.href = "products.php";  // Redirect to products page
                }
            }, 1000);
        </script>
    <?php else: ?>
        <!-- Error message if order creation fails -->
        <p>Error creating order: <?php echo isset($errorMessage) ? $errorMessage : 'Unknown error'; ?></p>
    <?php endif; ?>
</body>
</html>

