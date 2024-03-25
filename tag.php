<?php include 'includes/session.php'; ?>
<?php


	if(isset($_GET['tag'])){
		$slug = $_GET['tag'];
	}elseif(isset($_GET['tag_slug'])){
		$slug = $_GET['tag_slug'];
	}
	

	$conn = $pdo->open();

	try{
		$stmt = $conn->prepare("SELECT * FROM sub_category WHERE tag_slug = :slug");
		$stmt->execute(['slug' => $slug]);
		$tag = $stmt->fetch();
		$tagid = $tag['id'];
	}
	catch(PDOException $e){
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
                                <li class="breadcrumb-item"><h4> Tag : <?php echo $tag['name']; ?></h4></li>
                            </ol>
                        </nav>

						<div class="container-fluid bg-black">
							<br>
		       		<?php
		       			
		       			$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;	
						    $stmt = $conn->prepare("SELECT * FROM products WHERE tag1_id = :tagid OR tag2_id = :tagid OR tag3_id = :tagid");
						    $stmt->execute(['tagid' => $tagid]);
						    foreach ($stmt as $row) {
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>
									<a href='product.php?product=".$row['slug']."'>
	       								<div class='box box-solid bg-black'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h5>".$row['name']."</h5>
		       								</div>
										</div>
	       							</a>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						$pdo->close();

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
	<?php  include 'includes/modal_form.php'; ?>					
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

</body>
</html>