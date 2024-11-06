<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

include('db.php');

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

// Setting variables to empty
$name = $description = $category = $price = $quantity = $brand = "";
$name_error = $description_error = $quantity_error = $price_error = $brand_error = $category_error = "";

// Common function to handle errors
function err($val) {
    echo $val . " is required ";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    if (empty($_POST["name"])) {
        $name_error = err("name");
    } else {
        $name = test_input($_POST["name"]);
    }
    if (empty($_POST["description"])) {
        $description_error = err("description");
    } else {
        $description = test_input($_POST["description"]);
    }
    if (empty($_POST["category"])) {
        $category_error = err("category");
    } else {
        $category = test_input($_POST["category"]);
    }
    if (empty($_POST["price"])) {
        $price_error = err("price");
    } else {
        $price = test_input($_POST["price"]);
    }
    if (empty($_POST["brand"])) {
        $brand_error = err("brand");
    } else {
        $brand = test_input($_POST["brand"]);
    }
    if (empty($_POST["quantity"])) {
        $quantity_error = err("quantity");
    } else {
        $quantity = test_input($_POST["quantity"]);
    }

    // If there are errors, store them in session and redirect back to the form page
    if ($name_error || $description_error || $quantity_error || $price_error || $brand_error || $category_error) {
        $_SESSION['name_error'] = $name_error;
        $_SESSION['description_error'] = $description_error;
        $_SESSION['quantity_error'] = $quantity_error;
        $_SESSION['price_error'] = $price_error;
        $_SESSION['brand_error'] = $brand_error;
        $_SESSION['category_error'] = $category_error;
        
        // Redirect to form page
        header("Location: create-product-display.php");
        exit();
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO products (name, description, category, brand, quantity, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $description, $category, $brand, $quantity, $price);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "New product created successfully";
        header("Location: view-product.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
