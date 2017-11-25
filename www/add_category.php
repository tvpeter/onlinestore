<?php
session_start();
$page_title = "Admin Dashboard";
include("includes/db.php");
include("includes/functions.php");
include("includes/dashboard_header.php");
checkLogin();

$errors = array();

if (array_key_exists('add', $_POST )) {

if (empty($_POST['cat_name'])) {
  $errors ['cat_name'] = "Insert the category name";
}


if (empty($errors)) {
$clean = array_map('trim', $_POST);
addCategory($conn, $clean);
redirect("view_category.php", "");
}


}



?>
<div class="wrapper">
  <form id="register"  action ="add_category.php" method ="POST">
    <div><?php $emerr = displayErrors($errors, 'cat_name'); echo $emerr; ?>
      <label>Category:</label>
      <input type="text" name="cat_name" placeholder="Category name">
    </div>


    <input type="submit" name="add" value="Add">
  </form>

</div>
<?php include("includes/footer.php"); ?>
