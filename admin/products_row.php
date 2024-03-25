<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();
		//SELECT *, sub_products.id AS prodid, sub_products.chapter_name AS prodname, products.name AS catname FROM sub_products LEFT JOIN products ON products.id=sub_products.product_id WHERE sub_products.id=:id;
		$stmt = $conn->prepare("SELECT *, products.id AS prodid, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		
		$pdo->close();

		echo json_encode($row);
	}

?>