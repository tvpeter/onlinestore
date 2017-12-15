<?php
$page_title = "Customer Login";
include("includes/uheader.php");
  $errors = array();
if (array_key_exists('submit', $_POST)) {

  if (empty($_POST['email'])) {
    $errors ['email'] = "Supply your email";
  }

if (empty($_POST['pword'])) {
  $errors ['pword'] = "Supply your password";
}

if (empty($errors)) {
  $wash = array_map('trim', $_POST);
$result = userLogin($conn, $wash);
if ($result[0]) {
  $userDetails = $result[1];
  $_SESSION['uid'] = $userDetails[0];
  $_SESSION['name'] = $userDetails[1]." ".$userDetails[2];
  redirect("index.php", " ");
}else {
  $errors ['email'] = "Wrong username/password";
}

}

}
 ?>
 <div class="main">
 <div class="login-form">

   <form class="def-modal-form" action="user_login.php" method ="POST">
     <div class="cancel-icon close-form"></div>
     <?php  if (isset($_GET['msg'])) {
       echo "<p class='global-error'>".$_GET['msg']."</p>";
     }?>
     <label for="login-form" class="header"><h3>Login</h3></label>
     <input type="text" class="text-field email" placeholder="Email or Username" name="email">
     <?php if (isset($errors['email'])) { echo '<p class=form-error>'.$errors['email'].'</p>';  } ?>
     <input type="password" class="text-field password" placeholder="Password" name="pword">
     <?php if (isset($errors['pword'])) { echo '<p class=form-error>'.$errors['pword'].'</p>';  } ?>
     <input type="submit" class="def-button login" value="Login" name="submit">
     <?php if (isset($errors['email'])) { ?>
     <p class="login-option"><a href="user_login.php">Dont have account? Register</a></p>
   <?php } ?>
   </form>
 </div>
</div>
 <?php include("includes/ufooter.php"); ?>
