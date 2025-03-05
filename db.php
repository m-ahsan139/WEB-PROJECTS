<?php
$host = 'localhost';
$dbname = 'e_commerce';
$user = 'root';
$password = '';

// Create connection
$mysqli = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
?>
