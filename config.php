<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'car_shop_db';

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    // If the connection fails, display an error message and exit
    echo "Connection failed: " . mysqli_connect_error();
    exit;
}

// Connection is successful, continue with your code
?>
