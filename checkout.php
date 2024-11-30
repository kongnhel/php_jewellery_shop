<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['order'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method']; 
    $address = $_POST['flat'] . ' ' . $_POST['city'] . ' ' . $_POST['country'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products = []; 

    $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $cart_query->execute([$user_id]);
    if ($cart_query->rowCount() > 0) {
        while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item['name'] . ' ( ' . $cart_item['quantity'] . ' )';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;

            $update_stock = $conn->prepare("UPDATE `products` SET quantity = quantity - ? WHERE name = ?");
            $update_stock->execute([$cart_item['quantity'], $cart_item['name']]);
        }
    }

    $total_products = implode(', ', $cart_products);

    $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method_id = ? AND address = ? AND total_products = ? AND total_price = ?");
    $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

    if ($cart_total == 0) {
        $message[] = 'Your cart is empty';
    } elseif ($order_query->rowCount() > 0) {
        $message[] = 'Order placed already!';
    } else {
        $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method_id, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);
        $message[] = 'Order placed successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

    <?php
    $cart_grand_total = 0;
    $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart_items->execute([$user_id]);
    if ($select_cart_items->rowCount() > 0) {
        while ($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)) {
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
    ?>
    <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '$' . $fetch_cart_items['price'] . '/- x ' . $fetch_cart_items['quantity']; ?>)</span> </p>
    <?php
        }
    } else {
        echo '<p class="empty">Your cart is empty!</p>';
    }
    ?>
    <div class="grand-total">Grand total : <span>$<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders" >

    <form action="" method="POST">

        <h3>Place your order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Your name :</span>
                <input type="text" name="name" placeholder="Enter your name" class="box" required>
            </div>
            <div class="inputBox">
                <span>Your phone number :</span>
                <input type="number" name="number" placeholder="Enter your phone number" class="box" required>
            </div>
            <div class="inputBox">
                <span>Your email :</span>
                <input type="email" name="email" placeholder="Enter your email" class="box" required>
            </div>
            <div class="inputBox">
                <span>Payment method :</span>
                <select name="method" class="box" required>
                     <?php
                        $payment_methods = $conn->query("SELECT id, methods FROM payment");
                        while ($row = $payment_methods->fetch(PDO::FETCH_ASSOC)) {
                           echo "<option value='{$row['id']}' >{$row['methods']}</option>";
                        }
                     ?>

                </select>
            </div>
            <div class="inputBox">
                <span>Address :</span>
                <input type="text" name="flat" placeholder="e.g. flat number" class="box" required>
            </div>
            <div class="inputBox">
                <span>City :</span>
                <input type="text" name="city" placeholder="e.g. Phnom Penh" class="box" required>
            </div>
            <div class="inputBox">
                <span>Country :</span>
                <input type="text" name="country" placeholder="e.g. Cambodia" class="box" required>
            </div>
            <!-- <div class="inputBox">
                <span>Pin code :</span>
                <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
            </div> -->
        </div>

        <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1) ? '' : 'disabled'; ?>" value="Place order">

    </form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
