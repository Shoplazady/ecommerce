<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		if(isset($_POST['tag1']) || isset($_POST['tag2']) || isset($_POST['tag3']) ){
			$tag1 = $_POST['tag1'];
			$tag2 = $_POST['tag2'];
			$tag3 = $_POST['tag3'];
		}
		$id = $_POST['id'];
		$name = $_POST['name'];
		$slug = $name;
		$category = $_POST['category'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$status = $_POST['status'];

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE products SET name=:name, slug=:slug, product_status=:status, category_id=:category, tag1_id=:tag1, tag2_id=:tag2, tag3_id=:tag3, price=:price, description=:description WHERE id=:id");
			$stmt->execute(['name'=>$name, 'slug'=>$slug,'status'=>$status ,'category'=>$category, 'tag1'=>$tag1, 'tag2'=>$tag2, 'tag3'=>$tag3, 'price'=>$price, 'description'=>$description, 'id'=>$id]);
			$_SESSION['success'] = 'Product updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit product form first';
	}

	header('location: products.php');

?>