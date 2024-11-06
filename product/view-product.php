<?php
session_start();

// Check if the user is logged in 
if(!isset($_SESSION['user_id'])){
    // If the user is not logged in, redirect to the login page
    header("Location:../login.php");
    exit();
}

include '../db.php';
include '../header.php';

$user_id = $_SESSION['user_id'];  // The user_id from the session

// Query to fetch user details including thier role
$sql = "SELECT role FROM users WHERE id = ?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();

// check if the user has the selller role

if($role !== 'seller'){
    // if the user is not a seller,redirect to the home page
    header("Location:../unauthorized.php");
    exit();
}



// Query to fetch products belonging to the logged-in user
$sql = "SELECT * FROM products WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Bind the user_id
$stmt->execute();
$result = $stmt->get_result();  // Get the result set

?>

<?php
include('header.php');
include('navbar.php');
?>
    <div class="container">
        <h2>Products</h2>
        <a href="create-product-display.php" class="btn btn-primary btn-sm">Create Product</a>
 <!-- Logout Button -->
 <form action="../logout.php" method="POST" style="display: inline;">
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>

        <?php if($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><?php echo htmlspecialchars($row['brand']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td>
                        <a href="update-product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No products found</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
