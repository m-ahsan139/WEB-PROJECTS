<?php
session_start();

// Handle remove item from cart
if (isset($_POST['remove_item'])) {
    $product_id = (int)$_POST['product_id']; // Ensure it's an integer
    unset($_SESSION['cart'][$product_id]); // Remove product from cart
    header('Location: view_cart.php'); // Redirect to the cart page after removal
    exit();
}
?>