<?php
include('db.php');
session_start();

// Make sure the user is logged in by checking the session
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Query to fetch the role of the logged-in user
$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Bind the user_id
$stmt->execute();
$stmt->bind_result($role);  // Bind the role column
$stmt->fetch();

// Check if the user is a seller or consumer and redirect accordingly
if ($role != 'seller') {
    // If the user is a seller, show a message or redirect to seller-related page
    echo "<h1>Login as Seller </h1>";
    // Optionally, redirect to the seller dashboard page
    // header("Location: seller-dashboard.php"); // Uncomment to redirect
} elseif ($role != 'consumer') {
    // If the user is a consumer, show a message or redirect to consumer-related page
    echo "<h1>Login as Consumer </h1>";
    // Optionally, redirect to the consumer dashboard page
    // header("Location: consumer-dashboard.php"); // Uncomment to redirect
} else {
    // If the user role is undefined or invalid, you can show an error message
    echo "<h1>Error: Undefined Role. Please contact support.</h1>";
}

$conn->close(); // Close the database connection
?>
