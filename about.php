<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
<style>
   .about .row{
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap:1.5rem;
}

.about .row .image{
   flex:1 1 40rem;
}

.about .row .image img{
   width: 80%;
   border-radius:50%;
}

.about .row .content{
   flex:1 1 40rem;
}

.about .row .content h3{
   font-size: 3rem;
   color:var(--black);
}

.about .row .content p{
   line-height: 2;
   font-size: 1.5rem;
   color:var(--light-color);
   padding:1rem 0;
}

.about .row .content .btn{
   display: inline-block;
   width: auto;
}

</style>
</head>
<body style="background:black;">
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="denesh.jpg" alt="">
      </div>

      <div class="content">
         <h3>Developer's Message:</h3>
         <p>Hey There ! I'm Denesh. A Student of BCA from Adhiparasakthi College of Arts and Science [Batch : 2022] . I love designing websites and exploring new things. Learning new things is my hobby.</p>
         <a href="https://wa.me/+919342372731?text=Hello%20Devil,%20I%20want%20to%20know%20about%20your%20gadgets.%20%20Can%20you%20help%20me!" class="btn" target="_blank">Contact Us</a>
      </div>

   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>