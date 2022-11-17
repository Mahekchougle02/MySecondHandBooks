<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>
<section class="dashboard">
   <h1 class="title">dashboard</h1>
   <div class="box-container">
   <div class="box">
         <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>Number of users</p>
      </div>
      <div class="box">
         <?php 
            $result = mysqli_query($conn, "SELECT SUM(quantity1) as sum_quantity1 FROM `products`") or die('query failed');
            $row= mysqli_fetch_assoc($result);
            $sum=$row['sum_quantity1'];
         ?>
         <h3><?php echo $sum; ?></h3>
         <p>Number of Books Uploaded</p>
      </div>
      <div class="box">
         <?php 
            $result = mysqli_query($conn, "SELECT SUM(quantity) as sum_quantity FROM `products`") or die('query failed');
            $row= mysqli_fetch_assoc($result);
            $sum1=$row['sum_quantity'];
         ?>
         <h3><?php echo $sum1; ?></h3>
         <p>Number of Books Available</p>
      </div>
      <div class="box">
         <?php 
            $sum2=$sum-$sum1;
         ?>
         <h3><?php echo $sum2; ?></h3>
         <p>Number of Books Sold</p>
      </div>
      <div class="box">
         <?php 
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Order placed</p>
      </div>
      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
           $number_of_orders = mysqli_num_rows($select_pending);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Number of Orders Pending</p>
      </div>
      <div class="box">
         <?php
            $total_pendings = 0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
           $number_of_orders = mysqli_num_rows($select_completed);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Number of Orders Completed</p>
      </div>
      <div class="box">
         <?php 
            $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>New messages</p>
      </div>
   </div>
</section>
<script src="js/admin_script.js"></script>
</body>
</html>