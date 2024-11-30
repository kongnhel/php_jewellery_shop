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

<header class="header">
   <div class="flex">
      <a href="admin_page.php" class="logo">Admin<span>Page</span></a>
      <nav class="navbar"> 
         <a href="admin_page.php" ><i class="fa-solid fa-house-chimney-user"style="color: #28b463 ;"></i> home</a>
         <a href="admin_products.php"><i class="fa-regular fa-gem" style="color: #28b463 ;"></i> products</a>
         <a href="admin_orders.php"> <i class="fa-solid fa-truck-fast" style="color: #28b463 ;"></i> orders</a>
         <a href="admin_users.php"><i class="fa-solid fa-user" style="color: #28b463 ;"></i> users</a>
         <a href="admin_contacts.php"><i class="fa-solid fa-comment" style="color: #28b463 ;"></i> messages</a>
         <!-- <a href="Out _of_stock.php">Out of stock</a> -->
      </nav>

      <div class="icons" style="display: flex; justify-content:space-around; margin:0 20px;" >
     
      <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
          <div class="show" style="display: flex; align-items: center; justify-content: center; ">
          <div id="menu-btn" class="fas fa-bars"></div>
          <img src="uploaded_img/<?= $fetch_profile['image']; ?>" style="width: 30px; border-radius:50%;  margin:0 5px; box-shadow:0 0 5px #fff" id="user-btn" alt="">
          <p style="font-size:12px;   color:#fff;"><?= $fetch_profile['name']; ?>(admin)</p></div>
       
          <!-- <div id="user-btn" class="fas fa-user"></div> -->
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p ><?= $fetch_profile['name']; ?></p>
         <a href="admin_update_profile.php" class="btn">update profile</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>
   </div>
   

</header>