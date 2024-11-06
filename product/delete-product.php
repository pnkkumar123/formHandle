<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: ../login.php");
    exit();
}

include '../db.php';

// Check if the user is a seller (assuming the 'role' column exists in the 'users' table)
$user_id = $_SESSION['user_id'];
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

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute delete query
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: view-product.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    // If 'id' is not passed, redirect to update-product.php
    header("Location: update-product.php");
    exit();
}
?>
