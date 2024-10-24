<?php
session_start();
include 'db.php';
// setting variables to empty
$name=$username=$email=$password=$mobile="";
$name_error=$password_error=$email_error=$username_error=$mobile_error="";



function err($val){
    echo $val . " is required ";
}
function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty($_POST["name"])){
        $name_error=err("name");
    }
    else{
        $name=test_input($_POST["name"]);
    }
    if(empty($_POST["username"])){
        $username_error=err("username");

    }
    else{
        $username=test_input($_POST["username"]);
    }
    if(empty($_POST["password"])){
        $password_error=err("password");
    }
    else{
        $password=test_input($_POST["password"]);
    }
    if(empty($_POST["mobile"])){
        $password_error=err("mobile");
    }
    else{
        $mobile=test_input($_POST["mobile"]);
    }

    // if there are arrays store them in session and redirect them
    if($name_error || $username_error || $password_error || $mobile_error){
        $_SESSION['name_error']=$name_error;
        $_SESSION['username_error']=$username_error;
        $_SESSION['password_error']=$password_error;
        $_SESSION['mobile_error']=$mobile_error;

        // redirect to form  page
        header("Location:Details.php");
        exit();
    }
    
    // prepare and bind
    $stmt=$conn->prepare("INSERT INTO users (name,username,email,password,mobile) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss",$name,$email,$password,$username,$mobile);

    if($stmt->execute()){
        echo "New Record created successfully";
        header("Location: viewdata.php");
    }
    else{
        echo "Error : " .  $stmt->error;
    }
    $stmt->close();
    $conn->close();
}




?>