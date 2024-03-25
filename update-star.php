<?php
include 'includes/session.php';

$conn = $pdo->open();
$item_id = $_POST['item_id'];

// Calculate the average rating and total number of ratings for the product
$sql = "SELECT AVG(star), COUNT(*) FROM rating WHERE product_id = '$item_id'";
$stmt = $conn->query($sql);
$data = $stmt->fetch(PDO::FETCH_NUM);
$score = $data[0];
$giver = $data[1];

$full_star = intval($score);

$half_star = 0;
$f = $score - intval($score);   // Fractional part
if ($f >= 0.25 && $f <= 0.75) {
    $half_star = 1;
} elseif ($f > 0.75) {
    $full_star += 1;
}
$empty_star = 5 - ($full_star + $half_star);

echo_star($full_star, "full-star.png");
echo_star($half_star, "half-star.png");
echo_star($empty_star, "empty-star.png");

echo "(".number_format($giver).")";

$pdo->close();

function echo_star($num_star, $src) {
    for ($i = 1; $i <= $num_star; $i++) {
        echo '<img src="image-star/'.$src.'" class="img-star">';
    }
}
?>
