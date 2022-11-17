<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_author_name=$_POST['product_author_name'];
   $product_edition=$_POST['product_edition'];
 
   
   // $product_available_qty=$_POST['product_available_qty'];
   $product_image = $_POST['product_image'];
  
function function_alert($message) {
      
   // Display the alert box 
   echo "<script>alert('$message');</script>";
}

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      function_alert("already added to cart!");
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, author_name, edition, image) VALUES('$user_id', '$product_name', '$product_price','$product_author_name','$product_edition', '$product_image')") or die('query failed');
      function_alert("product added to cart!");
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>our shop</h3>
   <p> <a href="home.php">home</a> / shop </p>
</div>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
               
      ?>
     <form action="" method="post" class="box">
      <a href="http://localhost/SecondHandBooks/project/view_more.php"><img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""></a>
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="name">Author-<?php echo $fetch_products['author_name']; ?></div>
      <div class="name">Edition-<?php echo $fetch_products['edition']; ?></div>
      <div class="price">Rs.<?php echo $fetch_products['price']; ?>/-</div>
      <!-- <div class="name">Available Quantity:<?php echo $fetch_products['quantity']; ?></div> -->
      
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_author_name" value="<?php echo $fetch_products['author_name']; ?>">
      <input type="hidden" name="product_edition" class="box" value="<?php echo $fetch_products['edition']; ?>">
      <input type="hidden" name="product_quantity" value="<?php echo $fetch_products['quantity']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn" <?php echo ($fetch_products['quantity']>0)?'':'disabled'; ?>> 
      
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>