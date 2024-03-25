<?php
include 'includes/session.php';

$conn = $pdo->open();

$item_id = $_POST['item_id'];
$star = $_POST['num_star'];

$user_id = $_SESSION['user']; // Assuming you have stored the user's ID in the session

// Check if the user has already rated the product
$stmt = $conn->prepare("SELECT * FROM rating WHERE product_id = :item_id AND user_id = :user_id");
$stmt->execute(['item_id' => $item_id, 'user_id' => $user_id]);
if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "เรื่องนี้ให้ดาวไปแล้วน้า~";
        echo "<script>window.location.reload();</script>";
} else {
    // Insert the rating into the database
    $sql = "INSERT INTO rating (product_id, user_id, star) VALUES ('$item_id', '$user_id', '$star')";
    $stmt = $conn->exec($sql);
    
        
    $_SESSION['success'] = "ขอบคุณสำหรับคะแนนน้า~";
    echo "<script>window.location.reload();</script>";
    
}

$pdo->close();

?>

