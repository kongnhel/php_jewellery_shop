<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Use FILTER_SANITIZE_EMAIL for email input
   $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $hashed_pass = md5($pass);

   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $hashed_pass]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['user_type'] == '1'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == '2'){

         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');


      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/components.css">
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<section class="form-container">

   <form action="" method="POST">
      <h3>Login Now</h3>
      <input type="email" name="email" class="box" placeholder="Enter your email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your password" required>
      <div class="show-password" style="text-align: start; margin: 10px;">
         <input type="checkbox" onclick="show() " style="margin: 0 10px;">  Show Password
      </div>
      <input type="submit" value="Login Now" class="btn" name="submit">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
      <p style="font-size: 14px;">continue to shop without login <a href="home.php"> Continue</a></p>
   </form>

</section>

</body>
<script>
   function show() {
   var passField = document.getElementsByName('pass')[0];
   var cpassField = document.getElementsByName('cpass')[0];
   if (passField.type === 'password') {
      passField.type = 'text';
      cpassField.type = 'text';
   } else {
      passField.type = 'password';
      cpassField.type = 'password';
   }
}
</script>
</html>
