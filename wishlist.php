<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location: login.php');
};


if(isset($_POST['add_to_cart'])){
    $car_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $car_price = $_POST['car_price'];
    $car_image = $_POST['car_image'];
    $car_quantity = $_POST['car_quantity'];

    // Debugging statement
    echo "car ID: $car_id, Name: $car_name, Price: $car_price, Image: $car_image, Quantity: $car_quantity";

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$car_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    } else {
        // Debugging statement
        echo "Inserting into cart table";

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$car_id', '$car_name', '$car_price', '$car_quantity', '$car_image')") or die(mysqli_error($conn));

        $message[] = 'product added to cart';
    }
}
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed');
    header('location:wishlist.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
    header('location:wishlist.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>your wishlist</h3>
    <p> <a href="home.php">home</a> / wishlist </p>
</section>

<section class="wishlist">
    <h1 class="title">products added</h1>
    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_wishlist) > 0) {
            while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
                ?>
                <form action="" method="POST" class="box">
                    <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
                    <img src="cars/<?php echo $fetch_wishlist['image']; ?>" alt="" class="image">
                    <div class="name"><?php echo $fetch_wishlist['name']; ?></div>
                    <div class="price">$<?php echo $fetch_wishlist['price']; ?>/-</div>
                    <input type="number" name="car_quantity" value="1" min="0" class="qty">
                    <input type="hidden" name="car_id" value="<?php echo $fetch_wishlist['pid']; ?>">
                    <input type="hidden" name="car_name" value="<?php echo $fetch_wishlist['name']; ?>">
                    <input type="hidden" name="car_price" value="<?php echo $fetch_wishlist['price']; ?>">
                    <input type="hidden" name="car_image" value="<?php echo $fetch_wishlist['image']; ?>">
                    <input type="submit" value="add to cart" name="add_to_cart" class="btn">
               </form>
                <?php
                $grand_total += $fetch_wishlist['price'];
            }
        } else {
            echo '<p class="empty">your wishlist is empty</p>';
        }
        if (isset($_GET['delete_all'])) {
            
            $delete_all_query = mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
            if ($delete_all_query) {
                header('location: wishlist.php');
            }
        }
        
        ?>
    </div>
    <div class="wishlist-total">
        <p>grand total: <span>$<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="option-btn">continue shopping</a>
        <a href="wishlist.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>"
           onclick="return confirm('Delete all from wishlist?');">delete all</a>
    </div>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
