<?php
$page_title = "Customer Registration";
include("includes/uheader.php");

  $errors = array();
if (array_key_exists('submit', $_POST)) {

  if (empty($_POST['fname'])) {
    $errors ['fname'] = "Supply your first name";
  } elseif (!ctype_alpha($_POST['fname'])) {
    $errors ['fname'] = "Only letters are allowed";
  }

  if (empty($_POST['lname'])) {
    $errors ['lname'] = "Supply your lastname";
  }elseif (!ctype_alpha($_POST['lname'])) {
    $errors ['lname'] = "Only aphabetic characters are allowed";
  }

  if (empty($_POST['uname'])) {
    $errors ['uname'] = "choose your username";
  }

  if (empty($_POST['email'])) {
    $errors ['email'] = "Supply your email";
  }elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
   $errors ['email'] = "invalid email";
 }elseif (checkUserEmail($conn, $_POST['email'])) {
  $errors ['email'] = "supplied email already exits";
 }

if (empty($_POST['pword'])) {
  $errors ['pword'] = "Set password for your account";
}elseif (strlen($_POST['pword']) < 6 ) {
 $errors ['pword'] = "password must be atleast 6 characters";
}elseif (ctype_alnum($_POST['pword'])) {
  $errors ['pword'] = "password must contain special characters";
}
if (empty($_POST['cpword'])) {
  $errors ['cpword'] = "Confirm your password";
}elseif ($_POST['pword'] !== $_POST['cpword']) {
 $errors ['cpword'] = "Password does not match";
}

if (empty($errors)) {
  $wash = array_map('trim', $_POST);
$result = customerRegistration($conn, $wash);
if ($result) {
  redirect("registration.php?msg=", "Registration successful");
}
}


}

 ?>
   <div class="main">
     <div class="registration-form">

       <form class="def-modal-form" action ="registration.php" method="POST">
         <div class="cancel-icon close-form"></div>
         <label for="registration-form" class="header"><h3>User Registration</h3></label>
         <?php if (isset($_GET['msg'])){
           echo "<span class=scc>".$_GET['msg']."</span>";
         } ?>
         <div><?php $err = displayErrors($errors, 'fname'); echo $err;   ?>
         <input type="text" class="text-field first-name" placeholder="Firstname" name="fname"></div>
         <div><?php $err = displayErrors($errors, 'lname'); echo $err;   ?>
         <input type="text" class="text-field last-name" placeholder="Lastname" name="lname">
       </div>
       <div><?php  $err = displayErrors($errors, 'email'); echo $err;   ?>
         <input type="email" class="text-field email" placeholder="Email" name="email"></div>
         <div><?php  $err = displayErrors($errors, 'uname'); echo $err;   ?>
         <input type="text" class="text-field username" placeholder="Username" name="uname"></div>
         <div><?php  $err = displayErrors($errors, 'pword'); echo $err;   ?>
         <input type="password" class="text-field password" placeholder="Password" name="pword"></div>
         <div><?php  $err = displayErrors($errors, 'cpword'); echo $err;   ?>
         <input type="password" class="text-field confirm-password" placeholder="Confirm Password" name="cpword"></div>
         <input type="submit" class="def-button" value="Register" name="submit">
         <p class="login-option"><a href="user_login.php">Have an account already? Login</a></p>
       </form>
     </div>
   </div>
 <?php include("includes/ufooter.php"); ?>
