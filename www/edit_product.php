<?php
$page_title = "Edit product";

include("includes/db.php");
include("includes/functions.php");
include("includes/dashboard_header.php");
  $errors = [];

if ($_GET['book_id']) {
  $bookId = $_GET['book_id'];
}
$item = getProductById($conn, $bookId);
$category = getCategoryById($conn, $item[5]);

if (array_key_exists('edit', $_POST)) {
  if (empty($_POST['title'])) {
    $errors ['title'] = " supply the title";
  }
  if (empty($_POST['author'])) {
    $errors ['author'] = "Insert the author";
  }
  if (empty($_POST['price'])) {
    $errors ['price'] = "input the price";
  }


    if (empty($_POST['year'])) {
      $errors ['year'] = "enter publication year";
    }

  if (empty($_POST['cat'])) {
    $errors ['cat'] = "select the category";
  }


  if (empty($errors)) {

    $clean = array_map('trim', $_POST);
    $clean ['id'] = $bookId;

    updateProduct($conn, $clean);
    redirect('view_products.php', '');


}
}
?>
<div class="wrapper">
		<h1 id="register-label">EDIT PRODUCT</h1>
		<hr>
		<form id="register"  action ="" method ="POST" enctype="multipart/form-data">
			<div>
        <?php //if (isset($errors['fname'])) {  echo '<span class=err>'.$errors['fname'].'</span>';  }
          $info = displayErrors($errors, 'title'); echo $info;         ?>
				<label>Title:</label>
				<input type="text" name="title" value="<?php echo $item[1]; ?> ">
			</div>
			<div>
          <?php  $info = displayErrors($errors, 'author'); echo $info;       ?>
				<label>Author:</label>
				<input type="text" name="author" value="<?php echo $item[2]; ?> ">
			</div>
			<div>
          <?php  $info = displayErrors($errors, 'price'); echo $info;       ?>
				<label>Price:</label>
				<input type="text" name="price" value="<?php echo $item[3]; ?> ">
			</div>

			<div>    <?php  $info = displayErrors($errors, 'year'); echo $info;       ?>
				<label>Year:</label>
				<input type="text" name="year" value="<?php echo $item[4]; ?> " />
			</div>


      <div > <?php  $info = displayErrors($errors, 'cat'); echo $info;       ?>
      <label for="">Category Id</label>
      <select  name="cat">
        <option value=""><?php echo $category[1]; ?></option>
        <?php
        $cats = fetchCategory($conn, $category[1]);
        echo $cats;
         ?>
      </select>
</div>


			<input type="submit" name="edit" value="register">
		</form>


      <h4 class="jumpto">Edit Product Image? <a href="edit_image.php?book_id=<?php echo $bookId; ?>">Edit Image</a></h4>
	</div>
<?php include("includes/footer.php"); ?>
