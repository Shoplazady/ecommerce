<?php
    include 'includes/session.php';
    $conn = $pdo->open();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        $productId = $_POST['product_id'];

        if ($action === 'add_to_cart') {
            if (isset($_SESSION['user'])) {
                // User is logged in, add the product to the cart
                $userId = $_SESSION['user'];

                // Check if the product is already in the cart for the user
                $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
                $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
                $row = $stmt->fetch();

                if ($row['numrows'] < 1) {
                    // Product is not in the cart, insert it
                    try {
                        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)");
                        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
                        $_SESSION['success'] = 'เพิ่มเหรียญลงตระกล้าเรียบร้อยแล้ว';
                    } catch (PDOException $e) {
                        $_SESSION['error'] = 'Error adding item to cart: ' . $e->getMessage();
                    }
                } else {
                    $_SESSION['error'] = 'สินค้าชิ้นนี้มีอยู่ในตระกล้าแล้ว';
                }
            } else {
                // User is not logged in, handle accordingly
                $_SESSION['error'] = 'กรุณาล็อกอินก่อนทำรายการสั่งซื้อหรือเพิ่มเหรียญลงตระกล้า';
            }
        } else {
            // Handle other form actions or validation here
        }
    }
    $pdo->close();
    header("Location: ".$_SERVER['HTTP_REFERER']);
?>
