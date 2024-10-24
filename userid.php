<?php
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


?>