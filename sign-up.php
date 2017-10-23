<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/socialnetwork/core/init2.php';
  
  include ("includes/head.php");
  
 
  if(isset($_GET['add'])){
    $nme2 = ((isset($_POST['nme2']))?sanitize($_POST['nme2']):'');
    $email2 = ((isset($_POST['email2']))?sanitize($_POST['email2']):'');
    $password2 = ((isset($_POST['password2']))?sanitize($_POST['password2']):'');
    $confirm2 = ((isset($_POST['confirm2']))?sanitize($_POST['confirm2']):'');
    $permissions2 = ((isset($_POST['permissions2']))?sanitize($_POST['permissions2']):'');
    $errors = array();
    if($_POST){
      $userQuery = $db->query("SELECT * FROM users2 ORDER BY full_name");
     $emailQuery2 = $db->query("SELECT * FROM users2 WHERE email = '$email2'");
     $emailCount2 = mysqli_num_rows($emailQuery2);
   

     if($emailCount2 != 0){
       $errors[] = 'That email is already exists in database Try again !';
     }

      $required = array('name2','email2','password2','confirm2','permissions2');
      foreach($required as $e){
        if(empty($_POST[$e])){
          $errors[] = 'You must fill out all feilds';
          break;
        }
      }
      if(strlen($password2) < 6){
        $errors[] = 'Your password must be 6 character long';
      }

      if($password2 != $confirm2){
        $errors[] = 'Your passwords do not match!';
      }

      if(!filter_var($email2, FILTER_VALIDATE_EMAIL)){
        $errors[] = 'You must enter a valid email !';
      }
       
      if(!empty($errors)){
        echo display_errors($errors);
      }else{
        // add user to database
        $hashed = password_hash($password2, PASSWORD_DEFAULT);
        $db->query("INSERT INTO users2 (full_name,email,password,permissions) VALUES ('$nme2','$email2','$hashed','$permissions2')");
        $_SESSION['success_flash'] = "User has been added to database";
        header('Location: sign-up.php');
      }
    }
  }
    ?>
    <h2 class="text-center">Sign UP</h2><hr>
    <form action="sign-up.php?add=1" method="post">
       <div class="form-group col-md-6">
         <label for="nme2">Full Name:</label>
         <input type="text" name="nme2" id="nme2" class="form-control" value="<?=$nme2;?>">
       </div>
       <div class="form-group col-md-6">
         <label for="email2">Email:</label>
         <input type="text" name="email2" id="email2" class="form-control" value="<?=$email2;?>">
       </div>
       <div class="form-group col-md-6">
         <label for="password2">Password:</label>
         <input type="password2" name="password2" id="password2" class="form-control" value="<?=$password2;?>">
       </div>
       <div class="form-group col-md-6">
         <label for="confirm2">Confirm Password:</label>
         <input type="password2" name="confirm2" id="confirm2" class="form-control" value="<?=$confirm2;?>">
       </div>
       <div class="form-group col-md-6">
         <label for="perimissions2">Permissions:</label>
         <select class="form-control" name="permissions2">
           <option value=""<?=(($permissions2 == '')?' selected':''); ?>></option>
           <option value="users"<?=(($permissions2 == 'users')?' selected':''); ?>>users</option>
           <option value="users,guest"<?=(($permissions2 == 'users,guest')?' selected':''); ?>>guest</option>
         </select>
       </div>
       <div class="form-group col-md-6 text-right" style="margin-top: 25px; ">
          <input type="submit" value="Add User" class="btn btn-primary">
       </div>
    </form>
  
  <?php  include ("includes/footer.php"); ?>