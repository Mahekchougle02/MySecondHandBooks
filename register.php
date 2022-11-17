<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   $has_at_least_6_chars = '/(?=.*[a-zA-Z0-9]{6})/';
   $has_a_capital_letter = '/(?=.*[A-Z])/'; 
   $has_a_digit = '/(?=.*\d)/';
   
   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }elseif (empty($pass & $cpass)) { 
         $message[] = "You must enter a password";
   }elseif ($pass !== $cpass) {
         $message[] = "The passwords do not match";
   }elseif (!preg_match($has_at_least_6_chars, $pass)) {
         $message[] = "Your password must be at least 6 characters long";
   }elseif (!preg_match($has_a_capital_letter, $pass)) {
         $message[] = "Your password must have at least 1 capital letter";
   }elseif (!preg_match($has_a_digit, $pass)) {
         $message[] = "Your password must contain at least 1 number";
   }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
      }
   

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>



   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="password" placeholder="enter your password" required class="box"oninput="this.value = this.value.replace(/\s/g, '')" >
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box"oninput="this.value = this.value.replace(/\s/g, '')" >
      <select name="user_type" class="box">
         <option value="user">user</option>
         
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>