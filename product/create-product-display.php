<?php
// include db connection file
require_once '../db.php';
$message="";
include('../header.php');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    // get form data
    $name=trim($_POST["name"]);
    $description=trim($_POST["description"]);
    $quantity=trim($_POST["quantity"]);
    $category=trim($_POST["category"]);
    $price=trim($_POST["price"]);
    $brand=trim($_POST["brand"]);

    // prepare sql statement to insert product data
    $sql = "INSERT INTO products (name,description,quantity,category,price,brand) VALUES (?,?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ssssss",$name,$description,$quantity,$category,$price,$brand);

    // execute the statement
    if($stmt->execute()){
        $message="Product added successfully";
        header("Location:view-product.php");
    }else{
        $message="Error: " . $stmt->error;
    }
    // close the statement;
    $stmt->close();
}

// close the connection
$conn->close();


?>

<body>
    <h1>Products</h1>
    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="create-product-display.php" method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required><br><br>
           <label for="description">description</label>
            <input type="text" name="description" id="description" required><br><br>
            <label for="category">category</label>
            <input type="text" name="category" id="category" required><br><br>
            <label for="brand">brand</label>
            <input type="text" name="brand" id="brand" required><br><br>
            <label for="quantity">quantity</label>
            <input type="text" name="quantity" id="quantity" required><br><br>
            <label for="price">price</label>
            <input type="text" name="price" id="price" required><br><br>
              <input type="submit" value="Submit">
        </form>
</body>
</html>