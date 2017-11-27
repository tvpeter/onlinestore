<?php session_start();
$page_title = "Login";
include("includes/header.php");
include("includes/db.php");
include("includes/functions.php");

$errors = array();

if (array_key_exists('register', $_POST )) {

if (empty($_POST['email'])) {
  $errors ['email'] = "Insert your email";
}

if (empty($_POST['password'])) {
  $errors ['password'] = "Insert your password";
}

if (empty($errors)) {
$clean = array_map('trim', $_POST);
$data = adminlogin($conn, $clean);
if ($data[0]) {
  $details = $data[1];
  //header("location:test.php");
  $_SESSION['aid'] = $details[0];
  $_SESSION['name'] = $details[1] .' '.$details[2];
  redirect("add_category.php", "");
}else {
  redirect("login.php", "Invalid login details");
}


}


}


?>
<div class="wrapper">
  <h1 id="register-label">Admin Login</h1>
  <hr>
  <form id="register"  action ="login.php" method ="POST">
    <div><?php $emerr = displayErrors($errors, 'email'); echo $emerr; ?>
      <label>email:</label>
      <input type="text" name="email" placeholder="email">
    </div>
    <div><?php $perr = displayErrors($errors, 'password'); echo $perr; ?>
      <label>password:</label>
      <input type="password" name="password" placeholder="password">
    </div>

    <input type="submit" name="register" value="login">
  </form>

  <h4 class="jumpto">Don't have an account? <a href="register.php">register</a></h4>
</div>
<?php include("includes/footer.php"); ?>
