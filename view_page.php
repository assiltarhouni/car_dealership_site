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
        $message[] = 'Already added to wishlist';
    } elseif (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart';
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$car_id', '$car_name', '$car_price', '$car_image')") or die('query failed');
        $message[] = 'Car added to wishlist';
    }
}

if (isset($_POST['add_to_cart'])) {

    $car_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $car_price = $_POST['car_price'];
    $car_image = $_POST['car_image'];
    $car_quantity = $_POST['car_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$car_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart';
    } else {

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$car_name' AND user_id = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_wishlist_numbers) > 0) {
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$car_name' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$car_id', '$car_name', '$car_price', '$car_quantity', '$car_image')") or die('query failed');
        $message[] = 'Car added to cart';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick View</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom admin CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="quick-view">
    <h1 class="title">Car Details</h1>

    <?php
    if (isset($_GET['cid'])) {
        $cid = $_GET['cid'];
        $select_cars = mysqli_query($conn, "SELECT * FROM `cars` WHERE id = '$cid'") or die('Query failed');
        if (mysqli_num_rows($select_cars) > 0) {
            while ($fetch_car = mysqli_fetch_assoc($select_cars)) {
                ?>
                <form action="" method="POST">
                    <img src="cars/<?php echo $fetch_car['image']; ?>" alt="" class="image">
                    <div class="name"><?php echo $fetch_car['name']; ?></div>
                    <div class="price">$<?php echo $fetch_car['price']; ?>/-</div>
                    <div class="type"><?php echo $fetch_car['type']; ?></div>
                    <input type="number" name="car_quantity" value="1" min="0" class="qty">
                    <input type="hidden" name="car_id" value="<?php echo $fetch_car['id']; ?>">
                    <input type="hidden" name="car_name" value="<?php echo $fetch_car['name']; ?>">
                    <input type="hidden" name="car_price" value="<?php echo $fetch_car['price']; ?>">
                    <input type="hidden" name="car_image" value="<?php echo $fetch_car['image']; ?>">
                    <input type="submit" value="Add to Wishlist" name="add_to_wishlist" class="option-btn">
                    <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">No car details available!</p>';
        }
    }
    ?>

    <div class="more-btn">
        <a href="home.php" class="option-btn">Go to Home Page</a>
    </div>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
