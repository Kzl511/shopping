<?php
include 'header.php';
?>
<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (!empty($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}

$numOfRecs = 6;
$offset = ($pageno - 1) * $numOfRecs;

if (empty($_GET['category'])) {
	if (empty($_POST['search']) && empty($_COOKIE['search'])) {
		$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
		$stmt->execute();
		$rawResult = $stmt->fetchAll();
		$total_pages = ceil(count($rawResult) / $numOfRecs);
	
		$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset, $numOfRecs");
		$stmt->execute();
		$result = $stmt->fetchAll();
	} else {
		$searchKey = $_POST['search'] ?? $_COOKIE['search'];
		$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
		$stmt->execute();
		$rawResult = $stmt->fetchAll();
		$total_pages = ceil(count($rawResult) / $numOfRecs);
	
		$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset, $numOfRecs");
		$stmt->execute();
		$result = $stmt->fetchAll();
	}
} else {
	$category_id = $_GET['category'];
	if (empty($_POST['search']) && empty($_COOKIE['search'])) {
		$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$category_id ORDER BY id DESC");
		$stmt->execute();
		$rawResult = $stmt->fetchAll();
		$total_pages = ceil(count($rawResult) / $numOfRecs);
	
		$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$category_id ORDER BY id DESC LIMIT $offset, $numOfRecs");
		$stmt->execute();
		$result = $stmt->fetchAll();
	} else {
		$searchKey = $_POST['search'] ?? $_COOKIE['search'];
		$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$category_id AND name LIKE '%$searchKey%' ORDER BY id DESC");
		$stmt->execute();
		$rawResult = $stmt->fetchAll();
		$total_pages = ceil(count($rawResult) / $numOfRecs);
	
		$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$category_id AND name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset, $numOfRecs");
		$stmt->execute();
		$result = $stmt->fetchAll();
	}
}
?>

<div class="container"> 
	<div class="row">
		<div class="col-xl-3 col-lg-4 col-md-5">
			<div class="sidebar-categories">
				<div class="head">Browse Categories</div>
				<ul class="main-categories">
					<li class="main-nav-list">
						<?php 
							$catStmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
							$catStmt->execute();
							$catResult = $catStmt->fetchAll();
						?>
						<?php 
							foreach ($catResult as $value) {
						?>
						<a href="index.php?category=<?php echo $value['id']; ?>"><span class="lnr lnr-arrow-right"></span><?php echo escape($value['name']); ?></a>
						<?php
							}
						?>
						<a href="index.php"><span class="lnr lnr-arrow-right"></span>All</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-xl-9 col-lg-8 col-md-7">
			<!-- Start Filter Bar -->
			<div class="filter-bar d-flex flex-wrap align-items-center">
				<div class="pagination">
					<a href="?pageno=1" class="active">First</a>
					<a <?php if ($pageno <= 1) {
							echo 'disabled';
						} ?>
						href="<?php if ($pageno <= 1) {
									echo '#';
								} else {
									echo '?pageno=' . ($pageno - 1);
								} ?>" class="prev-arrow">
						<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
					</a>
					<a href="#" class="active"><?php echo $pageno ?></a>
					<a <?php if ($pageno >= $total_pages) {
							echo 'disabled';
						} ?>
						href="<?php if ($pageno >= $total_pages) {
									echo '#';
								} else {
									echo '?pageno=' . ($pageno + 1);
								} ?>" class="next-arrow">
						<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
					</a>
					<a href="?pageno=<?php echo $total_pages; ?>" class="active">Last</a>
				</div>
			</div>
			<!-- End Filter Bar -->
			<!-- Start Best Seller -->
			<section class="lattest-product-area pb-40 category-list">
				<div class="row">
					<?php 
						if ($result) {
							 foreach ($result as $value) {
					?>
					<div class="col-lg-4 col-md-6">
						<div class="single-product">
							<img class="img-fluid" src="admin/images/<?php echo escape($value['image']) ?>" style="height: 250px;">
							<div class="product-details">
								<h6><?php echo escape($value['name']); ?></h6>
								<div class="price">
									<h6>$<?php echo escape($value['price']); ?></h6>
								</div>
								<div class="prd-bottom">
									<a href="" class="social-info">
										<span class="ti-bag"></span>
										<p class="hover-text">add to bag</p>
									</a>
									<a href="product_detail.php?id=<?php echo $value['id']; ?>" class="social-info">
										<span class="lnr lnr-move"></span>
										<p class="hover-text">view more</p>
									</a>
								</div>
							</div>
						</div>
					</div>
					<?php
							 }
						}
					?>
					<!-- single product -->
				</div>
			</section>
		</div>
	</div>
</div>

<?php
include 'footer.php';
?>