<?php
// Include database connection file
require_once 'db.php';

$message = ""; // Message to display feedback

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $role = trim($_POST["role"]); // Get the role from the form

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user data with role
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "Signup successful!";
        header("Location: login.php");
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Page</title>
</head>
<body>
    <h2>Signup</h2>
    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form action="Details.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <!-- Add a dropdown for selecting the role -->
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="consumer">Consumer</option>
            <option value="seller">Seller</option>
        </select><br><br>

        <button type="submit">Signup</button>
    </form>
</body>
</html>
