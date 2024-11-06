<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Assume the user is logged in and user_id is stored in session

// Fetch all cart items for the user
$sql = "SELECT p.name, p.price, c.quantity, c.id AS cart_id FROM cart_items c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error); // Error handling for prepare statement
}

$stmt->bind_param('i', $user_id);

if (!$stmt->execute()) {
    die("Execution Error: " . $stmt->error); // Error handling for execute
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Your Cart</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>$<?php echo number_format((float)$row['price'], 2); ?></td>
                            <td><?php echo (int)$row['quantity']; ?></td>
                            <td>$<?php echo number_format((float)$row['price'] * (int)$row['quantity'], 2); ?></td>
                            <td>
                                <!-- Update or Remove Product -->
                                <a href="remove-from-cart.php?id=<?php echo $row['cart_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
