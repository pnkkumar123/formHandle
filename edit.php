<?php
include 'db.php';
include 'header.php';



if(isset($_GET['id'])){
    $id=intval($_GET['id']);

    // fetch current user data
    $stmt=$conn->prepare("SELECT name,email,username,mobile FROM users WHERE id= ?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->bind_result($name,$username,$email,$mobile);
    $stmt->fetch();
    $stmt->close();

}

// update user data
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id=intval($_POST['id']);
    $name=$_POST['name'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];

    // update statement
    $stmt=$conn->prepare("UPDATE users SET name=?,username=?,email=?,mobile=? WHERE id=?");
    $stmt->bind_param("ssssi",$name,$username,$email,$mobile,$id);

    if($stmt->execute()){
        echo "Record updated successfully";

    }else{
        echo "Error updating record:" . $conn->error;
    }
    $stmt->close();

    // redirect back to viewdata.php
    header("Location:viewdata.php");
    exit();
}
$conn->close();

?>
<body>
    <div class="container">
        <h2 class="mt-5">Edit User Details</h2>
        <form method="POST" action="edit.php">
           <input type="hidden" name="id" value="<?php echo $id; ?>">
           <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
           </div>
           <div class="mb-3">
            <label for="username" class="form-label">UserName</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
           </div>
           <div class="mb-3">
            <label for="email" class="form-label">email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
           </div>
           <div class="mb-3">
            <label for="mobile" class="form-label">mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo htmlspecialchars($mobile); ?>" required>
           </div>
           <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
<?php
include 'footer.php';
?>