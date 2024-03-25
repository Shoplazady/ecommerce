<?php

	include 'includes/session.php';

	if(isset($_POST['signup'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];

		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		$_SESSION['email'] = $email;

		if($password != $repassword){
			$_SESSION['error'] = 'Passwords did not match';
		}
		else{
			$conn = $pdo->open();

			$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
				$_SESSION['error'] = 'Email already taken';
			}
			else{
				$now = date('Y-m-d');
				$password = password_hash($password, PASSWORD_DEFAULT);

				try{
					$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, created_on) VALUES (:email, :password, :firstname, :lastname, :now)");
					$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'now'=>$now]);
					$userid = $conn->lastInsertId();

					$_SESSION['success'] = "<h2>ขอต้อนรับสู่ครอบครัว</h2>";

				}
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
				}

				$pdo->close();

			}
			header("Location: " . $_SERVER['HTTP_REFERER']);

		}

	}
	else{
		$_SESSION['error'] = 'โปรดกรอกรายละเอียดให้ครบด้วยงับ';
		header('Location:index.php');
	}

?>