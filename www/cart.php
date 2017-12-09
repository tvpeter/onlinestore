<?php
$page_title = "Cart";
include("includes/uheader.php");
?>
<body id="cart">
<div class="main">
  <?php   if (isset($_GET['msg'])) {
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
          while($row = $cart->fetch(PDO::FETCH_ASSOC)){
             ?>
       <tr>
         <td><div class="book-cover"  style="background: url('<?php echo $row['img_path'] ?>');
                background-size: cover;      background-position: center;
                background-repeat: no-repeat;"></div></td>
         <td><p class="book-price">$<?php echo $row['price']; ?></p></td>
         <td><p class="quantity"><?php echo $row['qty']; ?></p></td>
         <td><p class="total">$<?php echo $row['price']*$row['qty']; ?></p></td>
         <td>
           <?php if (isset($_POST['submit']) && !empty($_POST['qty'])) {
                $update = updateCart($conn, $_POST['qty'], $_POST['id']);
                if ($update) {
                  redirect("cart.php?msg=", "Product quantity updated Successfully");
                }
           } ?>
           <form class="update" method="post">
             <input type="hidden" name="id" value="<?php echo $row['cart_id']; ?>">
             <input type="number" class="text-field qty" min="1" name="qty" value="<?php echo $row['qty']; ?>">
             <input type="submit" class="def-button change-qty" value="Change Qty" name="submit">
           </form>
         </td>
         <td>
           <a href class="def-button remove-item">Remove Item</a>
         </td>
       </tr>
     <?php } ?>
    </tbody>
   </table>

   <div class="cart-table-actions">
     <button class="def-button previous">previous</button>
     <button class="def-button next">next</button>
     <div class="index">
       <a href="#"><p>1</p></a>
       <a href="#"><p>2</p></a>
       <a href="#"><p>3</p></a>
     </div>
     <a href="checkout.html"><button class="def-button checkout">Checkout</button></a>
   </div>

 </div>

<?php include("includes/ufooter.php"); ?>
