<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];
		$filename = $_FILES['chapter_photo']['name'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT * FROM sub_products WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		if(!empty($filename)){
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$new_filename = $row['chapter_name'].'_'.time().'.'.$ext;
			move_uploaded_file($_FILES['chapter_photo']['tmp_name'], '../images/'.$new_filename);	
		}
		
		try{
			$stmt = $conn->prepare("UPDATE sub_products SET chapter_photo=:chapter_photo WHERE id=:id");
			$stmt->execute(['chapter_photo'=>$new_filename, 'id'=>$id]);
			$_SESSION['success'] = 'แก้ไขรูปภาพสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'โปรดเลือกรูปภาพหน้าปก';
	}

	header("Location: " . $_SERVER['HTTP_REFERER']);
?>