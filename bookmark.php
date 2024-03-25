<?php include 'includes/session.php'; ?>

<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-yellow layout-top-nav">

<div class="wrapper">
	<?php include 'includes/navbar.php'; ?>
	<div class="content-wrapper bg-orange">
		<div class="container">
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-sm-12">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb bg-black">
								<li class="breadcrumb-item"><h4> เรื่องที่ติดตามอยู่ : </h4></li>
							</ol>
						</nav>
						<div class="container-fluid bg-black">
							<br>
							<div class="row">
								<?php 
								$conn = $pdo->open();
								$uid = $_SESSION['user'];
								try{
									$stmt = $conn->prepare("SELECT * FROM products LEFT JOIN favourite_manga ON products.id = favourite_manga.product_id WHERE user_id = :uid");
									$stmt->execute(['uid' => $uid]);
									$count = 0;
									foreach ($stmt as $row) {
										$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
										if ($count % 4 == 0) {
											echo '</div><div class="row">';
										}
										echo '
										<div class="col-sm-3">
										<a href="product.php?product='.$row['slug'].'">
                                            <div class="box box-solid bg-black">
                                                <div class="box-body prod-body text-center">
                                                    <img src="'.$image.'" width="100%" height="230px" class="thumbnail">
                                                    <h5>'.$row['name'].'</span></h5>
                                                </div>
                                            </div>
										</a>
                                        </div>
                                        ';
										$count++;
									}
								}
								catch(PDOException $e){
									echo "There is some problem in connection: " . $e->getMessage();
								}
								$pdo->close();
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
    <?php include 'includes/modal_form.php'; ?>
    <?php include 'includes/footer.php'; ?>		
</div>

<?php include 'includes/scripts.php'; ?>

</body>
</html>