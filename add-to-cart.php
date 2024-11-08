<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the user is a consumer (assuming a 'role' column exists in the 'users' table)
$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if ($role !== 'consumer') {
    // Redirect if the user is not a consumer
    header("Location: unauthorized.php"); // Customize this page as needed
    exit();
}

// Check if `product_id` and `quantity` are set in the POST request
if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    die("Product or quantity not specified.");
}

$product_id = (int)$_POST['product_id'];
$quantity = (int)$_POST['quantity'];

// Validate inputs
if ($product_id <= 0 || $quantity <= 0) {
    die("Invalid product or quantity.");
}

// Check if the product exists in the database
$sql = "SELECT id FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Product not found.");
}

$stmt->close();

// Start transaction
$conn->begin_transaction();

try {
    // Check if the product is already in the cart
    $sql = "SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If product already in cart, update quantity
        $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii', $quantity, $user_id, $product_id);
        $stmt->execute();
    } else {
        // If product is not in the cart, add it
        $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii', $user_id, $product_id, $quantity);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    // Redirect to cart page
    header("Location: cart.php");
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    die("Error: " . $e->getMessage());
} finally {
    // Close statement
    if ($stmt) {
        $stmt->close();
    }
    // Close connection if applicable
    $conn->close();
}
?>
