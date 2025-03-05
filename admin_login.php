<?php
session_start();

// Fixed admin username and password
$admin_username = 'admin';
$admin_password = 'admin123'; // change this to your desired password

// Check if the login form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered credentials match the fixed ones
    if ($username === $admin_username && $password === $admin_password) {
        // Set session to indicate the admin is logged in
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php'); // Redirect to the admin dashboard
        exit();
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style5.css">
</head>

<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error_message)): ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>