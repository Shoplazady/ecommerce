<div class="row">
	<div class="box box-solid bg-black">
		<div class="box-header with-border">
			<h3 class="box-title"><b>เรื่องที่อ่านล่าสุดวันนี้</b></h3>
		</div>
		<div class="box-body">
			<ul id="trending">
				<?php
				$now = date('Y-m-d');
				$conn = $pdo->open();

				$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
				$stmt->execute(['now' => $now]);
				foreach ($stmt as $row) {
					echo "
					
					<li class='list-group-item list-group-item-success'>
					<a href='product.php?product=" . $row['slug'] . "'>" . $row['name'] . "</a>
					
					</li>
					
					";
				}

				$pdo->close();
				?>
				<ul>
		</div>
	</div>
</div>


<div class="row">
	<ul class="list-group mt-5">
		
		<h2><span class='label label-warning'>การ์ตูนยอดนิยม</h2></span>
		
		<li class="list-group-item bg-black">
			<div class="scroll-container-wrapper bg-black">
			<h5><span class='label label-danger'>การ์ตูนจีน</h5></span>
				<div class="scroll-container">
					<?php 
					$conn = $pdo->open();

					try{
						
					 $stmt = $conn->prepare("SELECT * FROM products LEFT JOIN category ON products.category_id = category.id WHERE cat_slug = 'Manhua' LIMIT 3");
					 $stmt->execute();
					 foreach ($stmt as $row) {
						$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
							echo '
							<a href="product.php?product='.$row['slug'].'">
							<div class="product">
								<img src="'.$image.'">
								<p>'.$row['slug'].'</p>
							</div>
							</a>
							';
					 }
					}
					catch(PDOException $e){
						echo "There is some problem in connection: " . $e->getMessage();
					}

					$pdo->close();
					?>
					
				</div>
			</div>
		</li>

		<li class="list-group-item bg-black">
		<div class="scroll-container-wrapper bg-black">
			<h5><span class='label label-warning'>การ์ตูนเกาหลี</h5></span>
				<div class="scroll-container">
					
				<?php 
					$conn = $pdo->open();

					try{
						
					 $stmt = $conn->prepare("SELECT * FROM products LEFT JOIN category ON products.category_id = category.id WHERE cat_slug = 'Manhwa' LIMIT 3");
					 $stmt->execute();
					 foreach ($stmt as $row) {
						$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
							echo '
							<a href="product.php?product='.$row['slug'].'">
							<div class="product">
								<img src="'.$image.'">
								<p>'.$row['slug'].'</p>
							</div>
							</a>
							';
					 }
					}
					catch(PDOException $e){
						echo "There is some problem in connection: " . $e->getMessage();
					}

					$pdo->close();
					?>
				</div>
			</div>
		</li>

		<li class="list-group-item bg-black">
		<div class="scroll-container-wrapper bg-black">
			<h5><span class='label label-info'>การ์ตูนญี่ปุ่น</h5></span>
				<div class="scroll-container">
					
				<?php 
					$conn = $pdo->open();

					try{
						
					 $stmt = $conn->prepare("SELECT * FROM products LEFT JOIN category ON products.category_id = category.id WHERE cat_slug = 'Manga' LIMIT 3");
					 $stmt->execute();
					 foreach ($stmt as $row) {
						$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
							echo '
							<a href="product.php?product='.$row['slug'].'">
							<div class="product">
								<img src="'.$image.'">
								<p>'.$row['slug'].'</p>
							</div>
							</a>
							';
					 }
					}
					catch(PDOException $e){
						echo "There is some problem in connection: " . $e->getMessage();
					}

					$pdo->close();
					?>
				</div>
			</div>
		</li>
	</ul>

</div>


<div class="row">
	<div class='box box-solid bg-black'>
		<div class='box-header with-border'>
			<h3 class='box-title'><b>ช่องทางติดตาม</b></h3>
		</div>
		<div class='box-body'>
			<a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
			<a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
			<a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
		</div>
	</div>
</div>
