<?php include 'includes/session.php'; ?>
<?php
// load_more.php

// Establish a database connection using PDO
$conn = $pdo->open();

// Retrieve the POST data
$limit = $_POST['limit'];
$offset = $_POST['offset'];
$slug = $_POST['slug'];
$order = $_POST['order'];

// Fetch the next set of chapters based on the limit and offset
$stmt = $conn ->prepare("SELECT *, products.id AS proid, sub_products.id AS chapterid FROM products LEFT JOIN sub_products ON products.id=sub_products.product_id WHERE slug = :slug ORDER BY CAST(chapter AS UNSIGNED) $order LIMIT $limit OFFSET $offset");
$stmt->execute(['slug' => $slug]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the results
foreach ($results as $chapter_ch) {
    $chapimage = (!empty($chapter_ch['chapter_photo'])) ? 'images/' . $chapter_ch['chapter_photo'] : 'images/noimage.jpg';
    $free = ($chapter_ch['chapter_status'] == 'Free') ? '<span class="label label-success">Free</span>' : '';
    $lock = ($chapter_ch['chapter_status'] == 'Lock') ? '<span class="label label-danger"><i class="bi bi-lock"></i> Lock</span>' : '';

    // Check if the chapter is unlocked for the logged-in user
    if (isset($_SESSION['user'])) {
        $userId = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT * FROM sub_sale WHERE user_id = :user_id AND sub_id = :chapter_id");
        $stmt->execute(['user_id' => $userId, 'chapter_id' => $chapter_ch['chapterid']]);
        $result = $stmt->fetch();

        if ($result) {
            $lock = '<span class="label label-warning"><i class="bi bi-unlock"></i> Unlock</span>';
        } else {
            $lock = ($chapter_ch['chapter_status'] == 'Lock') ? '<span class="label label-danger"><i class="bi bi-lock"></i> Lock</span>' : '';
        }
    }

    echo "
            
            <a href='chapter.php?chapter={$chapter_ch['chapter']}&product_id={$chapter_ch['proid']}'>
            <li class='list-group-item list-group-item-action bg-black' aria-current='true'>
            <span class='pull-left'>
                <img src='$chapimage' width='70px' height='90px'>
            </span>
            <h5 class='mb-1'>&nbsp;&nbsp;ตอนที่ {$chapter_ch['chapter']} {$chapter_ch['chapter_name']}
            </a>
            <span class='pull-right'>" . $free . "" . $lock . "</span></h5>
            <p class='mb-1'>&nbsp;&nbsp;<i class='bi bi-eye'></i> {$chapter_ch['chapter_all_count']}</p>
            <small>&nbsp;&nbsp;<i class='bi bi-chat'></i> ...</small>
            <small class='pull-right'><span class='label label-warning'><i class='bi bi-calendar-plus'></i> {$chapter_ch['chapter_created']}</span></small>
            </li>
        ";
}

$pdo->close(); // Close the database connection
?>