<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit; // Ensure the script stops executing after redirect
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="user-accounts">

   <h1 class="title">User Accounts</h1>

   <div class="box-container">

      <?php
         $select_users = $conn->prepare("
            SELECT users.*, users_type.u_type 
            FROM `users` 
            JOIN `users_type` ON users.user_type = users_type.id
         ");
         $select_users->execute();
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="<?php if($fetch_users['id'] == $admin_id){ echo 'display:none'; }; ?>">
         <img src="uploaded_img/<?= $fetch_users['image']; ?>" alt="">
         <p> User ID : <span><?= $fetch_users['id']; ?></span></p>
         <p> Username : <span><?= $fetch_users['name']; ?></span></p>
         <p> Email : <span><?= $fetch_users['email']; ?></span></p>
         <p> User Type : <span style="color:<?php if($fetch_users['u_type'] == 'admin'){ echo 'orange'; } else { echo 'green'; }; ?>"><?= $fetch_users['u_type']; ?></span></p>
         <a href="update_users.php?user_id=<?= $fetch_users['id']; ?>" class="btn">Update User Type</a>
         <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete</a>
      </div>
      <?php
         }
      ?>
   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>
