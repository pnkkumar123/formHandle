<?php
session_start();
include('db.php'); // Ensure your database connection file is included
include('header.php'); // Include header for layout

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (!empty($email) && !empty($password)) {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = $email");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                // Redirect to a protected page
                header('Location: viewdata.php');
                exit();
            } else {
                echo "<div class='alert alert-warning'>Invalid Password.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>User Not Found.</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-warning'>Please fill in all fields.</div>";
    }
}
?>
