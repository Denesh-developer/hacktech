<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">
<style>
    *{
        background:black;
    }
</style>
<header class="header" style="background:black;">

<div class="flex">

   <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

   <nav class="navbar">
      <a href="admin_page.php">Home</a>
      <a href="admin_products.php">Products</a>
      <a href="admin_orders.php">Orders</a>
      <a href="admin_users.php">Users</a>
      <a href="admin_contacts.php">Messages</a>
      <a href="admin_report.php">Report</a>
   </nav>

   

</header>
<?php

@include 'config.php';

$conn = mysqli_connect("localhost", "root", "", "hacktech");
        
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " 
        . mysqli_connect_error());
}

// Taking all 5 values from the form data(input)
$id =  $_REQUEST['id'];
$customer_name =  $_REQUEST['customer_name'];
$product =  $_REQUEST['product'];
$total_amount =  $_REQUEST['total_amount'];
$order_date =  $_REQUEST['order_date'];
// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO report  VALUES ('$id', 
    '$customer_name','$product','$total_amount','$order_date')";

if(mysqli_query($conn, $sql)){

} else{
    echo "ERROR: Hush! Sorry $sql. " 
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
<?php
require_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
	</head>
	<body background="black">
    <center>   <h1>Successfully Data Entered</h1></center>
<center><button style="font-size:40px;"><a href="admin_page.php">BACK TO HOME</a></button></center>
	</body>
</html>

