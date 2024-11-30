<?php

@include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/about.png" alt="">
         <h3>why choose us?</h3>
         <p>We source only the finest materials, ensuring that each item is not only beautiful but also enduring. Our designs range from timeless classics to modern masterpieces, catering to all tastes and occasions.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

      <div class="box">
         <img src="images/shop.png" alt="">
         <h3>what we provide?</h3>
         <p> we offer more than just jewelry—we provide a journey into elegance and timeless beauty. Our selection includes:</p>
         <a href="shop.php" class="btn">our shop</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">clients reivews</h1>

   <div class="box-container">

      <div class="box">
         <img src="./uploaded_img/lyhou.jpg" alt="">
         <p>"I recently purchased an engagement ring from this jewelry shop, and I couldn't be happier! The quality of the diamond is stunning, and the customer service was exceptional. They helped me choose the perfect ring within my budget and made the entire experience so special. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>lyhou</h3>
      </div>

      <div class="box">
         <img src="./uploaded_img/vimean.jpg" alt="">
         <p>"I recently purchased an engagement ring from this jewelry shop, and I couldn't be happier! The quality of the diamond is stunning, and the customer service was exceptional. They helped me choose the perfect ring within my budget and made the entire experience so special. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Vimean</h3>
      </div>

      <div class="box">
         <img src="./uploaded_img/photo_2024-08-13_16-36-44.jpg" alt="">
         <p>"I recently purchased an engagement ring from this jewelry shop, and I couldn't be happier! The quality of the diamond is stunning, and the customer service was exceptional. They helped me choose the perfect ring within my budget and made the entire experience so special. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>sophong</h3>
      </div>

      <div class="box">
         <img src="./uploaded_img/seyha.jpg" alt="">
         <p>"I recently purchased an engagement ring from this jewelry shop, and I couldn't be happier! The quality of the diamond is stunning, and the customer service was exceptional. They helped me choose the perfect ring within my budget and made the entire experience so special. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Mr.seyha</h3>
      </div>

      <div class="box">
         <img src="./uploaded_img/rom.jpg" alt="">
         <p>"I recently purchased an engagement ring from this jewelry shop, and I couldn't be happier! The quality of the diamond is stunning, and the customer service was exceptional. They helped me choose the perfect ring within my budget and made the entire experience so special. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Phirom</h3>
      </div>

      <div class="box">
         <img src="images/pic-6.png" alt="">
         <p>"I recently purchased an engagement ring from this jewelry shop, and I couldn't be happier! The quality of the diamond is stunning, and the customer service was exceptional. They helped me choose the perfect ring within my budget and made the entire experience so special. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>