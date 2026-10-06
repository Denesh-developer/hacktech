<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){

   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $update_payment = filter_var($update_payment);
   $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_orders->execute([$update_payment, $order_id]);
   $message[] = 'payment has been updated!';

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="icon" href="./images/icon.png">
</head >
<body style="background:black;">
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">Placed Orders</h1>

   <div class="box-container">

      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="background:black;">
         <p> User ID : <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> Placed On : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> Name : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> Country Code : <span><?= $fetch_orders['country_code']; ?></span> </p>
         <p> Number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> Address : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> Total Products : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> Total Price : <span>₹<?= $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Message : <span><?= $fetch_orders['message']; ?></span> </p>
         <p> Payment Method : <span><?= $fetch_orders['method']; ?></span> </p>
         <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <select name="update_payment" class="drop-down" style="text-transform:Capitalize">
               <option value="" selected disabled style="text-transform:Capitalize"><?= $fetch_orders['payment_status']; ?></option>
               <option value="pending">Pending</option>
               <option value="rejected">Rejected</option>
               <option value="completed">Completed</option>
            </select>
            <div class="flex-btn">
               <input type="submit" name="update_order" class="option-btn" value="Update">
               <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">Delete</a>
            </div>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>

   </div>

</section>












<script src="js/script.js"></script>

</body>
</html>