<?php

include 'config.php';


session_start();


$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location: login.php');
}


if (isset($_POST['add_to_wishlist'])) {
    $car_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $car_price = $_POST['car_price'];
    $car_image = $_POST['car_image'];

    
    $check_wishlist = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = '$user_id' AND pid = '$car_id'");
    if (mysqli_num_rows($check_wishlist) > 0) {
        $message[] = 'Car is already in your wishlist';
    } else {
        
        mysqli_query($conn, "INSERT INTO wishlist (user_id, pid, name, price, image) VALUES ('$user_id', '$car_id', '$car_name', '$car_price', '$car_image')");
        $message[] = 'Car added to your wishlist';
    }
}

if (isset($_POST['add_to_cart'])) {
    $car_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $car_price = $_POST['car_price'];
    $car_image = $_POST['car_image'];
    $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id' AND pid = '$car_id'");
    if (mysqli_num_rows($check_cart) > 0) {
        $message[] = 'Car is already in your cart';
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, pid, name, price, image) VALUES ('$user_id', '$car_id', '$car_name', '$car_price', '$car_image')");
        $message[] = 'Car added to your cart';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <title>Search Page</title>
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Search Page</h3>
    <p> <a href="home.php">Home</a> / Search </p>
</section>

<section class="search-form">
    <form action="" method="POST">
        <input type="text" class="box" placeholder="Search cars..." name="search_box">
        <input type="submit" class="btn" value="Search" name="search_btn">
    </form>
</section>

<section class="products" style="padding-top: 0;">
   <div class="box-container">
      <?php
        if (isset($_POST['search_btn'])) {
            $search_box = mysqli_real_escape_string($conn, $_POST['search_box']);
            $select_cars = mysqli_query($conn, "SELECT * FROM cars WHERE name LIKE '%$search_box%'") or die('Query failed');
            if (mysqli_num_rows($select_cars) > 0) {
                while ($car = mysqli_fetch_assoc($select_cars)) {
      ?>
      <form action="" method="POST" class="box">
         <div class="price">$<?php echo $car['price']; ?>/-</div>
         <img src="cars/<?php echo $car['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $car['name']; ?></div>
         <input type="number" name="car_quantity" value="1" min="0" class="qty">
         <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
         <input type="hidden" name="car_name" value="<?php echo $car['name']; ?>">
         <input type="hidden" name="car_price" value="<?php echo $car['price']; ?>">
         <input type="hidden" name="car_image" value="<?php echo $car['image']; ?>">
         <input type="submit" value="Add to Wishlist" name="add_to_wishlist" class="option-btn">
         <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
      </form>
      <?php
                }
            } else {
                echo '<p class="empty">No cars found!</p>';
            }
        } else {
            echo '<p class="empty">Search something!</p>';
        }
      ?>
   </div>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>
