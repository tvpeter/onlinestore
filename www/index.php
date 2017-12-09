  <?php
  $page_title = "Castle Books";
  include("includes/uheader.php");

  $rs = displayTopSelling($conn);
  $img = $rs['img_path'];
 $bookId = $rs['books_id'];
  ?>

  <div class="main">
<?php   if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    echo "<p class='global-error'>$msg</p>";
  } ?>
  <?php if ($rs): ?>
  <div class="book-display">
  <div class="display-book" style="background: url('<?php echo $img; ?>');
    background-size: cover; background-positive: center; background-repeat: no-repeat; ">
        </div>
  <div class="info">
  <h2 class="book-title"><?php echo $rs['title']; ?></h2>
   <h3 class="book-author">by <?php echo $rs['author']; ?></h3>
   <h3 class="book-price">$<?php echo $rs['price']; ?></h3>
   <?php

   if (array_key_exists('submit', $_POST)) {
       $errors = [];
   if (empty($_POST['amount'])) {
     $errors ['amount'] = "Qty cannot be empty";
     echo "<p style='color:red'>You have not chosen any amount!</p>";
   }

   if (empty($errors)) {
     $amount = trim($_POST['amount']);
     $ddate = date("Y-m-d H:i:s");

     $insert = addCart($conn, $cid, $bookId, $amount, $ps, $ddate);
     if ($insert) {
       redirect("index.php?msg=", "Successfully added to cart. Click cart to checkout" );
     }
       }
   }

    ?>
   <form method="POST">
     <label for="book-amout">Qty</label>
     <input type="number" class="book-amount text-field" min="1" name="amount">
     <input class="def-button add-to-cart" type="submit" name="submit" value="Add to cart">
   </form>
  </div>
  </div><?php endif; ?>

  <div class="trending-books horizontal-book-list">
  <h3 class="header">Trending</h3>
  <ul class="book-list">
  <?php $result = displayTrending($conn); echo $result; ?>
  </ul>
  </div>


  <div class="recently-viewed-books horizontal-book-list">
  <h3 class="header">Recently Viewed</h3>
  <ul class="book-list">
   <div class="scroll-back"></div>
   <div class="scroll-front"></div>

  <?php $rv = recentlyViewed($conn); echo $rv; ?>
  </ul>
  </div>

  </div>

   <?php include("includes/ufooter.php"); ?>
