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


function deleteFromCart($dbconn, $id){
  $result = false;
  $stmt = $dbconn->prepare("DELETE FROM cart WHERE cart_id =:id");
  $stmt ->bindParam(':id', $id);
  if (  $stmt ->execute()) {
    $result = false;
  }
  return $result;

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

function cartContent($db, $cusid, $pst){
  $stmt = $db->prepare("SELECT c.cart_id, c.customer_id, c.product_id, c.qty, c.payment_status, b.img_path, b.price FROM cart c, books b WHERE c.product_id= b.books_id AND c.customer_id=:cid AND c.payment_status=:ps");
  $data =[
    ":cid" => $cusid,
    ":ps" => $pst
  ];
  $stmt->execute($data);
  return $stmt;
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

function updateCart($db, $q, $cd){
  $rs = false;
  $stmt = $db->prepare("UPDATE cart SET qty=:qt WHERE cart_id=:c");
  $data =[    ":qt" =>$q,
    ":c" =>$cd
  ];
  if($stmt ->execute($data)){
    $rs = true;
  }
  return $rs;
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

   if ($count != 1 || !password_verify($input['pword'], $row['hash'])) {
     $result [] = false;
   }else {
     $result [] = true;
     $result [] = $row;
   }
   return $result;
 }


 function getCategories($dbcon)
 {
   $result = "";
   $stmt = $dbcon->prepare("SELECT * FROM category ORDER BY category_name ASC");
   $stmt ->execute();
   while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
     $result .= "<a href=catalogue.php?nm=".$row['category_id']."><li class=category>".$row['category_name']."</li></a>";
   }
   return $result;
 }

function displayTopSelling($db){
  $fg = "Top Selling";
  $st = $db->prepare("SELECT * FROM books
    WHERE flag=:f
    ORDER BY Rand() LIMIT 1");
  $st ->bindParam(':f', $fg);
  $st ->execute();
  $row = $st->fetch(PDO::FETCH_ASSOC);
return $row;
}

function displayTrending($db){
  $rs ="";
  $t = "Trending";
  $st = $db->prepare("SELECT * FROM books WHERE flag=:t ORDER BY Rand() LIMIT 8");
  $st->bindParam(':t', $t);
  $st ->execute();
  while($row = $st->fetch(PDO::FETCH_ASSOC)){
    $img = $row['img_path']; $id = $row['books_id'];
$rs .= "<li class='book' ><a href='preview.php?id=$id'><div class='book-cover' style=\"background:url('$img'); background-size: cover;
background-position: center; background-repeat: no-repeat; \"></div></a><div class='book-price'><p>$".$row['price']."</p></div></li>";
  }

  return $rs;
}

function recentlyViewed($db){
  $rs ="";
  $t = "Receently Viewed";
  $st = $db->prepare("SELECT * FROM books WHERE flag=:t ORDER BY Rand() LIMIT 4");
  $st->bindParam(':t', $t);
  $st ->execute();
  while($row = $st->fetch(PDO::FETCH_ASSOC)){
    $img = $row['img_path']; $id = $row['books_id'];
$rs .= "<li class='book' ><a href='preview.php?id=$id'><div class='book-cover' style=\"background:url('$img'); background-size: cover;
background-position: center; background-repeat: no-repeat; \"></div></a><div class='book-price'><p>$".$row['price']."</p></div></li>";
  }

  return $rs;
}

function displayByCategory($db, $cat=null){
  $rs = "";

  if ($cat != null) {
    $st = $db->prepare("SELECT * FROM books WHERE cat_id=:t ORDER BY Rand() LIMIT 8");
    $st->bindParam(':t', $cat);
    $st ->execute();
    while($row = $st->fetch(PDO::FETCH_ASSOC)){
      $img = $row['img_path']; $id = $row['books_id'];
  $rs .= "<li class='book' ><a href='preview.php?id=$id'><div class='book-cover' style=\"background:url('$img'); background-size: cover;
  background-position: center; background-repeat: no-repeat; \"></div></a><div class='book-price'><p>$".$row['price']."</p></div></li>";
}

}else {
    $st = $db->prepare("SELECT * FROM books ORDER BY Rand() LIMIT 8");
    $st ->execute();
    while($rw = $st->fetch(PDO::FETCH_ASSOC)){
      $img = $rw['img_path']; $id = $rw['books_id'];
  $rs .= "<li class='book' ><a href='preview.php?id=$id'><div class='book-cover' style=\"background:url('$img'); background-size: cover;
  background-position: center; background-repeat: no-repeat; \"></div></a>
  <div class='book-price'><p>$".$rw['price']."</p></div></li>";
  }
}

  return $rs;
}


function previewBook($db, $id)
{
$st = $db->prepare("SELECT * FROM books WHERE books_id=:id");
  $st->bindParam(':id', $id);
  $st ->execute();
  $row = $st->fetch(PDO::FETCH_ASSOC);
return $row;

}



  function addReview($db, $uid, $bkid, $rv, $dt){
    $result = false;
    $st = $db->prepare("INSERT INTO reviews (user_id, book_id, review, review_date) VALUES (:u, :bid, :rv, :dt)");
    $data = [
      ":u" => $uid,
      ":bid" => $bkid,
      ":rv" => $rv,
      ":dt" => $dt
    ];
    if ($st->execute($data)) {
      $result = true;
    }

    return $result;
  }

  function showComments($db, $bid){
    $res = "";
    $stmt = $db->prepare("SELECT r.user_id, r.book_id, r.review, u.firstName, u.lastName FROM reviews r, users u WHERE r.user_id = u.user_id AND book_id =:b ORDER BY review_date DESC");
    $stmt->bindParam(':b', $bid);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $fname = $row['firstName']; $lname = $row['lastName']; $rv =$row['review'];
      $abbr =substr(ucfirst($row['firstName']), 0, 1).substr(ucfirst($row['lastName']), 0, 1);

      $res .="
      <li class='review'><div class='avatar-def user-image'><h4 class='user-init'>$abbr</h4></div><div class='info'><h4 class='username'>$fname $lname</h4><p class='comment'>$rv</p></div></li>";
    }
    return $res;
  }

function addCart($db, $cs, $prd, $qty, $pst, $dt){
  $rs = false;
  $stmt=$db->prepare("INSERT INTO cart (customer_id, product_id, qty, payment_status, t_date) VALUES (:c, :p, :q, :pt, :d)");
  $data = [
    ":c" => $cs,
    ":p" =>$prd,
    ":q" =>$qty,
    ":pt" =>$pst,
    ":d" =>$dt
  ];
  if ( $stmt->execute($data) ) {
    $rs = true;
  }
return $rs;

}

function selectFromCart($dbconn, $user, $ps){
  $stmt = $dbconn->prepare("SELECT count(qty) FROM cart WHERE customer_id=:id AND payment_status=:un");
  $stmt->bindParam(':id', $user);
  $stmt->bindParam(':un', $ps);
  $stmt->execute();
$row = $stmt->fetchColumn();
  return $row;
}

function checkOut($db, $id, $cl, $dt, $pst, $ptc){
  $status = false;
    $pass = $db->prepare("UPDATE cart SET phone=:p, address=:ad, ddate=:d, pcode=:pc, payment_status=:pt WHERE
    customer_id=:id AND payment_status=:ps ");
    $data = [
      ":p"=> $cl['num'],
      ":ad"=> $cl['addy'],
      ":d" =>$dt,
      ":pc" =>$cl['code'],
      ":pt" =>$ptc,
      ":id" =>$id,
      ":ps" => $pst
    ];
    if ($pass->execute($data)) {
      $status = true;
    }
    return $status;
}

function getPurchased($db, $id, $pst, $dd){
    $sn = 0;
  $stmt = $db->prepare("SELECT c.product_id, c.qty, b.title, b.author,
   b.price FROM cart c, books b WHERE c.product_id= b.books_id
   AND c.customer_id=:cid AND c.payment_status=:ps AND ddate=:d ");
  $data =[
    ":cid" => $id,
    ":ps" => $pst,
    ":d" =>$dd
  ];
  $stmt->execute($data);
while($row =$stmt->fetch(PDO::FETCH_BOTH)){
  $sn++;
  extract($row); $total = $price*$qty;
  echo "<tr><td>$sn</td><td>$title</td><td>$price</td><td>$qty</td><td> $total </td></tr>";
}
}


function getCustomerInfo($db, $id, $dd){
  $stmt = $db->prepare("SELECT u.firstName, u.lastName, u.email,
  c.phone, c.address, c.pcode
  FROM users u, cart c WHERE u.user_id = c.customer_id AND c.customer_id = :d AND c.ddate=:dd");
  $stmt->bindParam(':d', $id);
  $stmt->bindParam(':dd', $dd);
  $stmt->execute();
  $rs = $stmt->fetch(PDO::FETCH_BOTH);
  return $rs;
}





 ?>
