<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin CSS file link  -->
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
                    <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>"
                       class="fas fa-times"
                       onclick="return confirm('Delete this from wishlist?');"></a>
                    <a href="view_page.php?pid=<?php echo $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
                    <img src="cars/<?php echo $fetch_wishlist['image']; ?>" alt="" class="image">
                    <div class="name"><?php echo $fetch_wishlist['name']; ?></div>
                    <div class="price">$<?php echo $fetch_wishlist['price']; ?>/-</div>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['pid']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
                    <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                </form>
                <?php
                $grand_total += $fetch_wishlist['price'];
            }
        } else {
            echo '<p class="empty">your wishlist is empty</p>';
        }
        if (isset($_GET['delete_all'])) {
            // Delete all items from the wishlist for the current user
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
