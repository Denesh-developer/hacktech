<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name);
   $email = $_POST['email'];
   $email = filter_var($email);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass);

   $image = $_FILES['image']['name'];
   $image = filter_var($image);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login.php');
            }
         }

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
   <title>Register</title>

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
   
<section class="form-container">

   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Register Now</h3>
      <input type="text" name="name" class="box" placeholder="Enter your Name" required>
      <input type="email" name="email" class="box" placeholder="Enter your Email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your Password" required>
      <input type="password" name="cpass" class="box" placeholder="Confirm your Password" required>
  <!--     <select name="user_type" id="" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select> -->
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Register Now" class="btn" name="submit">
      <p>Already Have an Account? <a href="login.php">Login Now</a></p>
   </form>

</section>


</body>
</html>