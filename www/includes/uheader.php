<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="styles/style.css">
      <title><?php echo $page_title; ?></title>
      <style media="screen">
      .err {
          font-size: 13px;
          color:red !important;
      }
      .scc {
          font-size: 13px;
          color:#17B5CC;
          text-transform: uppercase;
          padding-bottom: 10px;
      }
      </style>
</head>
<body id="bookpreview">
  <div class="top-bar">
    <div class="top-nav">
      <a href="index.html"><h3 class="brand"><span>C</span>astle<span>B</span>ooks</h3></a>
      <ul class="top-nav-list">
        <li class="top-nav-listItem Home"><a href="index.php">Home</a></li>
        <li class="top-nav-listItem catalogue"><a href="catalogue.html">Catalogue</a></li>
        <li class="top-nav-listItem login"><a href="user_login.php">Login</a></li>
        <li class="top-nav-listItem register"><a href="registration.php">Register</a></li>
        <li class="top-nav-listItem cart">
          <div class="cart-item-indicator">
            <p>12</p>
          </div>
          <a href="cart.html">Cart</a>
        </li>
      </ul>
      <form class="search-brainfood">
        <input type="text" class="text-field" placeholder="Search all books">
      </form>
    </div>
  </div>
