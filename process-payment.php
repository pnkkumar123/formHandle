<?php
// process-payment.php
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$razorpayPaymentId = $_POST['razorpay_payment_id'];
$razorpayOrderId = $_POST['razorpay_order_id'];
$razorpaySignature = $_POST['razorpay_signature'];

$keyId = "rzp_test_Iw8r8nMkJjd1P1";
$keySecret = "haOQ4PfPnb984NXid4ntHwwc";
$api = new Api($keyId, $keySecret);

// Verify the payment signature
$attributes = [
    'razorpay_order_id' => $razorpayOrderId,
    'razorpay_payment_id' => $razorpayPaymentId,
    'razorpay_signature' => $razorpaySignature
];

try {
    $api->utility->verifyPaymentSignature($attributes);

    // Payment signature is valid
    echo "Payment successful!";

    // Update your database, send order confirmation, etc.
} catch (Exception $e) {
    echo "Payment verification failed: " . $e->getMessage();
}
?>
