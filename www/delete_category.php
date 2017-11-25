<?php
include('includes/db.php');
include('includes/functions.php');

if ($_GET['cat_id']) {
  $catId = $_GET['cat_id'];
}

deleteCategory($conn, $catId);

redirect('view_category.php', '');

 ?>
