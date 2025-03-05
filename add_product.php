<?php
include 'db.php';
session_start();

// Check if the user is logged in (Admin)
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price']; // Ensure price is a float
    $size = trim($_POST['size']);
    $description = trim($_POST['description']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "images/" . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Insert product into the database
            $query = "INSERT INTO products (name, price, size, description, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("sdsss", $name, $price, $size, $description, $image_name);

            if ($stmt->execute()) {
                header('Location: admin_dashboard.php?success=Product added successfully');
                exit();
            } else {
                echo "<script>alert('Database error: Failed to add product.');</script>";
            }
        } else {
            echo "<script>alert('Error uploading image.');</script>";
        }
    } else {
        echo "<script>alert('Invalid image file.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style8.css">
</head>

<body>
    <div class="container">
        <h1>Add New Product</h1>

        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" value="12.00" required>

            <label for="size">Size:</label>
            <select id="size" name="size" required>
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image" required>

            <button type="submit" name="add_product">Add Product</button>
        </form>

        <br>
        <button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
    </div>
</body>

</html>