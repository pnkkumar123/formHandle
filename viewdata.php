<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

include 'db.php';
include 'header.php';

// Query to fetch all users
$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);
?>

<!-- Rest of your viewdata.php HTML and PHP code to display users -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Users</title>
</head>
<body>
    <div class="container">
        <h2>User Details</h2>
        <a href="Details.php" class="btn btn-primary btn-sm">Create User</a>
        <a href="logout.php" class="btn btn-secondary btn-sm" style="float: right;">Logout</a> <!-- Logout button -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
