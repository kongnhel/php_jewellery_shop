<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit; // Ensure the script stops executing after redirect
}

if(isset($_POST['update_profile'])){

   // Sanitize and update name and email
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $admin_id]);

   // Handle image upload
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['old_image'];

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'Image size is too large!';
      } else {
         $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $admin_id]);
         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[] = 'Image updated successfully!';
         }
      }
   }

   // Handle password update
   $old_pass = $_POST['old_pass'];
   $update_pass = md5($_POST['update_pass']);
   $new_pass = md5($_POST['new_pass']);
   $confirm_pass = md5($_POST['confirm_pass']);

   if(!empty($update_pass) && !empty($new_pass) && !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'Old password does not match!';
      } elseif($new_pass != $confirm_pass){
         $message[] = 'Confirm password does not match!';
      } else {
         $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $admin_id]);
         $message[] = 'Password updated successfully!';
      }
   }

   // Handle user type update
   $user_type = filter_var($_POST['user_type'], FILTER_SANITIZE_STRING);
   $update_user_type = $conn->prepare("UPDATE `users` SET user_type = ? WHERE id = ?");
   $update_user_type->execute([$user_type, $admin_id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Admin Profile</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-profile">

   <h1 class="title">Update Profile</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
      <div class="flex">
         <div class="inputBox">
            <span>Username:</span>
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="Update username" required class="box">
            <span>Email:</span>
            <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="Update email" required class="box">
            <span>Update Picture:</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
            <span>Old Password:</span>
            <input type="password" name="update_pass" placeholder="Enter previous password" class="box">
            <span>New Password:</span>
            <input type="password" name="new_pass" placeholder="Enter new password" class="box">
            <span>Confirm Password:</span>
            <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
            <div class="show-password" style="text-align: start; margin: 10px;">
               <input type="checkbox" onclick="show() " style="margin: 0 10px;">  Show Password
            </div>
         </div>
         <div class="inputBox">
            <span>User Type:</span>
            <select name="user_type" class="box" required>
               <?php
                  $update_users = $conn->query("SELECT id, u_type FROM users_type");
                  while ($row = $update_users->fetch(PDO::FETCH_ASSOC)) {
                     echo "<option value='{$row['id']}'>{$row['u_type']}</option>";
                  }
               ?>
            </select>
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="Update Profile" name="update_profile">
         <a href="admin_page.php" class="option-btn">Go Back</a>
      </div>
   </form>

</section>

<script src="js/script.js"></script>

</body>
<script>
   function show() {
   var passField = document.getElementsByName('update_pass')[0];
   var cpassField = document.getElementsByName('new_pass')[0];
   var cpassField1 = document.getElementsByName('confirm_pass')[0];
   if (passField.type === 'password') {
      passField.type = 'text';
      cpassField.type = 'text';
      cpassField1.type = 'text';
   } else {
      passField.type = 'password';
      cpassField.type = 'password';
      cpassField1.type = 'password';
   }
}
</script>
</html>
