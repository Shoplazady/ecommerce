<?php include 'includes/session.php'; ?>
<?php
$slug = $_GET['category'];

$conn = $pdo->open();

try {
	$stmt = $conn->prepare("SELECT * FROM category WHERE cat_slug = :slug");
	$stmt->execute(['slug' => $slug]);
	$cat = $stmt->fetch();
	$catid = $cat['id'];
} catch (PDOException $e) {
	echo "There is some problem in connection: " . $e->getMessage();
}

$pdo->close();

?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-yellow layout-top-nav">

	<div class="wrapper">

		<?php include 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">

				<!-- Main content -->
				<section class="content">
					<div class="row">

						<div class="col-sm-9">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb bg-black">
									<li class="breadcrumb-item">
										<h4> หมวดหมู่ : <?php echo $cat['name']; ?></h4>
									</li>
								</ol>
							</nav>
							<?php
							if (isset($_SESSION['error'])) {
								echo "
										<div class='alert alert-danger alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
										<h4><i class='icon fa fa-warning'></i> Error!</h4>
										" . $_SESSION['error'] . "
										</div>
									";
								unset($_SESSION['error']);
							}
							if (isset($_SESSION['success'])) {
								echo "
										<div class='alert alert-success alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
										<h4><i class='icon fa fa-check'></i> Success!</h4>
										" . $_SESSION['success'] . "
										</div>
									";
								unset($_SESSION['success']);
							}
							?>
							<div class="container-fluid bg-black">
								<br>
								<?php

								if ($cat['name'] == 'Coins') {

									$conn = $pdo->open();

									try {
										$inc = 3;
										$stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :catid");
										$stmt->execute(['catid' => $catid]);
										foreach ($stmt as $row) {
											$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
											$inc = ($inc == 3) ? 1 : $inc + 1;
											if ($inc == 1) echo "<div class='row'>";
											echo "
													<form action='process_cart.php' method='post'>
														<div class='col-sm-4 text-center'>
															<div class='box box-solid bg-black'>
																<div class='box-body prod-body'>
																	<img src='" . $image . "' width='100%' height='200px' class='thumbnail'>
																	<h5>" . $row['name'] . "</a></h5>
																	<b>ราคา " . number_format($row['price']) . "</b> บาท</i>
																</div>
																<input type='hidden' name='product_id' value='" . $row['id'] . "'>
																<button type='submit' name='action' value='add_to_cart' class='btn btn-success btn-sm btn-flat'>
																	<i class='fa fa-shopping-cart'></i> เพิ่มลงตระกล้า
																</button>
															</div>
														</div>
													</form>";
											if ($inc == 3) echo "</div>";
										}
										if ($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>";
										if ($inc == 2) echo "<div class='col-sm-4'></div></div>";
									} catch (PDOException $e) {
										echo "There is some problem in connection: " . $e->getMessage();
									}

									$pdo->close();
								} else {

									$conn = $pdo->open();

									try {
										$inc = 3;
										$stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :catid");
										$stmt->execute(['catid' => $catid]);
										foreach ($stmt as $row) {
											$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
											$inc = ($inc == 3) ? 1 : $inc + 1;
											if ($inc == 1) echo "<div class='row'>";
											echo "
	       							<div class='col-sm-4'>
									<a href='product.php?product=" . $row['slug'] . "'>
	       								<div class='box box-solid bg-black'>
		       								<div class='box-body prod-body'>
		       									<img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
		       									<h5>" . $row['name'] . "</h5>
		       								</div>
		       								
	       								</div>
										</a>
	       							</div>
									
	       						";
											if ($inc == 3) echo "</div>";
										}
										if ($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>";
										if ($inc == 2) echo "<div class='col-sm-4'></div></div>";
									} catch (PDOException $e) {
										echo "There is some problem in connection: " . $e->getMessage();
									}

									$pdo->close();
								}
								?>
							</div>
						</div>
						<div class="col-sm-3">
							<?php include 'includes/sidebar.php'; ?>
						</div>
					</div>
				</section>

			</div>
		</div>
		<?php include 'includes/modal_form.php'; ?>
		<?php include 'includes/footer.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>

	<script>
		$(function() {
			$('#add').click(function(e) {
				e.preventDefault();
				var quantity = $('#quantity').val();
				quantity++;
				$('#quantity').val(quantity);
			});
			$('#minus').click(function(e) {
				e.preventDefault();
				var quantity = $('#quantity').val();
				if (quantity > 1) {
					quantity--;
				}
				$('#quantity').val(quantity);
			});

		});
	</script>

</body>

</html>