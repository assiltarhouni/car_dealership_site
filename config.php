<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'car_shop_db';


$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    
    echo "Connection failed: " . mysqli_connect_error();
    exit;
}


?>
