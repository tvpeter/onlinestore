<?php
$page_title = "Catalogue";
include("includes/uheader.php");
include("includes/db.php");
include("includes/functions.php");
?>

<div class="side-bar">
<div class="categories">
 <h3 class="header">Categories</h3>
 <ul class="category-list">
  <?php $rs = getCategories($conn); echo $rs; ?>
   </ul>
</div>
</div>
<!-- main content starts here -->
<div class="main">
<div class="main-book-list horizontal-book-list">
 <ul class="book-list">
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$125</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$90</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$250</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$50</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$250</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$50</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$125</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$90</p></div>
   </li>
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
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$250</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$50</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$125</p></div>
   </li>
   <li class="book">
     <a href="#"><div class="book-cover"></div></a>
     <div class="book-price"><p>$90</p></div>
   </li>
 </ul>
</div>

</div>
 <?php include("includes/ufooter.php"); ?>
