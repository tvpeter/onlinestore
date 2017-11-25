<?php
$page_title = "Admin Dashboard";

include("includes/db.php");
include("includes/functions.php");
include("includes/dashboard_header.php");
  $errors = [];

  if($_GET['book_id']) {
    $bookId = $_GET['book_id'];
  }

  define('MAX_FILE_SIZE', 2097152);
  $ext = ['image/jpeg', 'image/jpg', 'image/png'];
if (array_key_exists('update', $_POST)) {

  if(empty($_FILES['pic']['name'])){

    $errors ['pic'] = "Please select an image";
  }

  if ($_FILES['pic']['size']>MAX_FILE_SIZE) {
    $errors ['pic'] = "File too large. Maximum: ".MAX_FILE_SIZE;
  }

  if (!in_array($_FILES['pic']['type'], $ext)) {
    $errors ['pic'] = " file format not known";
  }

  if(empty($errors)) {
    $data = uploadFile($_FILES, 'pic', 'uploads/');

    if($data[0]) {
      $dest = $data[1];
    }

    updateImage($conn, $bookId, $dest);

    redirect('view_products.php', "");
  }
}

  ?>
<div class="wrapper">

<form class="" action="" method="post" enctype="multipart/form-data">

<div><?php  $info = displayErrors($errors, 'pic'); echo $info;       ?>
  <label for="">Product Image</label>
  <input type="file" name="pic">
</div>
			<input type="submit" name="update" value="Update">

      </form>
      </div>
      <?php include("includes/footer.php"); ?>
