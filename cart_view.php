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
						<div class="col-sm-12">
							<h1>ตระกล้าสินค้า</h1>
							<div class="box box-solid">
								<div class="box-body">
									<div class="table-responsive">
										<table id="example1" class="table table-striped table-bordered nowrap" style="width:100%">
											<thead>
												<th></th>
												<th>Photo</th>
												<th>Name</th>
												<th>Price</th>
												<th width="20%">Quantity</th>
											</thead>
											<tbody id="tbody">
												<!-- Table rows go here -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php
							if (isset($_SESSION['user'])) {
								echo "
	        					<div><h3><span class='label label-primary'>กรุณาทักแชทเพจเพื่อชำระเงิน</span></h3></div>
	        				";
							} else {
								echo "
	        					<div><h3><span class='label label-primary'>โปรด เข้าสู่ระบบ เพื่อดำเนิดการต่อ</span></h3></div>
	        				";
							}
							?>
						</div>
					</div>
				</section>

			</div>
		</div>
		<?php $pdo->close(); ?>
		<?php include 'includes/modal_form.php'; ?>
		<?php include 'includes/footer.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>
	<script>
		var total = 0;
		$(function() {
			$(document).on('click', '.cart_delete', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				$.ajax({
					type: 'POST',
					url: 'cart_delete.php',
					data: {
						id: id
					},
					dataType: 'json',
					success: function(response) {
						if (!response.error) {
							getDetails();
							getCart();
							getTotal();
						}
					}
				});
			});

			$(document).on('click', '.minus', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				var qty = $('#qty_' + id).val();
				if (qty > 1) {
					qty--;
				}
				$('#qty_' + id).val(qty);
				$.ajax({
					type: 'POST',
					url: 'cart_update.php',
					data: {
						id: id,
						qty: qty,
					},
					dataType: 'json',
					success: function(response) {
						if (!response.error) {
							getDetails();
							getCart();
							getTotal();
						}
					}
				});
			});

			$(document).on('click', '.add', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				var qty = $('#qty_' + id).val();
				qty++;
				$('#qty_' + id).val(qty);
				$.ajax({
					type: 'POST',
					url: 'cart_update.php',
					data: {
						id: id,
						qty: qty,
					},
					dataType: 'json',
					success: function(response) {
						if (!response.error) {
							getDetails();
							getCart();
							getTotal();
						}
					}
				});
			});

			getDetails();
			getTotal();

		});

		function getDetails() {
			$.ajax({
				type: 'POST',
				url: 'cart_details.php',
				dataType: 'json',
				success: function(response) {
					$('#tbody').html(response);
					getCart();
				}
			});
		}

		function getTotal() {
			$.ajax({
				type: 'POST',
				url: 'cart_total.php',
				dataType: 'json',
				success: function(response) {
					total = response;
				}
			});
		}
	</script>

</body>

</html>