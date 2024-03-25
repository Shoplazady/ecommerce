<?php include 'includes/session.php'; ?>
<?php
$conn = $pdo->open();

$slug = $_GET['product'];

try {

	$stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM products LEFT JOIN category ON category.id=products.category_id WHERE slug = :slug");
	$stmt->execute(['slug' => $slug]);
	$product = $stmt->fetch();
} catch (PDOException $e) {
	echo "There is some problem in connection: " . $e->getMessage();
}


//page view
$now = date('Y-m-d');
if ($product['date_view'] == $now) {
	$stmt = $conn->prepare("UPDATE products SET counter=counter+1 WHERE id=:id");
	$stmt->execute(['id' => $product['prodid']]);
} else {
	$stmt = $conn->prepare("UPDATE products SET counter=1, date_view=:now WHERE id=:id");
	$stmt->execute(['id' => $product['prodid'], 'now' => $now]);
}

if (isset($_SESSION['user'])) {
	$stmt = $conn->prepare("UPDATE products SET pro_u_count=pro_u_count+1 , pro_all_count=pro_all_count+1  WHERE id=:id");
	$stmt->execute(['id' => $product['prodid']]);
} else {
	$stmt = $conn->prepare("UPDATE products SET pro_all_count=pro_all_count+1  WHERE id=:id");
	$stmt->execute(['id' => $product['prodid']]);
}

try {
	$stmt = $conn->prepare("SELECT SUM(star) AS total_stars, COUNT(*) AS total_rows FROM rating WHERE product_id = :product_id");
	$stmt->execute(['product_id' => $product['prodid']]);
	$row = $stmt->fetch();
	$totalStars = $row['total_stars'];
	$totalRows = $row['total_rows'];

	// Calculate the average rating
	if ($totalRows > 0) {
		$averageRating = ($totalStars / ($totalRows * 5)) * 5;
	} else {
		$averageRating = 0;
	}
	$averageRating = number_format($averageRating, 1);
} catch (PDOException $e) {
	echo $e->getMessage();
}

$pdo->close();

?>

<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-yellow layout-top-nav">

	<div class="wrapper">

		<?php include 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">
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
				<!-- Main content -->
				<section class="content">

					<div class="row">
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
									<img class="thumbnail" src="<?php echo (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg'; ?>" width="100%">
								</div>

								<!--- คำอธิบายสินค้า --->
								<div class="col-sm-6">
									<div class="container-fluid p-3 mb-3 bg-black">
										<h1 class="page-header"><?php echo $product['prodname']; ?></h1>
										<p><b>หมวดหมู่ :</b> <a href="category.php?category=<?php echo $product['cat_slug']; ?>"><?php echo $product['catname']; ?></a></p>
										<p><b>Tags : </b>
											<?php
											$conn = $pdo->open();

											try {
												$stmt = $conn->prepare("SELECT *, sub_category.name AS tagname FROM products LEFT JOIN sub_category ON sub_category.id=products.tag1_id OR sub_category.id=products.tag2_id OR sub_category.id=products.tag3_id WHERE slug = :slug");
												$stmt->execute(['slug' => $slug]);
												foreach ($stmt as $tag) {
													echo "<a href='tag.php?tag={$tag['tag_slug']}'>" . $tag['tagname'] . " " . "</a>";
												}
											} catch (PDOException $e) {
												echo $e->getMessage();
											}

											$pdo->close();
											?>
										</p>

										<p><b>ผู้แต่ง :</b></p>
										<p><b><i class="bi bi-star"></i> :</b> <?php echo number_format($averageRating, 1); ?> / 5.0 </p>
										<p><b>วันที่อัพเดท : <?php echo $product['date_pro_created']; ?></b></p>
										<p><b><i class="bi bi-eye"></i> : <?php echo $product['pro_all_count']; ?></b></p>
										<p><b>เรื่องย่อ :</b></p>
										<p><?php echo $product['description']; ?></p>
									</div>
								</div>
							</div>
							<!-- แสดงดาว -->

							<div class="row">
								<div class="col-sm-9">
									<div id="rating-container" class="pull-left">
										<img src="image-star/full-star.png">
										<select id="rating-select">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
										<button id="rating-button" class="btn btn-warning">ให้ดาวเลย</button>
									</div>
								</div>

							</div>

							<!-- แสดงตอนที่มี -->
							<div>
								<h3><span class="label label-danger">Chapter list</span><a id="btnMaincom"><button class="btn btn-primary pull-right"><i class="bi bi-chat-dots"></i> Comments</button></a>
									<button class="btn btn-warning pull-right" onclick="addToFavorites(<?php echo $product['prodid']; ?>)"><i class="bi bi-bookmark-heart-fill"></i></button>
								</h3>
							</div>

							<div class="container-fluid bg-black">
								<br>
								<div class="row">
									<ul class='list-group' id='chapterList'>
										<?php
										$limit = 5; // Set the desired number of chapters to load initially
										$conn = $pdo->open();
										try {
											$stmt = $conn->prepare("SELECT *, products.id AS proid, sub_products.id AS chapterid FROM products LEFT JOIN sub_products ON products.id=sub_products.product_id WHERE slug = :slug ORDER BY CAST(chapter AS UNSIGNED) DESC LIMIT $limit");
											$stmt->execute(['slug' => $slug]);
											$chapters = $stmt->fetchAll();
											$chapterCount = count($chapters); // Get the total number of chapters
											foreach ($chapters as $chapter_ch) {
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
														<small class='pull-right'><span class='label label-warning'><i class='bi bi-calendar-plus'></i> {$chapter_ch['chapter_created']}</span></small>
														</li>
													";
											}
										} catch (PDOException $e) {
											echo $e->getMessage();
										}
										$pdo->close();
										?>

									</ul>
									<?php if ($chapterCount >= $limit) : ?>
										<center><button id='loadMoreBtn' class='btn btn-warning'><i class="bi bi-caret-down"></i> คลิกเพื่อแสดงตอนเพิ่ม <i class="bi bi-caret-down"></i></button></center>
									<?php endif; ?>
								</div>
							</div>
							<br>
						</div>
						<div class="col-sm-3">
							<?php include 'includes/sidebar.php'; ?>
						</div>
					</div>

				</section>



			</div>
		</div>

		<?php $pdo->close(); ?>
		<?php include 'includes/modal_form.php'; ?>
		<?php include 'includes/modal_comment.php'; ?>
		<?php include 'includes/footer.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>

	<script>
		$(document).ready(function() {
			$('#rating-button').click(function() {
				var rating = $('#rating-input').val();
				// Perform an AJAX request to submit the rating
				$.ajax({
					url: 'submit-rating.php',
					type: 'POST',
					data: {
						item_id: <?php echo $product['prodid']; ?>,
						num_star: rating
					},
					success: function(response) {
						// Update the star rating display
						$('#rating-container').html(response);
					},
					error: function() {
						alert('Error submitting rating');
					}
				});
			});
		});
	</script>


	<script>
		$(document).ready(function() {
			var limit = 5;
			var offset = limit;
			var totalChapters = <?php echo $chapterCount; ?>;
			var order = 'DESC';

			// Function to load chapters based on the current offset and order
			function loadChapters() {
				$.ajax({
					url: 'load_more.php',
					method: 'POST',
					data: {
						limit: limit,
						offset: offset,
						slug: '<?php echo $slug; ?>',
						order: order
					},
					success: function(response) {
						$('#chapterList').append(response);
						offset += limit;
						if (offset >= totalChapters) {
							$('#loadMoreBtn').hide();
						}
					}
				});
			}

			// Load initial chapters
			function loadInitialChapters() {
				$.ajax({
					url: 'load_more.php',
					method: 'POST',
					data: {
						limit: limit,
						offset: 0, // Set the offset to 0 for initial load
						slug: '<?php echo $slug; ?>',
						order: order
					},
					success: function(response) {
						$('#chapterList').html(response); // Replace the chapter list
						offset = limit;
					}
				});
			}

			function isScrolledToBottom() {
				var documentHeight = $(document).height();
				var windowHeight = $(window).height();
				var scrollTop = $(window).scrollTop();
				return (scrollTop + windowHeight >= documentHeight);
			}

			// Scroll event listener
			$(window).scroll(function() {
				if (isScrolledToBottom()) {
					loadChapters();
				}
			});

			// Click event for the load more button
			$('#loadMoreBtn').on('click', function() {
				loadChapters();
			});

			

			// Load initial chapters
			loadInitialChapters();
		});
	</script>

	<script>
		function addToFavorites(productId) {
			// Send an AJAX request to add the product to favorites
			$.ajax({
				url: 'add_to_favourite.php',
				type: 'POST',
				data: {
					product_id: productId
				},
				success: function(response) {
					// Handle the response if needed
					alert(response);
				}
			});
		}
	</script>

	<script>
		function likeComment(commentId, userId) {
			// Send an AJAX request to check if the user has already liked the comment
			$.ajax({
				url: 'check_like.php',
				type: 'POST',
				data: {
					comment_id: commentId,
					user_id: userId
				},
				success: function(response) {
					if (response === 'liked') {
						// User has already liked the comment, do not proceed
						alert('You have already liked this comment.');
					} else {
						// User has not liked the comment, proceed to increment the like count
						incrementLikeCount(commentId);
					}
				}
			});
		}

		function incrementLikeCount(commentId) {
			// Send an AJAX request to increment the like count
			$.ajax({
				url: 'increment_like.php',
				type: 'POST',
				data: {
					comment_id: commentId
				},
				success: function(response) {
					// Update the like count within the button
					$('#likeCount' + commentId).text(response);
				}
			});
		}
	</script>



</body>

</html>