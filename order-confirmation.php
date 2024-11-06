<?php
include('db.php');

$order_id=$_GET['order_id'];
$sql="SELECT * FROM orders WHERE id=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param('i',$order_id);
$stmt->execute();
$order=$stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Order Confirmation</h2>
        <p>Thank you for your purchase! Your order ID is <?php echo htmlspecialchars($order['id']); ?>.</p>
        <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
    </div>
    
</body>
</html>
<?php
$conn->close();

?>