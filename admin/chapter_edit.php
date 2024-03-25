<?php
	include 'includes/session.php';
	

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$proid = $_POST['pronameid'];
        $proid = filter_var($proid, FILTER_SANITIZE_STRING);
		$chapter = $_POST['chapter'];
        $chapter = filter_var($chapter, FILTER_SANITIZE_STRING);
		$name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
		$price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
		$status = $_POST['chapter_status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE sub_products SET product_id=?,chapter=? , chapter_name=?, price=?, chapter_status=? WHERE id=?");
			$stmt->execute([$proid,$chapter,$name,$price,$status,$id]);
			$_SESSION['success'] = 'แก้ไขเสร็จสิ้น';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'โปรดกรอกข้อมูลให้เรียบร้อย';
	}

	header("Location: " . $_SERVER['HTTP_REFERER']);

?>