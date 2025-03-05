<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to E-Commerce</title>
    <link rel="stylesheet" href="css/style2.css">
</head>

<body>
    <!-- Include the header -->
    <?php include 'header.php'; ?>

    <main>
        <div class="hero-section">
            <div class="hero-content">
                <h2>Welcome to Our E-Commerce Website!</h2>
                <p>Discover the latest products, amazing deals, and a seamless shopping experience.</p>

                <!-- Call-to-Action Buttons -->
                <div class="cta-buttons">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged-in user can go to the product page -->
                    <button onclick="window.location.href='products.php'">Shop Now</button>
                    <?php else: ?>
                    <!-- Non-logged-in users will be prompted to register -->
                    <button onclick="window.location.href='signup.php'">Register to Shop</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Include the footer -->
    <?php include 'footer.php'; ?>
</body>

</html>