<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="dashboard">

   <h1 class="title">Dashboard</h1>

   <div class="box-container">

      <div class="box">
      <img src="./uploaded_img/pending.jpg" alt="img" width="100%">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT total_price FROM `orders` WHERE payment_status = ?");
         $select_pendings->execute(['pending']);
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            $total_pendings += $fetch_pendings['total_price'];
         }
      ?>
      <h3>$<?= $total_pendings; ?>/-</h3>
      <p>Total Pending</p>
      <a href="admin_orders.php" class="btn">See Orders</a>
      </div>

      <div class="box">
      <img src="./uploaded_img/order.jpg" alt="img" width="100%">
      <?php
         $total_completed = 0;
         $select_completed = $conn->prepare("SELECT total_price FROM `orders` WHERE payment_status = ?");
         $select_completed->execute(['completed']);
         while($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)){
            $total_completed += $fetch_completed['total_price'];
         }
      ?>
      <h3>$<?= $total_completed; ?>/-</h3>
      <p>Completed Orders</p>
      <a href="admin_orders.php" class="btn">See Orders</a>
      </div>

      <div class="box">
      <img src="./uploaded_img/order.jpg" alt="img" width="100%">
      <?php
         $select_orders = $conn->prepare("SELECT id FROM `orders`");
         $select_orders->execute();
         $number_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $number_of_orders; ?></h3>
      <p>Orders Placed</p>
      <a href="admin_orders.php" class="btn">See Orders</a>
      </div>

      <div class="box">
         <img src="./uploaded_img/product_add.jpg" alt="img" width="100%">
      <?php
         $select_products = $conn->prepare("SELECT id FROM `products`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>Products Added</p>
      <a href="admin_products.php" class="btn">See Products</a>
      </div>

      <div class="box">
      <img src="./uploaded_img/AccountIcon2.png" alt="img" width="100%">
      <?php
         $select_users = $conn->prepare("SELECT id FROM `users` WHERE user_type = 2");
         $select_users->execute();
         $number_of_users = $select_users->rowCount();
      ?>
      <h3><?= $number_of_users; ?></h3>
      <p>Total Users</p>
      <a href="admin_users.php" class="btn">See Accounts</a>
      </div>

      <div class="box">
      <img src="./uploaded_img/adminn.jpg" alt="img" width="100%">
      <?php
         $select_admins = $conn->prepare("SELECT id FROM `users` WHERE user_type = 1");
         $select_admins->execute();
         $number_of_admins = $select_admins->rowCount();
      ?>
      <h3><?= $number_of_admins; ?></h3>
      <p>Total Admins</p>
      <a href="admin_users.php" class="btn">See Accounts</a>
      </div>

      <div class="box">
      <img src="./uploaded_img/userrr.jpg" alt="img" width="100%">
      <?php
         $select_accounts = $conn->prepare("SELECT id FROM `users`");
         $select_accounts->execute();
         $number_of_accounts = $select_accounts->rowCount();
      ?>
      <h3><?= $number_of_accounts; ?></h3>
      <p>Total Accounts</p>
      <a href="admin_users.php" class="btn">See Accounts</a>
      </div>

      <div class="box">
      <img src="./uploaded_img/message.jpg" alt="img" width="100%">
      <?php
         $select_messages = $conn->prepare("SELECT id FROM `message`");
         $select_messages->execute();
         $number_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $number_of_messages; ?></h3>
      <p>Total Messages</p>
      <a href="admin_contacts.php" class="btn">See Messages</a>
      </div>

   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>
