<?php
session_start();

// check if the user is logged in 

if(!isset($_SESSION['user_id'])){
    // if the user is not logged in ,redirect to the loggin page
    header("Location:../login.php");
    exit();
}
include '../db.php';

if(isset($_GET['id'])){
    $id=$_GET['id'];

    // prepare and execute delete query
    $sql="DELETE FROM products WHERE id=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$id);

    if($stmt->execute()){
        header("Location: view-product.php ");
        exit();
    }else{
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}else{
    header("Location: update-product.php");
    exit();
}

?>