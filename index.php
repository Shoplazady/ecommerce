<?php include 'includes/session.php'; ?>
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
							<?php
							if (isset($_SESSION['error'])) {
								echo "
	        					<div class='alert alert-danger'>
	        						" . $_SESSION['error'] . "
	        					</div>
	        				";
								unset($_SESSION['error']);
							}
							?>
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
									<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
									<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
								</ol>
								<div class="carousel-inner">
									<div class="item active">
										<img src="images/banner1.jpg">
									</div>
									<div class="item">
										<img src="images/banner2.jpg">
									</div>
									<div class="item">
										<img src="images/banner3.jpg">
									</div>
								</div>
								<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
									<span class="fa fa-angle-left"></span>
								</a>
								<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
									<span class="fa fa-angle-right"></span>
								</a>

							</div>


							<h2><span class='label label-success'>การ์ตูนใหม่อัพล่าสุด</span></h2>
							<div class="container-fluid bg-black">
								<div class="scroll-container-wrapper">
									<div class="scroll-container">
										<!-- Scrollable content goes here -->
										<?php
										$conn = $pdo->open();

										try {
											$stmt = $conn->prepare("SELECT * FROM products WHERE category_id != '11' ORDER BY id DESC");
											$stmt->execute();

											foreach ($stmt as $row) {
												$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';

												echo '
							<div class="product">
								<a href="product.php?product=' . $row['slug'] . '">
									<img src="' . $image . '" alt="Product Image">
									<p>' . $row['name'] . '</p>
								</a>
							</div>
						';
											}
										} catch (PDOException $e) {
											echo "There is some problem in connection: " . $e->getMessage();
										}

										$pdo->close();
										?>
									</div>
									<div class="scroll-button prev">&lt;</div>
									<div class="scroll-button next">&gt;</div>
								</div>
							</div>

							<div>
								<h2><span class='label label-danger'>ตอนใหม่อัพเดทล่าสุด</span></h2>
							</div>
							<div class="container-fluid bg-black">

								<ul class='list-group'>
									<div class="row">
										<div class="col">
											<?php
											$conn = $pdo->open();
											try {
												$stmt = $conn->prepare("SELECT * , products.id AS proid ,products.name AS proname, sub_products.id AS chapterid FROM sub_products LEFT JOIN products ON products.id=sub_products.product_id ORDER BY sub_products.id DESC LIMIT 10");
												$stmt->execute();
												foreach ($stmt as $chapter_ch) {
													$chapimage = (!empty($chapter_ch['chapter_photo'])) ? 'images/' . $chapter_ch['chapter_photo'] : 'images/noimage.jpg';
													$free = ($chapter_ch['chapter_status'] == 'Free') ? '<span class="label label-success">Free</span>' : '';
													$lock = ($chapter_ch['chapter_status'] == 'Lock') ? '<span class="label label-danger"><i class="bi bi-lock"></i> Lock</span>' : '';

													// Check if the chapter is unlocked for the logged-in user
													if (isset($_SESSION['user'])) {
														$userId = $_SESSION['user'];
														$stmt = $conn->prepare("SELECT * FROM sub_sale WHERE user_id = :user_id AND sub_id = :chapter_id");
														$stmt->execute(['user_id' => $userId, 'chapter_id' => $chapter_ch['chapterid']]);
														$result = $stmt->fetch();

														if ($result) {
															$lock = '<span class="label label-warning"><i class="bi bi-unlock"></i> Unlock</span>';
														} else {
															$lock = ($chapter_ch['chapter_status'] == 'Lock') ? '<span class="label label-danger"><i class="bi bi-lock"></i> Lock</span>' : '';
														}
													}

													echo "
																<h5><span class='label label-danger'>{$chapter_ch['proname']}</span></h5>
																<a href='chapter.php?chapter={$chapter_ch['chapter']}&product_id={$chapter_ch['proid']}'>
																<li class='list-group-item list-group-item-action bg-black' aria-current='true'>
																<span class='pull-left'>
																	<img src='$chapimage' width='70px' height='90px'>
																</span>
																<h5 class='mb-1'>&nbsp;&nbsp;ตอนที่ {$chapter_ch['chapter']} {$chapter_ch['chapter_name']}
																</a>
																<span class='pull-right'>" . $free . "" . $lock . "</span></h5>
																<p class='mb-1'>&nbsp;&nbsp;<i class='bi bi-eye'></i> {$chapter_ch['chapter_all_count']}</p>
																<small>&nbsp;&nbsp;<i class='bi bi-chat'></i> ...</small>
																<small class='pull-right'><span class='label label-info'><i class='bi bi-calendar-plus'></i> {$chapter_ch['chapter_created']}</span></small>
																</li>
													
														
														";
												}
											} catch (PDOException $e) {
												echo $e->getMessage();
											}
											$pdo->close();
											?>
										</div>
									</div>
								</ul>
							</div>

							<h2><span class='label label-info'>สุ่มการ์ตูนไปอ่านเลย</span></h2>
							<div class="container-fluid bg-black">
								<div class="scroll-container-wrapper">
									<div class="scroll-container">
										<!-- Scrollable content goes here -->
										<?php
										$conn = $pdo->open();

										try {
											$stmt = $conn->prepare("SELECT * FROM products WHERE category_id != '11' ORDER BY RAND()");
											$stmt->execute();

											foreach ($stmt as $row) {
												$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';

												echo '
													<div class="product">
													<a href="product.php?product=' . $row['slug'] . '">
														<img src="' . $image . '" alt="Product Image">
														<p>' . $row['name'] . '</p>
													</a>
												</div>
														';
											}
										} catch (PDOException $e) {
											echo "There is some problem in connection: " . $e->getMessage();
										}

										$pdo->close();
										?>
									</div>
								</div>
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
	<script>
		const scrollContainer = document.querySelector('.scroll-container');
		const prevButton = document.querySelector('.scroll-button.prev');
		const nextButton = document.querySelector('.scroll-button.next');

		prevButton.addEventListener('click', () => {
			scrollContainer.scrollBy({
				left: -200, // Adjust the scroll amount based on your content width
				behavior: 'smooth'
			});
		});

		nextButton.addEventListener('click', () => {
			scrollContainer.scrollBy({
				left: 200, // Adjust the scroll amount based on your content width
				behavior: 'smooth'
			});


		});
	</script>
	<?php include 'includes/scripts.php'; ?>
</body>

</html>