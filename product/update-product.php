<?php
session_start();
require_once '../db.php';

$message = "";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Check if the user is a seller (assuming the 'role' column exists in the 'users' table)
$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

// If the user is not a seller, redirect to an unauthorized page
if ($role !== 'seller') {
    // Redirect to an unauthorized page or show an error message
    header("Location: unauthorized.php");  // Customize this page as needed
    exit();
}

// Check if the form is submitted for update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // SQL query to update the product with ownership check
    $sql = "UPDATE products SET name=?, description=?, category=?, brand=?, quantity=?, price=? WHERE id=? AND user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiii", $name, $description, $category, $brand, $quantity, $price, $id, $user_id);

    // Execute the statement
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: view-product.php?message=Product updated successfully");
        exit();
    } else {
        $message = "Error: Unable to update product or product not found.";
    }
    $stmt->close();
}

// Fetch the product data with ownership check
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        // If no product is found or the user doesn't own it, redirect or show error
        header("Location: view-product.php?error=Access denied or product not found.");
        exit();
    }

    $stmt->close();
} else {
    header("Location: view-product.php");
    exit();
}

$conn->close();
?>
<?php
include('header.php');
include('navbar.php');
?>


    <h1>Update Product</h1>
    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="update-product.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>

        <label for="description">Description</label>
        <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($product['description']); ?>" required><br><br>

        <label for="category">Category</label>
        <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($product['category']); ?>" required><br><br>

        <label for="brand">Brand</label>
        <input type="text" name="brand" id="brand" value="<?php echo htmlspecialchars($product['brand']); ?>" required><br><br>

        <label for="quantity">Quantity</label>
        <input type="text" name="quantity" id="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required><br><br>

        <label for="price">Price</label>
        <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>

        <input type="submit" name="update" value="Update Product">
    </form>
</body>
</html>
