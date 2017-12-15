<?php
include('includes/db.php');
include('includes/functions.php');

if ($_GET['id']) {
  $catId = $_GET['id'];
}

deleteFromCart($conn, $catId);

redirect('cart.php', '');

 ?>
