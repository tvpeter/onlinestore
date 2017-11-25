
<?php
session_start();
$page_title = "View Products";
include("includes/db.php");
include("includes/functions.php");
include("includes/dashboard_header.php");
checkLogin();

?>
<div class="wrapper">
  <div id="stream">
    <table id="tab">
      <thead>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Price</th>
          <th>Category</th>
          <th>Image</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>

      <?php
      $products = viewProducts($conn);
      echo $products;
       ?>
            </tbody>
    </table>
  </div>

  <div class="paginated">
    <a href="#">1</a>
    <a href="#">2</a>
    <span>3</span>
    <a href="#">2</a>
  </div>
</div>
<?php include("includes/footer.php"); ?>
