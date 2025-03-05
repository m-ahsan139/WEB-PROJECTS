<?php
include 'db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Check if product ID is provided
if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id']; // Ensure integer to prevent SQL injection

    // Check if the product exists
    $check_product = "SELECT image FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($check_product);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Delete associated records from the carts table to avoid foreign key constraint error
        $delete_cart_query = "DELETE FROM carts WHERE product_id = ?";
        $stmt = $mysqli->prepare($delete_cart_query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        // Delete the product from the products table
        $delete_product_query = "DELETE FROM products WHERE id = ?";
        $stmt = $mysqli->prepare($delete_product_query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        // Delete the product image from the server
        $image_path = "images/" . $product['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        header('Location: admin_dashboard.php?success=Product deleted successfully');
        exit();
    } else {
        echo "<script>alert('Product not found.'); window.location.href='admin_dashboard.php';</script>";
    }
} else {
    header('Location: admin_dashboard.php');
    exit();
}
?>