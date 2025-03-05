<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <div class="container">
            <h1><a href="index.php">E-Commerce</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="products.php">Products</a></li>
                    <li><a href=" logout.php">Logout</a></li>
                    <?php else: ?>
                    <li><a href="signup.php">Signup</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="admin_login.php"> Admin Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>