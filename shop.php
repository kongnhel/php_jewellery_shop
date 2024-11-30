<?php

@include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:shop.php');
// };
$user_id = $_SESSION['user_id'] ?? null; 
if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   if (!isset($user_id)) {
      header('location:login.php');
      exit(); 
  }
   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}
if (isset($_POST['add_to_cart'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   if (!isset($user_id)) {
       header('location:login.php');
       exit(); 
   }

   $select_product_qty = $conn->prepare("SELECT quantity FROM `products` WHERE id = ?");
   $select_product_qty->execute([$pid]);
   $product = $select_product_qty->fetch(PDO::FETCH_ASSOC);

   if ($product['quantity'] < $p_qty) {
       $message[] = 'Not enough stock available!';
   } else {
       $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
       $check_cart_numbers->execute([$p_name, $user_id]);

       if ($check_cart_numbers->rowCount() > 0) {
           $message[] = 'already added to cart!';
       } else {
           $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
           $check_wishlist_numbers->execute([$p_name, $user_id]);

           if ($check_wishlist_numbers->rowCount() > 0) {
               $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
               $delete_wishlist->execute([$p_name, $user_id]);
           }

           // Insert into the cart
           $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
           $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);

           // Update the product's quantity in the products table
         //   $new_qty = $product['quantity'] - $p_qty;

         //   if ($new_qty <= -1) {
         //       $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
         //       $delete_product->execute([$pid]);
         //       $message[] = 'Cart quantity updated, product removed from stock as it is out of quantity!';
         //    } else {
         //       $update_product_qty = $conn->prepare("UPDATE `products` SET quantity = ? WHERE id = ?");
         //       $update_product_qty->execute([$new_qty, $pid]);
         //   }

           $message[] = 'Product added to cart!';
       }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<!-- <section class="p-category">

   <a href="category.php?category=1"><i class="fa-solid fa-ring"></i> ring</a>
   <a href="category.php?category=2"><img src="./icon/neckless-icon.png" alt="pic" width="15px"> neckless</a>
   <a href="category.php?category=3"><img src="./icon/earring-icon.png" alt="pic" width="20px"> earring</a>
   <a href="category.php?category=4"><img src="./icon/watch-icon.png" alt="pic" width="20px"> watch</a>

</section> -->
<section class="products">

   <h1 class="title"><i class="fa-solid fa-ring"></i> All <span>Products</span></h1>

   <div class="box-container">
   <?php
   $select_products = $conn->prepare("SELECT * FROM `products` WHERE category IS NOT NULL AND category != '' AND quantity > 0");
   $select_products->execute();

   if($select_products->rowCount() > 0){
      while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
      <form action="" class="box" method="POST">
         <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
         <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <div class="name"><?= $fetch_products['name']; ?></div>
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
         <p style="font-size: 16px; margin:10px; color:green;">In stock: <?= $fetch_products['quantity']; ?></p>
         <input type="number" min="1" max="<?= $fetch_products['quantity']; ?>" value="1" name="p_qty" class="qty">
         <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
         <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      </form>
   <?php
      }
   } else {
      echo '<p class="empty">No products in stock!</p>';
   }
   ?>
   </div>

</section>

<section class="products">

   <h1 class="title"><i class="fa-solid fa-ring"></i> Out of <span>Stock</span></h1>

   <div class="box-container">
   <?php
   $select_out_of_stock = $conn->prepare("SELECT * FROM `products` WHERE quantity <= 0");
   $select_out_of_stock->execute();

   if($select_out_of_stock->rowCount() > 0){
      while($fetch_products = $select_out_of_stock->fetch(PDO::FETCH_ASSOC)){ 
   ?>
      <form action="" class="box" method="POST">
         <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
         <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <div class="name"><?= $fetch_products['name']; ?></div>
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
         <p class="out-of-stock" style="font-size: 25px; color:#333; font-weight:bold;">Out of Stock</p>
      </form>
   <?php
      }
   } else {
      echo '<p class="empty">No out of stock products!</p>';
   }
   ?>
   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>