<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:login.php');
};


if(isset($_POST['add_product'])){
   // $product_id=$_POST['product_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
   $edition = mysqli_real_escape_string($conn, $_POST['edition']);
   $price = $_POST['price'];
   $seller_name = mysqli_real_escape_string($conn, $_POST['seller_name']);
   $seller_email = mysqli_real_escape_string($conn, $_POST['seller_email']);
   $quantity=$_POST['quantity'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
  
   

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');
   $quantity1=$quantity;

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(user_id,name,author_name,edition, price,quantity, image,seller_name,seller_email,quantity1) VALUES('$user_id','$name','$author_name','$edition', '$price','$quantity', '$image','$seller_name','$seller_email','$quantity1') ")or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:user_products.php');
}

  

 

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'header.php'; ?>


<section class="add-products">

   <h1 class="title">sell books</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add books</h3>
      
      
      <input type="text" name="name" class="box" placeholder="Enter book name" required>
      <input type="text" name="author_name" class="box" placeholder="Enter author name" required>
      <input type="text" name="edition" class="box" placeholder="Enter edition" >
      <input type="number" min="0" name="price" class="box" placeholder="Enter book price" required>
      <input type="text" name="seller_name" class="box" placeholder="Enter username" required>
      <input type="email" name="seller_email" placeholder="Enter your email" required class="box" >
      <input type="number" min="1" name="quantity" class="box" placeholder="Quantity" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      
      <input type="submit" value="add product" name="add_product" class="btn"  >




      
   </form>

</section>



<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
              
               
      ?>
      <div class="box">
      
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $product_id= $fetch_products['name']; ?></div>
         <!-- <div class="product_id"><?php echo $fetch_products['product_id']; ?></div> -->
         <div class="name">Author-<?php echo $fetch_products['author_name']; ?></div>
         <div class="name">Edition-<?php echo $fetch_products['edition']; ?></div>
         <div class="price">Rs.<?php echo $fetch_products['price']; ?>/-</div>
         <!-- <div class="name">Available Quantity:<?php echo $fetch_products['quantity']; ?></div> -->


        
        
         
        
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>









<script src="js/admin_script.js"></script>

</body>
</html>