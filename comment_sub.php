<?php 

include 'includes/session.php';

$conn = $pdo->open();

date_default_timezone_set('Asia/Bangkok');
$date_time = date('Y-m-d H:i:s');

if(isset($_SESSION['user'])){
$userid = $_SESSION['user'];
}

if(isset($_POST['subcomment'])){

    $chapterid = $_POST['chapterid'];
    $comments = $_POST['comment'];

    try{
        $stmt = $conn->prepare("INSERT INTO sub_comment (user_id, chapter_id, sub_comment, datetime_subcom) VALUES (:user_id, :chapter_id, :sub_comment, :datetime_subcom)");
        $stmt->execute(['user_id'=>$userid,'chapter_id'=>$chapterid, 'sub_comment'=>$comments, 'datetime_subcom'=>$date_time]);
        
    }
    catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }

}

$pdo->close();
header("Location: " . $_SERVER['HTTP_REFERER']);

?>