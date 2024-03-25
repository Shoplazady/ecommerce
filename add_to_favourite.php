<?php
include 'includes/session.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect the user to the login page or show an error message
    exit("เข้าสู่ระบบก่อนติดตามด้วยน้า~");
}

// Get the user ID and product ID
$userId = $_SESSION['user'];
$productId = $_POST['product_id']; // Assuming you have the product ID available

// Add or remove the product from the user's favorite list in the database
$conn = $pdo->open();
try {
    // Check if the product is already in the user's favorites
    $stmt = $conn->prepare("SELECT * FROM favourite_manga WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    $result = $stmt->fetch();

    if (!$result) {
        // If the product is not in the user's favorites, insert it into the database
        $stmt = $conn->prepare("INSERT INTO favourite_manga (user_id, product_id) VALUES (:user_id, :product_id)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);

        // Send a success response
        echo "ขอต้อนรับเข้าสู่สาวก";
    } else {
        // If the product is already in the user's favorites, delete it from the database
        $stmt = $conn->prepare("DELETE FROM favourite_manga WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);

        // Send a success response
        echo "จะเลิกติดตามจริงๆน่ะเรอะ";
    }
} catch (PDOException $e) {
    // Handle any errors that occur during the database operation
    echo "error";
}

$pdo->close();
?>