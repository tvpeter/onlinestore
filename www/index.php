  <?php
  $page_title = "Castle Books";
  include("includes/uheader.php");
  include("includes/db.php");
  include("includes/functions.php");
  $rs = displayTopSelling($conn);
  $img = $rs['img_path'];
  ?>

  <div class="main">

  <?php if ($rs): ?>
  <div class="book-display">
  <div class="display-book" style="background: url('<?php echo $img; ?>');
    background-size: cover; background-positive: center; background-repeat: no-repeat; ">
        </div>
  <div class="info">
  <h2 class="book-title"><?php echo $rs['title']; ?></h2>
   <h3 class="book-author">by <?php echo $rs['author']; ?></h3>
   <h3 class="book-price">$<?php echo $rs['price']; ?></h3>
   <form>
     <label for="book-amout">Amount</label>
     <input type="number" class="book-amount text-field">
     <input class="def-button add-to-cart" type="submit" name="" value="Add to cart">
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
