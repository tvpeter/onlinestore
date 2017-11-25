<?php
$page_title = "Admin Dashboard";

include("includes/db.php");
include("includes/functions.php");
include("includes/dashboard_header.php");
  $errors = [];

  define('MAX_FILE_SIZE', 2097152);
$ext = ['image/jpeg', 'image/jpg', 'image/png'];
  $flag = ['Top Selling', 'Trending', 'Receently Viewed'];
if (array_key_exists('add', $_POST)) {
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
  if (empty($_POST['flag'])) {
    $errors ['flag'] = "select the flag";
  }

  if(empty($_FILES['pic']['name'])){

    $errors ['pic'] = "Please select an image";
  }

  $picname = $_FILES['pic']['name'];

  if ($_FILES['pic']['size']>MAX_FILE_SIZE) {
    $errors ['pic'] = "File too large. Maximum: ".MAX_FILE_SIZE;
  }

  if (!in_array($_FILES['pic']['type'], $ext)) {
  $errors ['pic'] = " file format not known";

    }


  if (empty($errors)) {


$data = uploadFile($_FILES, 'pic', "uploads/");

if ($data[0]) {
  $dest = $data[1];
}

  $clean = array_map('trim', $_POST);
  $clean['imgPath'] = $dest;
    addProduct($conn, $clean);
    redirect('view_category.php', '');
}
}
?>
<div class="wrapper">
		<h1 id="register-label">ADD PRODUCT</h1>
		<hr>
		<form id="register"  action ="add_products.php" method ="POST" enctype="multipart/form-data">
			<div>
        <?php //if (isset($errors['fname'])) {  echo '<span class=err>'.$errors['fname'].'</span>';  }
          $info = displayErrors($errors, 'title'); echo $info;         ?>
				<label>Title:</label>
				<input type="text" name="title" placeholder="title">
			</div>
			<div>
          <?php  $info = displayErrors($errors, 'author'); echo $info;       ?>
				<label>Author:</label>
				<input type="text" name="author" placeholder="author">
			</div>
			<div>
          <?php  $info = displayErrors($errors, 'price'); echo $info;       ?>
				<label>Price:</label>
				<input type="text" name="price" placeholder="price">
			</div>

			<div>    <?php  $info = displayErrors($errors, 'year'); echo $info;       ?>
				<label>Year:</label>
				<input type="text" name="year" placeholder="year">
			</div>


      <div > <?php  $info = displayErrors($errors, 'cat'); echo $info;       ?>
      <label for="">Category Id</label>
      <select  name="cat">
        <option value="">Categories</option>
        <?php
        $cats = fetchCategory($conn);
        echo $cats;
         ?>
      </select>
</div>


<div> <?php  $info = displayErrors($errors, 'flag'); echo $info;       ?>
  <label for="">Flag</label>
  <select class="" name="flag">
    <option value="">Flag</option>
    <?php
foreach ($flag as $fl) {?>
<option value="<?php echo $fl ?>"><?php echo $fl ?></option>
  <?php
}
     ?>
  </select>
</div>
<div><?php  $info = displayErrors($errors, 'pic'); echo $info;       ?>
  <label for="">Product Image</label>
  <input type="file" name="pic">
</div>
			<input type="submit" name="add" value="register">
		</form>


	</div>
<?php include("includes/footer.php"); ?>
