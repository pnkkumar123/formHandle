<?php
session_start();
include 'db.php';
include 'header.php';

// Query to fetch all users
$sql = "SELECT id, name, username, password, email, mobile FROM users"; // Ensure you include `id`
$result = $conn->query($sql);
?>

<body>
    <div class="container">
        <h2 class="container">User Details</h2>
      <a href="Details.php" class="btn btn-primary btn-sm">Create User</a>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Actions</th> <!-- Added a header for actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display each row of data
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <!-- Delete Button -->
                            <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-warning">No records found</p>
        <?php endif; ?>
    </div>

<?php
$conn->close();
include 'footer.php';
?>
