<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/socialnetwork/core/init2.php';
  include ("includes/head.php");

    
   $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
   $email = trim($email);
   $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
   $password = trim($password);
   $errors = array();
  ?>


<style>
    body{
      background-image:url("/socialnetwork/images/headerlogo/pnh.png");
      background-size: 100vw 100vh;
      background-attachment: fixed;
      background-image-opacity: 0.9;
    }
  </style>
   <div id="login-form2">
     <div>

           <?php
     if($_POST){
       //form validation
       if(empty($_POST['email']) || empty($_POST['password'])){
         $errors[] = 'You must provide email and password.';
       }

       // validate email
       if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
         $errors[] = 'You must enter a valid email.';
       }

       // password is more than 6 character
       if(strlen($password) < 6){
         $errors[] = 'Passoword must be at least 6 characters.';
       }

       // check if email is exists in the database
       $query = $db->query("SELECT * FROM users2 WHERE email = '$email'");
       $user = mysqli_fetch_assoc($query);
       $userCount = mysqli_num_rows($query);
       if($userCount < 1){
         $errors[] = 'That email dosent exist in database';
       }

       if(!password_verify($password, $user['password'])){
         $errors[] = 'the password does not match our records. please try again.';
       }


       //check for errors
       if(!empty($errors)){
         echo display_errors($errors);
       }else{
         // log user in
         $user_id = $user['id'];
         login($user_id);
       }
     }
   ?>
        
       </div>
     <h2 class="text-center">Login</h2><hr>
       <form action="login.php" method="post">
         <div class="form-group">
           <label for="email">Email:</label>
           <input type="text" name="email" id="email" class="form-control" value="">
         </div>
         <div class="form-group">
           <label for="password">Password:</label>
           <input type="password" name="password" id="password" class="form-control" value="">
         </div>
         <p class="text-left"><a href="forgot-password.php" alt="home">Forgot Password</a></p>
         <div class="form-group">
           <input type="submit" value="login" class="btn btn-primary">
         </div>
       </form>
       <p class="text-right"><a href="sign-up.php">SignUP</a></p>
     </div>

  <?php include("includes/footer.php"); ?>