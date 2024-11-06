<?php
session_start();
include 'db.php';

$cart_id = $_GET['id'];

// delete the product from the cart
$sql = "DELETE FROM cart_items WHERE id=?";
$stmt= $conn->prepare($sql);
$stmt->bind_param('i',$cart_id);
$stmt->execute();

// redirect to cart page
header("Location: cart.php");
exit();


?>