<?php
// session_start();

if (isset($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

$user_id = $_SESSION['user_id'] ?? null;

?>
<header class="header">

   <div class="flex" >
   <?php if (isset($admin_id)) {
      // <!-- <a href="admin_page.php" class="logo">Admin<span>Page</span></a> -->
      header('location:shop.php');
      exit(); ?>
    <?php }elseif(isset($user_id)){?> 
      <a href="home.php" class="logo" style="color: #f4d03f;">
         <img src="./uploaded_img/logo.png" width="30px" alt="logo" style="margin-top: -15px;">
         Jewelry <span>.</span></a>
      <?php }else{ ?>
         <a href="login.php" class="logo" style="color: #f4d03f;">
         <img src="./uploaded_img/logo.png" width="30px" alt="logo" style="margin-top: -15px;">
         Jewelry <span>.</span</a>
      </a>
         <?php } ?>
      <nav class="navbar" style="color:#000;">
          <a href="home.php" class="homes" ><i class="fa-solid fa-house-user" style="color: #28b463 ;"></i> home</a>
         <a href="shop.php"><i class="fa-solid fa-bag-shopping" style="color: #28b463 ;"></i> shop</a>
         <ul>
            <li>
               <a href="#"><i class="fa-solid fa-layer-group" style="color: #28b463 ;"></i> category <i class="fa-solid fa-caret-down"></i></a>
               <ul class="dropdown">
                  <?php
                     $category_types = $conn->query("SELECT id, type FROM category");
                     while ($row = $category_types ->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li><a href='category.php?category={$row['id']}'>{$row['type']}</a></li>";
                     }
                  ?>
               </ul>
            </li>
         </ul>
         <!-- <a href="orders.php">orders</a> -->
         <?php if ($user_id): ?> 
            <a href="orders.php"><i class="fa-solid fa-truck-fast" style="color: #28b463 ;"></i> orders</a>
         <?php endif; ?>
         <a href="about.php" style="color: #fff;"> <i class="fa-solid fa-address-card" style="color: #28b463 ;"></i> about</a>
         <a href="contact.php" style="color: #fff;" > <i class="fa-solid fa-file-signature" style="color: #28b463 ;"></i> contact</a>
      </nav>

      <div class="icons">
         <?php if (!isset($user_id)) { ?>
            <div id="user-btn" class="fas fa-user"></div>
         <?php } else { ?>
            <div class="show" style="display: flex; align-items: center; justify-content: space-around;">
               <a href="search_page.php" class="fas fa-search"></a>
               <?php
                  $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                  $count_cart_items->execute([$user_id]);

                  $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                  $count_wishlist_items->execute([$user_id]);
               ?>

               <div class="carts" style="position: relative; height:60px; width:50px; display:flex; align-items:center;justify-content:center; margin-left:5%">
               <a href="wishlist.php"><i class="fas fa-heart"></i></a>
                  <span style="width: 20px; height:20px; background: #28b463 ; border-radius:50%; padding:5px; color:#fff;font-size:12px; position:absolute; top:0; right:0; display:flex; align-items:center; justify-content:center;"><?= $count_wishlist_items->rowCount(); ?></span>
               </div>
               <div class="carts" style="position: relative; height:60px; width:50px; display:flex; align-items:center;justify-content:center; margin-left:2%">
                  <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                  <span style="width: 20px; height:20px; background: #28b463 ; border-radius:50%; padding:5px; color:#fff;font-size:12px; position:absolute; top:0; right:0; display:flex; align-items:center; justify-content:center;"><?= $count_cart_items->rowCount(); ?></span>
               </div>
             

               <?php
                  $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_profile->execute([$user_id]);
                  $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
               ?>
               <img src="uploaded_img/<?= $fetch_profile['image']; ?>" style="width: 30px; border-radius:50%; margin:0 5px;" id="user-btn" alt="">
               <p style="font-size:12px;"><?= $fetch_profile['name']; ?></p>
            </div>
         <?php } ?>
         
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <?php if (isset($user_id)) { ?>
         <div class="profile">
            <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
            <p><?= $fetch_profile['name']; ?></p>
            <a href="user_profile_update.php" class="btn">update profile</a>
            <a href="logout.php" class="delete-btn">logout</a>
         </div>
      <?php } else { ?>
         <div class="profile">
            <div class="flex-btn">
               <a href="login.php" class="option-btn">login</a>
               <a href="register.php" class="option-btn">register</a>
            </div>
         </div>
      <?php } ?>

   </div>

</header>
