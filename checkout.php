<?php
session_start();
include 'db.php';

$user_id=$_SESSION['user_id'];

// fetch all cart items for the user
$sql = "SELECT p.name,p.price,c.quantity FROM cart_items c JOIN products p ON c.product_id = p.id
WHERE c.user_id=?
";
$stmt=$conn->prepare($sql);
$stmt->bind_param('i',$user_id);
$stmt->execute();
$result=$stmt->get_result();

// calculate total price
$amount = 0;
$cart_items=[];
while ($row = $result->fetch_assoc()){
    $cart_items[]=$row;
    $amount += $row['price'] * $row['quantity'];

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
   <div class="container mt-4">
    <h2>Checkout</h2>
     
    <h4>Your Order</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>

                    <td>$<?php echo  htmlspecialchars($item['price']); ?></td>

                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo   htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>$<?php echo  $amount; ?></strong></td>
                </tr>
        </tbody>

    </table>
    <!-- Shipping and Payment Form -->
     <!-- Shipping and Payment Form -->
     <form action="process-checkout.php" method="POST">
    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
    
    <div class="mb-3">
        <label for="shipping_address" class="form-label">Shipping Address</label>
        <textarea name="shipping_address" id="shipping_address" class="form-control" required></textarea>
    </div>
    
    <div class="mb-3">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select name="payment_method" id="payment_method" class="form-select" required>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Place Order</button>
</form>


   </div>    
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php
$conn->close();
?>