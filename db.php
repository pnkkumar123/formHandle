<?php
// database connection details
$servername="localhost";
$username_db="root";
$password_db="";
$database="details";


// create db connection
$conn= new mysqli($servername,$username_db,$password_db,$database);
// check connection 
if($conn->connect_error){
    die("Connection error " . $conn->connect_error);
}
?>