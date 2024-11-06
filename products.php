<?php
include 'db.php';

// Query to fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Products</h2>
        
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <!-- You can add an image here later -->
                            <img src="path-to-image.jpg" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                                <p><strong>Brand:</strong> <?php echo htmlspecialchars($row['brand']); ?></p>
                                <p><strong>Quantity Available:</strong> <?php echo htmlspecialchars($row['quantity']); ?></p>
                                <p><strong>Price:</strong> $<?php echo htmlspecialchars($row['price']); ?></p>
                                
                                <!-- Add to Cart Form with Quantity Input -->
                                <form action="add-to-cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-2">
                                        <label for="quantity-<?php echo $row['id']; ?>" class="form-label">Quantity:</label>
                                        <input type="number" id="quantity-<?php echo $row['id']; ?>" name="quantity" class="form-control" value="1" min="1" max="<?php echo htmlspecialchars($row['quantity']); ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
