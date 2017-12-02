<?php
$page_title = "Catalogue";
include("includes/uheader.php");


if (isset($_GET['nm'])) {
  $catId = $_GET['nm'];
  $show = displayByCategory($conn, $catId);
}else{
  $show = displayByCategory($conn);
}
?>

<div class="side-bar">
  <div class="categories">
    <h3 class="header">Categories</h3>
    <ul class="category-list">
      <?php $rs = getCategories($conn); echo $rs; ?>
    </ul>
  </div>
</div>

<div class="main">
  <div class="main-book-list horizontal-book-list">
    <ul class="book-list">
      <?php
      echo $show; ?>
    </ul>
  </ul>
  <div class="actions">
    <button class="def-button previous">Previous</button>
    <button class="def-button next">Next</button>
  </div>
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
