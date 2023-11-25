<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>About Us</h3>
    <p> <a href="home.php">home</a> / about </p>
</section>

<section class="about">

    <div class="flex">

        <div class="content">
            <h3>Why Choose Us?</h3>
            <p> We offer a wide range of high-quality cars to meet your needs.</p>
            <a href="shop.php" class="btn">Shop Now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>What We Provide?</h3>
            <p> We provide top-notch customer service and a diverse selection of vehicles.</p>
            <a href="contact.php" class="btn">Contact Us</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>Who We Are?</h3>
            <p> We are a dedicated team passionate about helping you find your perfect car.</p>
            
        </div>

    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
