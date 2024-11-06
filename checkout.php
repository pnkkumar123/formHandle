<?php
sesssion_start();
include 'db.php';

$user_id=$_SESSION['user_id'];

// fetch all cart items for the user
$sql = "SELECT p.name,p.price,c.quantity FROM cart_items c JOIN products p ON c.product_id = p.id
WHERE c.user_id=?
";
$stmt=$conn->prepare($sql);
$stmt->bind_param('i',$user_id);
$stmt->execute();
$result=$stmt->get_result();



?>