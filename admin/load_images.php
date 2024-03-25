<?php
include 'includes/session.php';

if (isset($_GET['chapter_path'])) {
    $chapterPath = $_GET['chapter_path'];
    $dirname = "../" . $chapterPath;
    $images = scandir($dirname);
    $ignore = array(".", "..");
    $imagePaths = array();

    foreach ($images as $curimg) {
        if (!in_array($curimg, $ignore)) {
            $imagePaths[] = '../' . $chapterPath . '/' . $curimg;
        }
    }

    if (!empty($imagePaths)) {
        echo json_encode(['images' => $imagePaths]);
    } else {
        echo json_encode(['message' => 'ไม่มีภาพ']);
    }
}
?>