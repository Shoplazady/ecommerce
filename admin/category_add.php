<?php
/* check */
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$slug = $name;

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM category WHERE name=:name");
		$stmt->execute(['name'=>$name]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Category already exist';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO category (name,cat_slug) VALUES (:name,:cat_slug)");
				$stmt->execute(['name'=>$name,'cat_slug'=>$slug]);
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

	header('location: category.php');

?>