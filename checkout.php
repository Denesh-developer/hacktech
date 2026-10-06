<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name);
   $number = $_POST['number'];
   $number = filter_var($number);
   $email = $_POST['email'];
   $email = filter_var($email);
   $method = $_POST['method'];
   $method = filter_var($method);
   $address = 'flat no. '. $_POST['flat'] .' '. $_POST['street'] .' '. $_POST['city'] .' '. $_POST['state'] .' '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'order placed successfully!';
   }

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $countryCode = $_POST['countryCode'];


   // Prepare SQL query to insert data
   $sql = "INSERT INTO orders (country_code) VALUES ('$countryCode')";
   

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="icon" href="./images/icon.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      #message{
         color:red;
         font-size:14px;
         display:none;
         margin-bottom:5px;
      }
   </style>
   <script>
   function RestrictFirstZero(e)
        {
            if(src.Element.value.length == 0 && e.which == 48)
            {
                e.preventDefault();
                return false;
            }
        };
        function PreventFirstZero(event)
        {
            if(event.srcElement.value.charAt(0) == '0')
            {
                event.srcElement.value=event.srcElement.value.slice(1);
            }
        };
</script>
<script>
      function validateInput(event) {
      const inputField = event.target;
      const invalidChars = /[^a-zA-Z]/g;
      if (invalidChars.test(inputField.value)) {
        alert('Only alphabets are allowed.');
        inputField.value = inputField.value.replace(invalidChars, '');
      }
    }
</script>
</head>
<body style="background:black;">
   
<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '$'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">Grand Total : <span>$<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">

<form action="checkout.php" method="POST" style="background:black;">

<h3>Place your Order</h3>

<div class="flex">
   <div class="inputBox">
      <span>Your Name :</span>
      <input type="text" name="name"  placeholder="Enter your Name" class="box" id="alphaInput" oninput="validateInput(event)" required >
   </div>
   <div class="inputBox">          <!--  -->
      <span>Your Number :</span>
      <select id="countryCode" class="box" name="countryCode" required>
            <option value="+1">United States (+1)</option>
            <option value="+44">United Kingdom (+44)</option>
            <option value="+91">India (+91)</option>
            <!-- Add more country codes as needed -->
        </select> 
   </div>
   <div class="inputBox">          <!--  -->
      <span>Your Number :</span>
      <input type="number" name="number" placeholder="Enter your Number" class="box"  required  onkeyup="PreventFirstZero(event)" >
   </div>
   <div class="inputBox">
      <span>Your Email :</span>
      <input type="email" name="email" placeholder="Enter your Email" class="box" required>
   </div>
   <div class="inputBox">
      <span>Payment Method :</span>
      <select name="method" class="box" required>
         <option value="Cash on Delivery">Cash on Delivery</option>
      </select>
   </div>
   <div class="inputBox">
      <span>Address Line 01 :</span>
      <input type="text" name="flat" placeholder="e.g. Flat Number" class="box" required>
   </div>
   <div class="inputBox">
      <span>Address Line 02 :</span>
      <input type="text" name="street" placeholder="e.g. Street Name" class="box" id="alphaInput" oninput="validateInput(event)" required>
   </div>
   <div class="inputBox">
      <span>City :</span>
      <input type="text" name="city" placeholder="e.g. Ranipet" class="box" id="alphaInput" oninput="validateInput(event)" required>
   </div>
   <div class="inputBox">
      <span>State :</span>
      <input type="text" name="state" placeholder="e.g. TamilNadu" class="box" id="alphaInput" oninput="validateInput(event)" required>
   </div>
   <div class="inputBox">
      <span>Country :</span>
      <input type="text" name="country" placeholder="e.g. India" class="box" id="alphaInput" oninput="validateInput(event)" required>
   </div>
   <div class="inputBox">
      <span>Pincode :</span>
      <input type="number" min="0" name="pin_code" placeholder="e.g. 604407" class="box" required>
   </div>
</div>

<input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="Place Order">

</form>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>