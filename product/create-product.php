<?php
session_start();

// check if the user is logged in
if(!isset($_SESSION['user_id'])){
    // if the user is not logged in ,redirect to login page 
    header("Location:login.php");
    exit();
}

include('db.php');
// setting variables to empty
$name=$description=$category=$price=$quantity=$brand="";
$name_error=$description_error=$quantity_error=$price_error=$brand_error=$category_error="";

// common function to handle error
function err($val){
    echo $val . " is required ";
}
function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return  $data;
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty($_POST["name"])){
        $name_error=err("name");
    }
    else{
        $name=test_input($_POST["name"]);
    }
    if(empty($_POST["description"])){
        $description_error=err("description");
    }
    else{
        $description=test_input($_POST["description"]);

    }
    if(empty($_POST["category"])){
        $category_error=err("category");
    }else{
        $category=test_input($_POST["category"]);
    }
    if(empty($_POST["price"])){
        $price_error=err("price");
    }
    else{
        $price=test_input($_POST["price"]);
    }
    if(empty($_POST["brand"])){
        $brand_error=err("brand");
    }else{
        $brand=test_input($_POST["brand"]);
    }
    if(empty($_POST["quantity"])){
        $quantity_error=err("quantity");
    }else{
        $quantity=test_input($_POST["quantity"]);
    }
    // if there are arrays store them in session
    if($name_error||$description_error||$quantity_error||$price_error||$brand_error||$category_error){
        $_SESSION['name_error']=$name_error;
        $_SESSION['description_error']=$description_error;
        $_SESSION['quantity_error']=$quantity_error;
        $_SESSION['price_error']=$price_error;
        $_SESSION['brand_error']=$brand_error;
        $_SESSION['category_error']=$category_error;
  
        //  redirect to form page
        header("Location:create-product-display.php");
        exit();

    }
    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO products (name,description,category,brand,quantity,price) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",$name,$description,$category,$brand,$quantity,$price);

    if($stmt->execute()){
        echo "New Product created Successfully";
        header("Location: view-product.php");
    }else{
        echo "Error : " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}



?>