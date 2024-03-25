<?php
    include 'includes/session.php';

    if(isset($_POST['add'])){
        if(isset($_POST['tag1']) || isset($_POST['tag2']) || isset($_POST['tag3']) ){
        $tag1 = $_POST['tag1'];
        $tag2 = $_POST['tag2'];
        $tag3 = $_POST['tag3'];
        }
        $name = $_POST['name'];
        $aurname = $_POST['aurname'];
        $slug = $name;
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $filename = $_FILES['photo']['name'];
        $now = date('Y-m-d');
        $conn = $pdo->open();

        if(!empty($filename)){
            $new_filename = $slug.'.'.pathinfo($filename, PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
        }
        else{
            $new_filename = '';
        }

        try{
            $stmt = $conn->prepare("INSERT INTO products (category_id, tag1_id, tag2_id, tag3_id, name, description, author, slug, price, photo, date_pro_created) VALUES (:category, :tag1 ,:tag2 , :tag3, :name, :description, :author, :slug, :price, :photo, :date_pro_created)");
            $stmt->execute(['category'=>$category, 'tag1'=>$tag1, 'tag2'=>$tag2, 'tag3'=>$tag3, 'name'=>$name, 'description'=>$description,'author'=>$aurname, 'slug'=>$slug, 'price'=>$price, 'photo'=>$new_filename,'date_pro_created'=>$now]);
            $_SESSION['success'] = 'Product added successfully';
        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
        }

        $pdo->close();	
    }
    else{
        $_SESSION['error'] = 'Fill up product form first';
    }

    header('location: products.php');
?>