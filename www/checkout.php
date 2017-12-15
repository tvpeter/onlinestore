<?php
$page_title = "Checkout";
include("includes/uheader.php");
if (!isset($_SESSION['uid'])) {
  redirect("user_login.php?msg=", "Login to check the cart");
}
?>
<body id="checkout">
  <div class="main">
    
     <div class="checkout-form">
       <form class="def-modal-form" action="receipt.php" method="post">
         <div class="total-cost">
           <h3 align="center">   <?php    if (isset($_GET['sum'])) {
               echo "$".$_GET['sum']." Total Purchase";    } ?> </h3> </div>
         <div class="cancel-icon close-form"></div>
         <label for="login-form" class="header"><h3>Checkout</h3></label>
         <input type="text"  class="text-field phone" placeholder="Phone Number" name="num" required="required">
          <input type="email"  class="text-field phone" placeholder="Email address" name="email" required="required">
         <input type="text" name="addy" class="text-field address" placeholder="Address" required="required">
         <input type="text" name="code" class="text-field post-code" placeholder="Post Code">
         <input type="submit" name="chkt" class="def-button checkout" value="Checkout">
       </form>
     </div>
   </div>
<?php include("includes/ufooter.php"); ?>
