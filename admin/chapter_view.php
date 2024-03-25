<?php include 'includes/session.php'; ?>
<?php
$conn = $pdo->open();

$id = $_GET['id'];
try {
    $stmt = $conn->prepare("SELECT * FROM sub_products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $chapter = $stmt->fetch();
} catch (PDOException $e) {
    echo "There is some problem in connection: " . $e->getMessage();
}
$chapter_path = $chapter['chapter_path'];




?>
<?php include 'includes/header.php'; ?>
<body>
<div class="wrapper">
<div class="content-wrapper">
            <div class="container">
                <!-- Main content -->
                <section class="content">
                <div class="row">
                        <div class="col">
                            <?php
                            $dirname = $chapter_path;
                            $images = scandir($dirname);
                            $ignore = array(".", "..");
                            foreach ($images as $curimg) {
                                if (!in_array($curimg, $ignore)) {
                                    echo "<img width='100%' src='$chapter_path/$curimg' /><br>";
                                }
                            }
                            ?>
                        </div>
                        <br>
                    </div>
                    <br>

            </div>
            </section>

</div>
</div>
</body>
</html>
