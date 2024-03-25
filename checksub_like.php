<?php include 'includes/session.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment_id'];
    $userId = $_SESSION['user'];

    // Perform the check if the user has already liked the comment here
    $conn = $pdo->open();
    try {
        // Check if the user has already liked the comment
        $stmt = $conn->prepare("SELECT * FROM sublike_comment WHERE sub_com_id = :comment_id AND user_id = :user_id");
        $stmt->execute(['comment_id' => $commentId, 'user_id' => $userId]);
        if ($stmt->rowCount() > 0) {
            echo 'liked';
        } else {
            echo 'not_liked';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $pdo->close();
}
?>