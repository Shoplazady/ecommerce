<?php

	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['chapter_name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $chapter = $_POST['chapter'];
        $chapter = filter_var($chapter, FILTER_SANITIZE_STRING);
		$proid = $_POST['pronameid'];
        $proid = filter_var($proid, FILTER_SANITIZE_NUMBER_INT);
		$price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
		$status = $_POST['chapter_status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);
		$now = date('Y-m-d');
		$now = filter_var($now, FILTER_SANITIZE_STRING);
        
        //เพิ่มรูปปกตอน
        $chapter_photo = $_FILES['chapter_photo']['name'];
        $chapter_photo = filter_var($chapter_photo, FILTER_SANITIZE_STRING);
        $chapter_photo_size = $_FILES['chapter_photo']['size'];
        $image_tmp_name_chapter_photo = $_FILES['chapter_photo']['tmp_name'];
        $image_folder = '../images/'.$chapter_photo;
        
        //เพิ่มอัพรูปหลายรูป

		$conn = $pdo->open();

			try{
				$stmt = $conn->prepare("INSERT INTO sub_products (product_id, chapter, chapter_photo, chapter_name, price, chapter_status,chapter_created) VALUES(?,?,?,?,?,?,?)");
				$stmt->execute([$proid,$chapter,$chapter_photo,$name,$price,$status,$now]);

                move_uploaded_file($image_tmp_name_chapter_photo, $image_folder);

				$_SESSION['success'] = 'Chapter added successfully';

                

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		$pdo->close();

    }else
    {
		$_SESSION['error'] = 'Fill up product form first';
	}

	header("Location: " . $_SERVER['HTTP_REFERER']);

?>