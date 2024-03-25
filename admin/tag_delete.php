<?php
/* check */
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM sub_category WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'ลบแท็กสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'โปรดเลือกแท็กที่ต้องการลบ';
	}

	header('location: tag.php');
	
?>