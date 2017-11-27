<?php

function uploadFile($files, $name, $loc)
{
$result = [];
$rnd = rand(0000000000, 9999999999);
  $strip_name = str_replace(' ', '_', $files[$name]['name']);
  $filename = $rnd.$strip_name;
  $destination = $loc.$filename;

  if (!move_uploaded_file($files[$name]['tmp_name'], $destination)) {
    $result [] = false;
  }else {    $result [] = true;
    $result [] = $destination;
  }
  return $result;}


function doAdminRegister($dbconn, $input)
{
  $hash = password_hash($input['password'], PASSWORD_BCRYPT);
  $stmt = $dbconn -> prepare("INSERT INTO admin (firstName, lastName, email, hash) VALUES (:f, :l, :e, :h)");
  $data = [
    ":f" => $input['fname'],
    ":l" => $input['lname'],
    ":e" => $input['email'],
    ":h" => $hash
  ];
    $stmt ->execute($data);
}

function doesEmailExit($dbconn, $email)
{
  $result = false;
  $stmt = $dbconn->prepare("SELECT email FROM admin WHERE email= :e");
  $stmt ->bindParam(":e", $email);
  $stmt ->execute();
  $count = $stmt ->rowCount();
  if ($count > 0) {
    $result = true;
  }
  return $result;
}

function displayErrors($err, $name){
  $result = "";
  if (isset($err[$name])) {
    $result = "<span class=err>".$err[$name]."</span>";
  }
  return $result;
}

function adminlogin($dbconn, $input)
{
 $result = [];
  $stmt = $dbconn ->prepare("SELECT * FROM admin WHERE email = :email");
  $stmt ->bindParam(':email', $input['email']);
  $stmt ->execute();
  $count = $stmt->rowCount();
  $row = $stmt->fetch(PDO::FETCH_BOTH);

  if ($count != 1 || !password_verify($input['password'], $row['hash'])) {
    $result [] = false;
  }else {
    $result [] = true;
    $result [] = $row;
  }
  return $result;

}

function redirect($loc, $msg)
{
  header("location:".$loc.$msg);
}

function addCategory($dbconn, $input)
{
  $stmt = $dbconn ->prepare("INSERT INTO category (category_name) VALUES (:catName)");
  $stmt ->bindParam(':catName', $input['cat_name']);
  $stmt -> execute();
}


function viewCategory($dbconn){
  $result = "";

  $stmt = $dbconn->prepare("SELECT * FROM category");
  $stmt ->execute();
  while($row = $stmt ->fetch(PDO::FETCH_BOTH)){
    $result .= '<tr><td>'.$row[0].'</td>';
    $result .= '<td>'.$row[1].'</td>';
    $result .= '<td><a href="edit_category.php?cat_id='.$row[0].'">edit</a></td>';
    $result .= '<td><a href="delete_category.php?cat_id='.$row[0].'">delete</a></td></tr>';
  }
  return $result;
}

function curNav($page){
  $curPage = basename($_SERVER['SCRIPT_NAME']);
  if ($curPage == $page) {
    echo 'class="selected"';
  }
}

function getCategoryById($dbconn, $id)
{
  $result = " ";
  $stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id= :catId");
  $stmt ->bindParam(':catId', $id);
  $stmt ->execute();
  $result = $stmt->fetch(PDO::FETCH_BOTH);
  return $result;
}

function updateCategory($dbconn, $input){
  $stmt = $dbconn->prepare("UPDATE category SET category_name =:cat_name WHERE  category_id =:cat_id");
  $data =[
    ':cat_name'=> $input['cat_name'],
    ':cat_id'=> $input['cat_id']
  ];
  $stmt->execute($data);
}

function deleteCategory($dbconn, $id){
  $stmt = $dbconn->prepare("DELETE FROM category WHERE category_id =:id");
  $stmt ->bindParam(':id', $id);
  $stmt ->execute();
}

function checkLogin(){
  if (!isset($_SESSION['aid'])) {
    redirect('login.php', "");
      }
}

function fetchCategory($dbconn, $val=null){
  $result = "";
  $stmt = $dbconn ->prepare("SELECT * FROM category");
  $stmt->execute();
  while($row = $stmt->fetch(PDO::FETCH_BOTH)){
    if ($row[1] == $val) {
      continue;
    }
        $result .= '<option value="'.$row[0].'">'.$row[1].'</option>';
  }
  return $result;
}

function addProduct($dbconn, $input){
  $stmt = $dbconn->prepare("INSERT INTO books (title, author, price, publication_year, cat_id, flag, img_path) VALUES(:t, :a, :p, :pub, :catId, :fl, :im) ");
  $data = [
    ":t" => $input['title'],
    ":a" => $input['author'],
    ":p" => $input['price'],
    ":pub" => $input['year'],
    ":catId" =>$input['cat'],
    ":fl"=>$input['flag'],
    ":im" => $input['imgPath']
  ];
  $stmt ->execute($data);
}

function viewProducts($dbconn){
  $result = '';
  $stmt =$dbconn->prepare("SELECT * FROM books");
  $stmt ->execute();
  while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
    $result .= '<tr><td>'.$row[1].'</td>';
        $result .= '<td>'.$row[2].'</td>';
        $result .= '<td>'.$row[3].'</td>';
        $result .= '<td>'.$row[5].'</td>';
        $result .= '<td><img src="'.$row[7].'" height=50 width=50 "></td>';
          $result .= '<td><a href="edit_product.php?book_id='.$row[0].'">edit </a></td>';
          $result .= '<td><a href="delete_product.php?book_id='.$row[0].'">delete </a></td></tr>';
  }
  return $result;
}

function getProductById($dbconn, $id){
  $result = '';
  $stmt = $dbconn->prepare("SELECT * FROM books WHERE books_id=:id");
  $stmt->bindParam(":id", $id);
  $stmt ->execute();
  $result = $stmt->fetch(PDO::FETCH_BOTH);
  return $result;
}

function updateProduct($dbconn, $input){
  $stmt = $dbconn->prepare("UPDATE books SET title=:t, author=:a, price= :p, publication_year=:pub, cat_id=:cid WHERE books_id=:bid");
  $data = [
    ":t" => $input['title'],
    ":a" => $input['author'],
    ":p" => $input['price'],
    ":pub" => $input['year'],
    ":cid" => $input['cat'],
    ":bid" =>$input['id']
  ];
  $stmt ->execute($data);
}

 function updateImage($dbconn, $id, $location) {

   $stmt = $dbconn->prepare("UPDATE books SET img_path = :img WHERE books_id = :bid");

   $data = [
      ":img" => $location,
      ":bid" => $id
   ];

   $stmt->execute($data);
 }

 function checkUserEmail($cn, $email){
   $rs = false;
   $stmt = $cn->prepare("SELECT email FROM users WHERE email=:e");
   $stmt ->bindParam(":e", $email);
   $stmt ->execute();
   $count = $stmt->rowCount();
   if ($count > 0) {
     $rs = true;
   }
   return $rs;
 }

function customerRegistration($cn, $input){
  $rs = false;
  $hash = password_hash($input['pword'], PASSWORD_BCRYPT);
  $stmt = $cn->prepare("INSERT INTO users (firstName, lastName, email, username, hash) VALUES (:f, :l, :e, :u, :h)");
  $data = [
    ":f" => $input['fname'],
    ":l" =>$input['lname'],
    ":e" =>$input['email'],
    ":u" => $input['uname'],
    ":h" =>$hash
  ];
  if( $stmt ->execute($data)){
    $rs = true;
  }
  return $rs;
}

function userLogin($dbconn, $input)
{
  $result = [];
   $stmt = $dbconn ->prepare("SELECT * FROM users WHERE email = :email");
   $stmt ->bindParam(':email', $input['email']);
   $stmt ->execute();
   $count = $stmt->rowCount();
   $row = $stmt->fetch(PDO::FETCH_BOTH);

   if ($count != 1 || !password_verify($input['password'], $row['hash'])) {
     $result [] = false;
   }else {
     $result [] = true;
     $result [] = $row;
   }
   return $result;
 }
 ?>
