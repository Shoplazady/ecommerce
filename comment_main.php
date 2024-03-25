<?php 

include 'includes/session.php';

$conn = $pdo->open();

date_default_timezone_set('Asia/Bangkok');
$date_time = date('Y-m-d H:i:s');

if(isset($_SESSION['user'])){
$userid = $_SESSION['user'];
}

if(isset($_POST['maincomment'])){

    $productid = $_POST['productid'];
    $comments = $_POST['comment'];

    try{
        $stmt = $conn->prepare("INSERT INTO comment (user_id, product_id, pro_comment, data_time_com) VALUES (:user_id, :product_id, :pro_comment, :data_time_com)");
        $stmt->execute(['user_id'=>$userid,'product_id'=>$productid, 'pro_comment'=>$comments, 'data_time_com'=>$date_time]);
        
    }
    catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }

}

$pdo->close();
header("Location: " . $_SERVER['HTTP_REFERER']);

?>


