<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass);

   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">
   <link rel="icon" href="./images/icon.png">
   <style>
      .form-container{
   min-height: 100vh;
   display: flex;
   align-items: center;
   justify-content: center;
   color:white;
}

.form-container form{
   width: 50rem;
   background-color: rgba(0,0,0,0.5);
   border-radius: .5rem;
   box-shadow: inset -5px,-5px,rgba(0,0,0,0.5);
   border-color:white;
   text-align: center;
   padding:2rem;
   color:white;
}

.form-container form h3{
   font-size: 3rem;
   color:#00fc69;
   margin-bottom: 1rem;
}

.form-container form .box{
   width: 100%;
   margin:1rem 0;
   border-radius: .5rem;
   border:var(--border);
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:white;
   background-color: rgba(0,0,0,0.5);
}
input::placeholder{
   color:white;
}
.form-container form p{
   margin-top: 2rem;
   font-size: 2.2rem;
   color:white;
}

.form-container form p a{
   color:#0f0;
}

.form-container form p a:hover{
   text-decoration: underline;
}
   </style>
</head>
<body style="background:url('log.jpg'); background-size: cover;  ">

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
   
<section class="form-container" >

   <form action="" method="POST">
      <h3>Login Now</h3>
      <input type="email" name="email" class="box" placeholder="Enter your Email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your Password" required>
      <input type="submit" value="Login Now" class="btn" name="submit">
      <p>Don't Have an Account? <a href="register.php">Register Now</a></p>
   </form>

</section>


</body>
</html>