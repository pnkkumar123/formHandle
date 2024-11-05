<?php
session_start();

// check if the user is logged in
if(!isset($_SESSION['username'])){
    header("Location:login.html");
    exit();
}
echo "Welcome, " . $_SESSION['usrname'] . "!<br>";



?>
<a href="logout.php">Logout</a>