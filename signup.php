<?php
include 'db.php';
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists in the database
    if ($stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ?')) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error_message = 'Email is already taken!';
        } else {
            // Insert new user into the database
            if ($stmt = $mysqli->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)')) {
                $role = 'user'; // Default role is user
                $stmt->bind_param('ssss', $username, $email, $hashed_password, $role);
                $stmt->execute();
                header('Location: login.php'); // Redirect to login page after successful signup
                exit();
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>
    <div class="container">
        <form action="signup.php" method="POST" class="form-container">
            <h2>Signup</h2>
            <?php
            if (isset($error_message)) {
                echo '<p style="color: red;">' . $error_message . '</p>';
            }
            ?>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Signup</button>
            <div class="toggle-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>

</html>