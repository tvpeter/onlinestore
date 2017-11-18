<?php
define("MAX_FILE_SIZE", "2097152");
$ext = ['image/jpeg', 'image/jpg', 'image/png'];
if(array_key_exists("save", $_POST)){
  print_r($_FILES);

$errors = [];

if(empty($_FILES['pic']['name'])){

  $errors [] = "Please select an image";
}

if ($_FILES['pic']['size']>MAX_FILE_SIZE) {
  $errors [] = "File too large. Maximum: ".MAX_FILE_SIZE;
}

if (!in_array($_FILES['pic']['type'], $ext)) {
$errors [] = " file format not known";

  }

  $rnd = rand(0000000000, 9999999999);
  $strip_name = str_replace(' ', '_', $_FILES['pic']['name']);
  $filename = $rnd.$strip_name;
  $destination = 'uploads/'.$filename;
if (empty($errors)) {
  move_uploaded_file($_FILES['pic']['tmp_name'], $destination);

}else {
  foreach ($errors as $err) {
    echo '<p>'.$err .'</p>';
  }
}



}

 ?>

<form class="" action="" method="post" enctype="multipart/form-data">
<p>Please upload a file</p>
<input type="file" name="pic" value="">
<input type="submit" name="save" value="submit">
</form>
