<?php
	include 'includes/session.php';

	if(isset($_POST['activate'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE products SET product_status=:product_status WHERE id=:id");
			$stmt->execute(['product_status'=>'ACTIVE', 'id'=>$id]);
			$_SESSION['success'] = 'Product activated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select Products to activate first';
	}

	header('location: products.php');
?>