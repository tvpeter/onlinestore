<?php
$page_title = "Cart";
include("includes/uheader.php");
?>
<body id="cart">
<div class="main">
  <?php
  if (!isset($_SESSION['uid'])) {
    redirect("user_login.php?msg=", "Login to check the cart");
  }
  if (isset($_GET['msg'])) {
      $msg = $_GET['msg'];
      echo "<p class='global-error'>$msg</p>";
    } ?>
   <table class="cart-table">
     <thead>
       <tr>
         <th><h3>Item</h3></th>
         <th><h3>Price</h3></th>
         <th><h3>Quantity</h3></th>
         <th><h3>Total</h3></th>
         <th><h3>Update</h3></th>
         <th><h3>Remove</h3></th>
       </tr>
     </thead>
     <tbody>
       <?php $cart = cartContent($conn, $cid, $ps);
          $sum = 0;
          while($row = $cart->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $prd = $price*$qty;
            $sum = $sum + $prd;
             ?>
       <tr>
         <td><div class="book-cover"  style="background: url('<?php echo $img_path ?>');
                background-size: cover;      background-position: center;
                background-repeat: no-repeat;"></div></td>
         <td><p class="book-price">$<?php echo $price; ?></p></td>
         <td><p class="quantity"><?php echo $qty; ?></p></td>
         <td><p class="total">$<?php echo $prd; ?></p></td>
         <td>
           <?php  $_SESSION['sum'] = $sum;  
           if (isset($_POST['submit']) && !empty($_POST['qty'])) {
                $update = updateCart($conn, $_POST['qty'], $_POST['id']);
                if ($update) {
                  redirect("cart.php?msg=", "Product quantity updated Successfully");
                }
           } ?>
           <form class="update" method="post">
             <input type="hidden" name="id" value="<?php echo $cart_id; ?>">
             <input type="number" class="text-field qty" min="1" name="qty" value="<?php echo $qty; ?>">
             <input type="submit" class="def-button change-qty" value="Change Qty" name="submit">
           </form>
         </td>
         <td>
           <a href="deletefromcart.php?id=<?php echo $cart_id; ?>" class="def-button remove-item">Remove Item</a>
         </td>
       </tr>
     <?php } ?>
    </tbody>
   </table>

   <div class="cart-table-actions">
     <button class="def-button previous">Previous</button>
     <button class="def-button next">next</button>
     <div class="index">
       <a href="#"><p>1</p></a>
       <a href="#"><p>2</p></a>
       <a href="#"><p>3</p></a>
     </div>
     <a href="checkout.php?sum=<?php echo $sum ?>"><button class="def-button checkout">Checkout</button></a>
   </div>

 </div>

<?php include("includes/ufooter.php"); ?>
