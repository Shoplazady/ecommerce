<?php include 'includes/session.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment_id'];
    $userId = $_SESSION['user'];

    // Perform the database update here
    $conn = $pdo->open();
    try {
        // Check if the user has already liked the comment
        $stmt = $conn->prepare("SELECT * FROM sublike_comment WHERE sub_com_id = :comment_id AND user_id = :user_id");
        $stmt->execute(['comment_id' => $commentId, 'user_id' => $userId]);
        if ($stmt->rowCount() > 0) {
            // User has already liked the comment, delete the like
            $stmt = $conn->prepare("DELETE FROM sublike_comment WHERE sub_com_id = :comment_id AND user_id = :user_id");
            $stmt->execute(['comment_id' => $commentId, 'user_id' => $userId]);

            // Decrement the like count in the comment table
            $stmt = $conn->prepare("UPDATE sub_comment SET like_comment = like_comment - 1 WHERE sub_com_id = :comment_id");
            $stmt->execute(['comment_id' => $commentId]);
        } else {
            // User hasn't liked the comment, increment the like count and insert the like
            $stmt = $conn->prepare("UPDATE sub_comment SET like_comment = like_comment + 1 WHERE sub_com_id = :comment_id");
            $stmt->execute(['comment_id' => $commentId]);

            $stmt = $conn->prepare("INSERT INTO sublike_comment (sub_com_id, user_id) VALUES (:comment_id, :user_id)");
            $stmt->execute(['comment_id' => $commentId, 'user_id' => $userId]);
        }

        // Get the updated like count
        $stmt = $conn->prepare("SELECT like_comment FROM sub_comment WHERE sub_com_id = :comment_id");
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