<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, sub_products.id AS prodid, sub_products.chapter_name AS prodname, products.name AS catname, sub_products.chapter_path AS chapter_path FROM sub_products LEFT JOIN products ON products.id=sub_products.product_id WHERE sub_products.id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		
		$pdo->close();
		
		echo json_encode($row);
	}

?>