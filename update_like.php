<?php include 'includes/session.php'; ?>
<?php
// update_like.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment_id'];

    // Perform the database update here, for example:
    $conn = $pdo->open();
    try {
        $stmt = $conn->prepare("UPDATE comment SET like_comment = like_comment + 1 WHERE comment_id = :comment_id");
        $stmt->execute(['comment_id' => $commentId]);

        // Get the updated like count
        $stmt = $conn->prepare("SELECT like_comment FROM comment WHERE comment_id = :comment_id");
        $stmt->execute(['comment_id' => $commentId]);
        $result = $stmt->fetchColumn();

        // Return the updated like count as the response
        echo $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $pdo->close();
}
?>