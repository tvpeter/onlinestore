<?php
$page_title = "Checkout";
include("includes/uheader.php");
if (!isset($_SESSION['uid'])) {
  redirect("user_login.php?msg=", "Login to check the cart");
}else {
  $cid = $_SESSION['uid'];
}
if (isset($_GET['sum'])) {
  $sum = $_GET['sum'];    }else {
      redirect("index.php?msg=", "Your cart is empty");
    }
?>
<body id="checkout">
  <div class="main">

     <div class="checkout-form">
       <?php
        $errors = [];
   if (array_key_exists("chkt", $_POST)) {

     if (empty($_POST['num'])) {
       $errors['num'] = "Supply your phone number";
     }
     if (empty($_POST['addy'])) {
       $errors ['addy'] = "Supply your address";
     }

     if (empty($errors)) {
       $clean = array_map('trim', $_POST);
        $ddate = date("Y-m-d H:i:s"); $ps = "Unpaid"; $pts = "Paid";
        $updated = checkOut($conn, $cid, $clean, $ddate, $ps, $pts);
        if ($updated) {
          header("location:receipt.php?d=$ddate");
        }
     }

   }


        ?>
       <form class="def-modal-form" action="" method="post">
         <div class="total-cost">
           <h3 align="center">   <?php echo "$".$sum." TOTAL PURCHASE";
           ?> </h3> </div>
         <div class="cancel-icon close-form"></div>
         <label for="login-form" class="header"><h3>Checkout</h3></label>
         <?php   $info = displayErrors($errors, 'num'); echo $info;   ?>
         <input type="text"  class="text-field phone" placeholder="Phone Number" name="num">
            <?php   $ady = displayErrors($errors, 'addy'); echo $ady;   ?>
          <input type="text" name="addy" class="text-field address" placeholder="Address">
         <input type="text" name="code" class="text-field post-code" placeholder="Post Code">
         <input type="submit" name="chkt" class="def-button checkout" value="Checkout">
       </form>
     </div>
   </div>
<?php include("includes/ufooter.php"); ?>
