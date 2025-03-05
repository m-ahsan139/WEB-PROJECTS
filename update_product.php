<?php
session_start();
include 'db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php'); // Redirect to login page if not logged in
    exit();
}

// Check if a product ID is provided
if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id']; // Ensure it's an integer

    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();
    $product = $product_result->fetch_assoc();

    // If product not found, redirect to admin dashboard
    if (!$product) {
        header('Location: admin_dashboard.php');
        exit();
    }
}

// Handle update product action
if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // If an image is uploaded, move it to the images folder
    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
    } else {
        // Keep the existing image if no new one is uploaded
        $image = $product['image'];
    }

    $update_query = "UPDATE products SET name = ?, price = ?, size = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param('sdsssi', $name, $price, $size, $description, $image, $product_id);
    $stmt->execute();
    header('Location: admin_dashboard.php'); // Redirect to admin dashboard after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="css/style7.css">
</head>

<body>
    <div class="container">
        <h1>Update Product</h1>

        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo $product['price']; ?>" required>

            <label for="size">Size:</label>
            <input type="text" id="size" name="size" value="<?php echo htmlspecialchars($product['size']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"
                required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image">

            <button type="submit" name="update_product">Update Product</button>
        </form>
        <br>
        <button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
    </div>
</body>

</html>