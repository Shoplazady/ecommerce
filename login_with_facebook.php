<?php 

include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fbId = $_POST['fb_id'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $photoUrl = $_POST['photo_url'];
 
  $conn = $pdo->open();

  try {
    
    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email OR fb_id = :fb_id");
    $stmt->execute(['email' => $email, 'fb_id' => $fbId]);
    $row = $stmt->fetch();

    if ($row) {
      // User exists, set the user's ID as the session variable
      $_SESSION['user'] = $row['id'];
      $response = ['success' => true, 'message' => 'Logged in successfully'];
    } else {
      // User does not exist, insert the user's information into the database
      $stmt = $conn->prepare("INSERT INTO users (fb_id, email, name, photo) VALUES (:fb_id, :email, :name, :photo)");
      $stmt->execute(['fb_id' => $fbId, 'email' => $email, 'name' => $name, 'photo' => $photoUrl]);

      $userId = $conn->lastInsertId();
      $_SESSION['user'] = $userId;

      $response = ['success' => true, 'message' => 'Registered and logged in successfully'];
    }
  } catch (PDOException $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
  }

  $conn = null;

  // Send the response back to the JavaScript code
  echo json_encode($response);
} else {
  // Invalid request
  http_response_code(400);
}

?>
