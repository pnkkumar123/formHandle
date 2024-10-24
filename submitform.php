<?php
session_start();
// define variables and set to empty values
$name=$email=$password=$username="";
$name_errror=$email_errror=$password_errror=$username_errror="";
// database connection variables
$servername="localhost";
$username_db="root";
$password_db="";
$database="forms";




function err($var){
    echo $var . " is required ";

}
function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty($_POST["name"])){
    $name_errror=err("name");
    }else{
        $name= test_input($_POST["name"]);
    }
    if(empty($_POST["email"])){
        $email_errror=err("email");
    }else{
        $email=test_input($_POST["email"]);
    }
    if(empty($_POST["password"])){
        $password_errror=err("password");
    }else{
        $password=test_input($_POST["password"]);
    }
    if(empty($_POST["username"])){
        $username_errror=err("password");
    }else{
        $email=test_input($_POST["username"]);
    }
// if there are errors,store them in session and redirect

if($name_errror || $email_errror || $password_errror || $username_errror){
    $_SESSION['name_error']=$name_errror;
    $_SESSION['email_error']=$email_errror;
    $_SESSION['password_error']=$password_errror;
    $_SESSION['username_error']=$username_errror;

    // redirect to back to form page
    header("Location: form.php");
    exit();
}
// create db connection
$conn=new mysqli($servername,$username_db,$password_db,$database);

// check connection
if($conn->connect_error){
    die("Connection failed : " . $conn->connect_error);
}
// prepare and bind
$stmt=$conn->prepare("INSERT INTO users (name,username,email,password) VALUES(?,?,?,?)");
$stmt->bind_param("ssss",$name,$username,$email,$password);

if($stmt->execute()){
    echo "New record created Successfully";
}else{
    echo "Error : " . $stmt->error;
}

$stmt->close();
$conn->close();

}


?>