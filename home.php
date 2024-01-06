<?php
@include 'config.php';

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
  
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$car_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$car_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_wishlist_numbers) > 0) {
       $message[] = 'Car is already added to your wishlist';
   } elseif (mysqli_num_rows($check_cart_numbers) > 0) {
       $message[] = 'Car is already added to your cart';
   } else {
       mysqli_query($conn, "INSERT INTO `wishlist` (user_id, pid, name, price, image) VALUES ('$user_id', '$car_id', '$car_name', '$car_price', '$car_image')") or die('query failed');
       $message[] = 'Car added to wishlist';
   }
}


if(isset($_POST['add_to_cart'])){
   $car_id = $_POST['car_id'];
   $car_name = $_POST['car_name'];
   $car_price = $_POST['car_price'];
   $car_image = $_POST['car_image'];
   $car_quantity = $_POST['car_quantity'];

   
   echo "car ID: $car_id, Name: $car_name, Price: $car_price, Image: $car_image, Quantity: $car_quantity";

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$car_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   } else {
       
       echo "Inserting into cart table";

       mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$car_id', '$car_name', '$car_price', '$car_quantity', '$car_image')") or die(mysqli_error($conn));

       $message[] = 'product added to cart';
   }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   
</head>
<body>

<?php @include 'header.php'; ?>

<section class="home">
   <div class="content">
      <h3>New Collections</h3>
      <a href="shop.php" class="btn">Discover More</a>
   </div>
</section>

<section class="products">
   <h1 class="title">Latest Cars and parts</h1>

   <div class="box-container">
      <?php
      $select_cars = mysqli_query($conn, "SELECT * FROM `cars` LIMIT 6") or die('Query failed');
      if (mysqli_num_rows($select_cars) > 0) {
         while ($fetch_cars = mysqli_fetch_assoc($select_cars)) {
      ?>
      <form action="" method="POST" class="box">
         <div class="price">$<?php echo $fetch_cars['price']; ?>/-</div>
         <img src="cars/<?php echo $fetch_cars['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_cars['name']; ?></div>
         <input type="number" name="car_quantity" value="1" min="0" class="qty">
         <input type="hidden" name="car_id" value="<?php echo $fetch_cars['id']; ?>">
         <input type="hidden" name="car_name" value="<?php echo $fetch_cars['name']; ?>">
         <input type="hidden" name="car_price" value="<?php echo $fetch_cars['price']; ?>">
         <input type="hidden" name="car_image" value="<?php echo $fetch_cars['image']; ?>">
         <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No cars added yet!</p>';
      }
      ?>
   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">Load More</a>
   </div>
</section>

<section class="home-contact">
   <div class="content">
      <h3>Have any questions?</h3>
      <a href="contact.php" class="btn">Contact Us</a>
   </div>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
