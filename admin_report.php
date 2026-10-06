

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Data Entry</title>
   <link rel="icon" href="./images/icon.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body style="background:black;">

   <header class="header" style="background:black;">

<div class="flex">

   <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>
   <nav class="navbar">
      <a href="admin_page.php">Home</a>
      <a href="admin_products.php">Products</a>
      <a href="admin_orders.php">Orders</a>
      <a href="admin_users.php">Users</a>
      <a href="admin_contacts.php">Messages</a>
      <a href="admin_report.php">Data Entry</a>
      <a href="report/index.php">Report</a>
   </nav>

   

</header>

<section class="contact">

   <h1 class="title">Daily Report Update</h1>

   <form action="insert.php" method="POST" style="background:black;">
      <input type="text" name="id" class="box" required placeholder="Enter your ID">
      <input type="text" name="customer_name" class="box" required placeholder="Enter your Customer Name">
      <select name="product" class="box">
         <option value="Raspberry Pi 5 8GB RAM">Raspberry Pi 5 8GB RAM</option>
         <option value="Bash Bunny">Bash Bunny</option>
         <option value="LAN Turtle">LAN Turtle</option>
         <option value="USB Killer Pro Kit">USB Killer Pro Kit</option>
         <option value="USB Rubber Ducky">USB Rubber Ducky</option>
         <option value="Wi-Fi Pineapple">Wi-Fi Pineapple</option>
      </select>
      <input type="text" name="total_amount" class="box" required placeholder="Enter your Total Amount">
      <input type="date" name="order_date" class="box" required>
      <input type="submit" value="Submit" class="btn">
   </form>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>