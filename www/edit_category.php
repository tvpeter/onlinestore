<?php
session_start();
$page_title = "Admin Dashboard";
include("includes/db.php");
include("includes/functions.php");
include("includes/dashboard_header.php");
checkLogin();
if ($_GET['cat_id']) {
  $catId = $_GET['cat_id'];
  }

$item = getCategoryById($conn, $catId);
$errors = array();

if (array_key_exists('edit', $_POST )) {

if (empty($_POST['cat_name'])) {
  $errors ['cat_name'] = "Insert the category name";
}


if (empty($errors)) {
$clean = array_map('trim', $_POST);
$clean['cat_id'] = $catId;

updateCategory($conn, $clean);

redirect('view_category.php', '');

}
}

?>
<div class="wrapper">
  <form id="register"  action ="" method ="POST">
    <div><?php $emerr = displayErrors($errors, 'cat_name'); echo $emerr; ?>
      <label>Edit Category:</label>
      <input type="text" name="cat_name" value="<?php echo $item[1]; ?>">
    </div>


    <input type="submit" name="edit" value="edit">
  </form>

</div>
<?php include("includes/footer.php"); ?>
