<?php
/* check */
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM sub_category WHERE name=:name");
		$stmt->execute(['name'=>$name]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'ชื่อแท็กซ้ำ';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO sub_category (name) VALUES (:name)");
				$stmt->execute(['name'=>$name]);
				$_SESSION['success'] = 'เพิ่มหมวดหมู่สำเร็จ';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'โปรดกรอกชื่อหมวดหมู่ที่ต้องการเพิ่ม';
	}

	header('location: tag.php');

?>