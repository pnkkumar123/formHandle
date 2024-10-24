<?php
session_start();
include 'header.php';

function error($val) {
    // if I used echo, variable are set to null therefore I used return
    return isset($_SESSION[$val]) ? $_SESSION[$val] : '';
}

// Retrieve error messages
$name_error = error('name_error');
$email_error = error('email_error');
$password_error = error('password_error');
$mobile_error = error('mobile_error');
$username_error = error('username_error');

unset($_SESSION['name_error']);
unset($_SESSION['password_error']);
unset($_SESSION['mobile_error']);
unset($_SESSION['username_error']);
unset($_SESSION['password_error']);
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center">User Details Form</h2>
        <form action="DetailSubmit.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
                <?php if ($name_error): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($name_error); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
                <?php if ($email_error): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($email_error); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <?php if ($password_error): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($password_error); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
                <?php if ($username_error): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($username_error); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" name="mobile" id="mobile" class="form-control" required>
                <?php if ($mobile_error): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($mobile_error); ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php
include 'footer.php';
?>
