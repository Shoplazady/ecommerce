<?php include 'includes/session.php'; ?>
<?php
// Establish a database connection using PDO
$conn = $pdo->open();

// Fetch products based on the search term
$searchTerm = $_POST['keyword'];
$query = $conn->prepare("SELECT id, name, slug, photo FROM products WHERE name LIKE ?");
$query->execute(["%$searchTerm%"]);
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// Output the results as JSON
header('Content-Type: application/json');
echo json_encode($results);
?>
