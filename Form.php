<?php
session_start();

// Retrive error messages
$name_error=isset($_SESSION['name_error'])?$_SESSION['name_error']:'';
$email_error=isset($_SESSION['email_error'])?$_SESSION['email_error']:'';
$password_error=isset($_SESSION['password_error'])?$_SESSION['password_error']:'';
$username_error=isset($_SESSION['username_error'])?$_SESSION['username_error']:'';

// clear error mesages after displaying them
unset($_SESSION['name_error']);
unset($_SESSION['email_error']);
unset($_SESSION['password_error']);
unset($_SESSION['username_error']);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Fill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body>
    <form action="submitform.php" method="POST">
        <label for="name">Name</label>
        <input type="text" name="name" value="ame" placeholder="Name" required>
        <label for="username">UserName</label>
        <input type="text" name="username" id="username" value="username" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="email" placeholder="Email" required>
        <label for="password">Password</label>
       <input type="password" name="password" id="password">
        
        <input type="submit" value="Submit">
    </form>
    
</body>
</html>