<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page_title; ?></title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
	<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="add_category.php" <?php curNav('add_category.php'); ?>>add Category</a></li>
					<li><a href="view_category.php" <?php curNav('view_category.php'); ?>>view Category</a></li>
					<li><a href="add_products.php" <?php curNav('add_products.php'); ?>>Add Product</a></li>
					<li><a href="view_products.php" <?php curNav('view_products.php'); ?>>view Products</a></li>
					<li><a href="logout.php">logout</a></li>
				</ul>
			</nav>
		</div>
	</section>
