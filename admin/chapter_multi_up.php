<?php 
include 'includes/session.php';

if (isset($_POST['multi_up'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $chapname = filter_var($_POST['chaptername'], FILTER_SANITIZE_STRING);
    $chapter = filter_var($_POST['chapter'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['categoryname'], FILTER_SANITIZE_STRING);

    $countfiles = count($_FILES['chapter_multi_pic']['name']);
    for ($i = 0; $i < $countfiles; $i++) {
        $filename = $_FILES['chapter_multi_pic']['name'][$i];
        $location = "../upload_manga/{$category}/{$chapname}/ตอนที่ {$chapter}/{$filename}";

        // Create directory if not exists        
        if (!file_exists(dirname($location))) {
            mkdir(dirname($location), 0777, true);
        }

        if (!file_exists($location)) {
            $extension = pathinfo($location, PATHINFO_EXTENSION);
            $extension = strtolower($extension);
            $valid_extensions = ["jpg", "jpeg", "png", "webp"];

            if (in_array(strtolower($extension), $valid_extensions)) {
                move_uploaded_file($_FILES['chapter_multi_pic']['tmp_name'][$i], $location);
                $_SESSION['success'] = 'Chapter_multi_pic added successfully';
            } else {
                $oldname = pathinfo($_FILES['chapter_multi_pic']['tmp_name'][$i], PATHINFO_FILENAME);
                $ext = pathinfo($_FILES['chapter_multi_pic']['tmp_name'][$i], PATHINFO_EXTENSION);

                do {
                    $r = rand();
                    $newname = "{$oldname}_{$r}.{$ext}";
                    $location = "../upload_manga/{$category}/{$chapname}/ตอนที่ {$chapter}/{$newname}";
                } while (file_exists($location));

                move_uploaded_file($_FILES['chapter_multi_pic']['tmp_name'][$i], $location);
            }
        }
    }

    try {
        $conn = $pdo->open();
        $stmt = $conn->prepare("UPDATE sub_products SET chapter_path='upload_manga/{$category}/{$chapname}/ตอนที่ {$chapter}' WHERE chapter=? AND id=?");
        $stmt->execute([$chapter, $id]);
        $_SESSION['success'] = 'Chapter_multi_pic added successfully';
        $pdo->close();
    } catch(PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
} else {
    $_SESSION['error'] = 'Fill up product form first';
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>