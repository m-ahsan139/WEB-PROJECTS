<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle remove item from cart
if (isset($_POST['remove_item'])) {
    $cart_id = (int)$_POST['cart_id']; // Ensure it's an integer
    $query_remove = "DELETE FROM carts WHERE id = $cart_id AND user_id = $user_id";
    $mysqli->query($query_remove);
    header('Location: view_cart.php'); // Redirect to refresh the cart
    exit();
}

// Fetch cart data from the database
$query = "SELECT c.id, p.name, p.price, c.quantity, c.size_id 
          FROM carts c
          JOIN products p ON c.product_id = p.id
          WHERE c.user_id = $user_id";
$result = $mysqli->query($query);

$cart_items = [];
$total_price = 0;

if ($result) {
    while ($cart_item = $result->fetch_assoc()) {
        // Fetch size name
        $size_name = 'Unknown Size';
        if (isset($cart_item['size_id'])) {
            $size_id = $cart_item['size_id'];
            $query_size = "SELECT size_name FROM sizes WHERE id = $size_id";
            $result_size = $mysqli->query($query_size);
            if ($result_size) {
                $size_data = $result_size->fetch_assoc();
                $size_name = $size_data['size_name'];
            }
        }

        $cart_item['size_name'] = $size_name;
        $cart_items[] = $cart_item;
        $total_price += $cart_item['price'] * $cart_item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style4.css">
</head>

<body>
    <div class="container">
        <h1>Your Cart</h1>

        <?php if (!empty($cart_items)): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>

            <?php foreach ($cart_items as $cart_item): ?>
            <tr>
                <td><?php echo htmlspecialchars($cart_item['name']); ?></td>
                <td><?php echo htmlspecialchars($cart_item['size_name']); ?></td>
                <td>$<?php echo number_format($cart_item['price'], 2); ?></td>
                <td><?php echo $cart_item['quantity']; ?></td>
                <td>$<?php echo number_format($cart_item['price'] * $cart_item['quantity'], 2); ?></td>
                <td>
                    <form action="view_cart.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?php echo $cart_item['id']; ?>">
                        <button type="submit" name="remove_item">Remove</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3>Total Price: $<?php echo number_format($total_price, 2); ?></h3>
        <?php else: ?>
        <p>Your cart is empty!</p>
        <?php endif; ?>

        <br>
        <button onclick="window.location.href='products.php'">Continue Shopping</button>
    </div>
</body>

</html>