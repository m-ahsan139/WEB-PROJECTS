<?php
session_start();
include 'db.php';
include 'header.php'; // Include the header

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php'); // Redirect to login page if not logged in
    exit();
}

// Fetch all products from the database
$query = "SELECT * FROM products";
$result = $mysqli->query($query);
$products = [];

if ($result) {
    while ($product = $result->fetch_assoc()) {
        $products[] = $product;
    }
}

// Handle delete product action
if (isset($_POST['delete_product'])) {
    $product_id = (int)$_POST['product_id']; // Ensure it's an integer
    $delete_query = "DELETE FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($delete_query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    header('Location: admin_dashboard.php'); // Redirect to refresh the page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style6.css"> <!-- Link your CSS file -->
</head>

<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <h2>Manage Products</h2>

        <!-- Button to navigate to Add Product page -->
        <button class="btn-primary" onclick="window.location.href='add_product.php'">Add New Product</button>

        <!-- All Products Table -->
        <h3>All Products</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Size</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>$<?php echo number_format($product['price'], 12); ?></td>
                        <td><?php echo htmlspecialchars($product['size']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td>
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                        </td>
                        <td>
                            <form action="admin_dashboard.php" method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="delete_product" class="btn-delete">Delete</button>
                            </form>
                            <a href="update_product.php?id=<?php echo $product['id']; ?>" class="btn-update">Update</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; // Include the footer ?>
</body>

</html>