<?php
	include 'includes/session.php';

	if(isset($_POST['activate'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE sub_products SET chapter_state=:chapter_state WHERE id=:id");
			$stmt->execute(['chapter_state'=>'ACTIVE', 'id'=>$id]);
			$_SESSION['success'] = 'Chapter activated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select chapter to activate first';
	}

	header("Location: " . $_SERVER['HTTP_REFERER']);
?>