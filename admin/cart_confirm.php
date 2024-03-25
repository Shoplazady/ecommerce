<?php
include 'includes/session.php';

if (isset($_POST['confirm'])) {
    $userid = $_POST['userid'];
    $cartid = $_POST['cartid'];
    $payid = $_POST['pay'];
    $date = date('Y-m-d');

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)");
        $stmt->execute(['user_id' => $userid, 'pay_id' => $payid, 'sales_date' => $date]);
        $salesid = $conn->lastInsertId();

        $stmt = $conn->prepare("SELECT cart.*, products.product_coin FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
        $stmt->execute(['user_id' => $userid]);

        $totalcoin = 0;
        $details = [];
        foreach ($stmt as $row) {
            $subcoin = $row['product_coin'] * $row['quantity'];
            $totalcoin += $subcoin;
            $details[] = ['sales_id' => $salesid, 'product_id' => $row['product_id'], 'quantity' => $row['quantity']];
        }

        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
        foreach ($details as $detail) {
            $stmt->execute($detail);
        }

        $stmt = $conn->prepare("SELECT user_coin FROM users WHERE id=:user_id");
        $stmt->execute(['user_id' => $userid]);
        $ucoin = $stmt->fetchColumn();
        $ucoin += $totalcoin;

        $stmt = $conn->prepare("UPDATE users SET user_coin=:user_coin WHERE id=:user_id");
        $stmt->execute(['user_coin' => $ucoin, 'user_id' => $userid]);

        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
        $stmt->execute(['user_id' => $userid]);

        $conn->commit();

        $_SESSION['success'] = 'ยืนยันการซื้อเหรียญสำเร็จ';
    } catch (PDOException $e) {
        $conn->rollBack();
        $_SESSION['error'] = $e->getMessage();
    }

    $pdo->close();
}

header('location: cart.php?user=' . $userid);
?>