<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit; // Ensure the script stops executing after redirect
}

if(isset($_POST['update_user'])){

   // Handle user type update
   $user_type = filter_var($_POST['user_type'], FILTER_SANITIZE_STRING);
   $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
   
   if($user_id && $user_type){
      $update_user_type = $conn->prepare("UPDATE `users` SET user_type = ? WHERE id = ?");
      $update_user_type->execute([$user_type, $user_id]);
      $message[] = 'User type updated successfully!';
   } else {
      $message[] = 'Failed to update user type!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update User Type</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-profile">

   <h1 class="title">Update User Type</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="inputBox">
         <span>Select User:</span>
         <select name="user_id" class="box" required>
            <?php
               $select_users = $conn->query("SELECT id, name FROM users");
               while ($row = $select_users->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='{$row['id']}'>{$row['name']}</option>";
               }
            ?>
         </select>
      </div>

      <div class="inputBox">
         <span>User Type:</span>
         <select name="user_type" class="box" required>
            <?php
               $select_user_types = $conn->query("SELECT id, u_type FROM users_type");
               while ($row = $select_user_types->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='{$row['id']}'>{$row['u_type']}</option>";
               }
            ?>
         </select>
 
      </div>

      <div class="flex-btn">
         <input type="submit" class="btn" value="Update User" name="update_user">
         <a href="admin_users.php" class="option-btn">Go Back</a>
      </div>
   </form>

</section>

<script src="js/script.js"></script>

</body>
</html>
