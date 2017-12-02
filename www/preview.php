<?php
$page_title = "Book Preview";
include("includes/uheader.php");

if (isset($_GET['id'])) {
  $bookId = $_GET['id'];
  $rs = previewBook($conn, $bookId);
  $img = $rs['img_path'];
}else{  redirect("index.php", "");
}
?>

<div class="main">
    <?php

    if (array_key_exists('submit', $_POST)) {
        $errors = [];
    if (empty($_POST['amount'])) {
      $errors ['amount'] = "Qty cannot be empty";
      echo "<p class='global-error'>You have not chosen any amount!</p>";
    }

    if (empty($errors)) {
      $clean = array_map('trim', $_POST);

    }

    }

        ?>

    <div class="book-display">
      <div class="display-book" style="background: url('<?php echo $img; ?>');
        background-size: cover; background-positive: center; background-repeat: no-repeat; ">
            </div>

      <div class="info">
      <h2 class="book-title"><?php echo $rs['title']; ?></h2>
       <h3 class="book-author">by <?php echo $rs['author']; ?></h3>
       <h3 class="book-price">$<?php echo $rs['price']; ?></h3>
       <form>
         <label for="book-amout">QTY</label>
         <input type="number" class="book-amount text-field" name="amount" min="1">
         <input class="def-button add-to-cart" type="submit" name="submit" value="Add to cart">
       </form>
      </div>

    </div>

    <div class="book-reviews">
      <h3 class="header">Reviews</h3>

      <ul class="review-list">
        <?php
      echo $rt = showComments($conn, $bookId);
         ?>
      </ul>

      <?php
  $err = [];
      if (array_key_exists('review', $_POST)) {

        if (empty($_POST['comment'])) {
          $err['comment'] = "Kindly review the book before submitting";
        }
        if (!isset($_SESSION['uid']) || !isset($_SESSION['name'])) {
          $err['comment'] = "Kindly login to review a  book";
        }

        if (empty($err)) {
          $clean= array_map('trim', $_POST);
          $r = $clean['comment'];
          $userId = $_SESSION['uid'];
          $date = date("Y-m-d");
            $addR = addReview($conn, $userId, $bookId, $r, $date);

            if ($addR) {
              echo "<span style='color:#17B5CC;'>Thank you for the review</span>";
            }
                }
      }

       ?>
      <div class="add-comment">
        <h3 class="header">Add your comment</h3>
        <?php   $info = displayErrors($err, 'comment'); echo $info;      ?>
        <form class="comment" action="" method="post">
          <textarea class="text-field" placeholder="write something" name="comment"></textarea>
          <button class="def-button post-comment" name="review">Upload comment</button>
        </form>
      </div>
    </div>

  </div>
<?php include("includes/ufooter.php"); ?>
