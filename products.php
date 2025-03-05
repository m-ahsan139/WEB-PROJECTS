<?php
session_start();
include 'header.php';
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch products from the database
$query = "SELECT * FROM products";
$result = $mysqli->query($query);
$products = [];

if ($result) {
    while ($product = $result->fetch_assoc()) {
        $products[] = $product;
    }
}

// Handle Add to Cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $size_id = $_POST['size']; // Get the selected size ID

    // Insert the product into the cart table
    $query_insert = "INSERT INTO carts (user_id, product_id, quantity, size_id) 
                     VALUES ($user_id, $product_id, $quantity, $size_id)";
    $mysqli->query($query_insert);

    // Redirect to view_cart.php after adding the product to the cart
    header('Location: view_cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products</title>
    <link rel="stylesheet" href="css/style3.css">
</head>

<body>
    <div class="container">
        <h1>Our Products</h1>

        <div class="products">
            <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                <h4><?php echo htmlspecialchars($product['name']); ?></h4>

                <!-- Display Product Description -->
                <p><?php echo htmlspecialchars($product['description']); ?></p>

                <p>$<?php echo number_format($product['price'], 2); ?></p>
                <form action="products.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <label for="size">Size:</label>
                    <select name="size" required>
                        <?php
                        // Fetch all sizes from the database
                        $query_sizes = "SELECT * FROM sizes";
                        $result_sizes = $mysqli->query($query_sizes);
                        while ($size = $result_sizes->fetch_assoc()) {
                            echo "<option value='" . $size['id'] . "'>" . $size['size_name'] . "</option>";
                        }
                        ?>
                    </select>

                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" required>

                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No products available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
<?php
include 'footer.php';
?>