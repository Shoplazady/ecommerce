<?php include 'includes/session.php'; ?>
<?php
$conn = $pdo->open();
date_default_timezone_set('Asia/Bangkok');
$now = date('Y-m-d');
$timenow = date('H:i:s');

$slug = $_GET['chapter'];
if (isset($_GET['product_id'])) {
    $proid = $_GET['product_id'];
    $proid = filter_var($proid, FILTER_SANITIZE_NUMBER_INT);
}

/*************************************************** new **********************************************************/

if (isset($_SESSION['user'])) {
    $uid = $_SESSION['user'];
}

try {
    $stmt = $conn->prepare("SELECT *,sub_products.date_view AS sub_date_view, sub_products.chapter_name AS chapname, sub_products.chapter_status AS chapstatus, sub_products.id AS chapid, products.slug AS proback  FROM sub_products LEFT JOIN products ON sub_products.product_id = products.id WHERE chapter = :slug AND product_id = :proid");
    $stmt->execute(['slug' => $slug, 'proid' => $proid]);
    $chaptercheck = $stmt->fetch();

    $checkstatus = $chaptercheck['chapstatus'];
    $price = $chaptercheck['price'];
    $sub_id = $chaptercheck['chapid'];
    $back = $chaptercheck['proback'];
    $main_name = $chaptercheck['name'];
    $dateview = $chaptercheck['sub_date_view'];
} catch (PDOException $e) {
    echo "There is some problem in connection: " . $e->getMessage();
}

if ($checkstatus == 'Lock' && isset($_SESSION['user'])) {
    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM sub_sale WHERE sub_id=:sub_id AND user_id=:user_id");
    $stmt->execute(['sub_id' => $sub_id, 'user_id' => $uid]);
    $row = $stmt->fetch();

    if ($row['numrows'] > 0) {
        $chapter_path = $chaptercheck['chapter_path'];
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id' => $uid]);

        foreach ($stmt as $usercheck) {
            $usercoin = $usercheck['user_coin'];
        }

        if ($usercoin > 0) {
            $calcoin = $usercoin - $price;

            $stmt = $conn->prepare("UPDATE users SET user_coin=:calcoin WHERE id=:id");
            $stmt->execute(['calcoin' => $calcoin, 'id' => $uid]);

            $stmt = $conn->prepare("INSERT INTO sub_sale (sub_id, product_id, user_id, sub_sale_on, sub_sale_time) VALUES (:sub_id, :product_id, :user_id, :sub_sale_on, :sub_sale_time)");
            $stmt->execute(['sub_id' => $sub_id, 'product_id' => $proid, 'user_id' => $uid, 'sub_sale_on' => $now, 'sub_sale_time' => $timenow]);

            $_SESSION['success'] = 'Arigatou gozaimasu';
            // Redirect to the same page to refresh after the purchase
            header("Location: ".$_SERVER['PHP_SELF']."?chapter=".$slug."&product_id=".$proid);
            exit();
        } else {
            $_SESSION['error'] = 'Coin ของเจ้ามีไม่พอนะจ๊ะ';
            header('Location:product.php?product=' . $back);
            exit();
        }
    }
} elseif ($checkstatus == 'Lock' && !isset($_SESSION['user'])) {
    $_SESSION['error'] = 'กรุณากลับไปล็อกอินก่อนทำรายการด้วยงับ';
    header('Location:product.php?product=' . $back);
    exit();
} else {
    $chapter_path = $chaptercheck['chapter_path'];
}

// page view
if ($dateview == $now) {
    $stmt = $conn->prepare("UPDATE sub_products SET chapter_count=chapter_count+1 WHERE id=:id");
    $stmt->execute(['id' => $chaptercheck['chapid']]);
} else {
    $stmt = $conn->prepare("UPDATE sub_products SET chapter_count=1, date_view=:now WHERE id=:id");
    $stmt->execute(['id' => $chaptercheck['chapid'], 'now' => $now]);
}

if (isset($_SESSION['user'])) {
    $stmt = $conn->prepare("UPDATE sub_products SET chapter_u_count=chapter_u_count+1 , chapter_all_count=chapter_all_count+1  WHERE id=:id");
    $stmt->execute(['id' => $chaptercheck['chapid']]);
} else {
    $stmt = $conn->prepare("UPDATE sub_products SET chapter_all_count=chapter_all_count+1  WHERE id=:id");
    $stmt->execute(['id' => $chaptercheck['chapid']]);
}

/*************************************************** new **********************************************************/
?>


<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-yellow layout-top-nav">


    <div class="wrapper">

        <div id="mySidepanel" class="sidepanel">
            <ul class='list-group overflow-scroll'>
                <?php
                try {
                    $stmt = $conn->prepare("SELECT * FROM sub_products WHERE product_id = ?");
                    $stmt->execute([$proid]);

                    foreach ($stmt as $chapter_info) {
                        $free = ($chapter_info['chapter_status'] == 'Free') ? '<span class="label label-success">Free</span>' : '';
                        $lock = ($chapter_info['chapter_status'] == 'Lock') ? '<span class="label label-danger"><i class="bi bi-lock"></i> Lock</span>' : '';

                        if(isset($_SESSION['user'])){
                            // Check if the chapter is in sub_sale for the current user
                        $stmt_sale = $conn->prepare("SELECT * FROM sub_sale WHERE user_id = :user_id AND sub_id = :chapter_id");
                        $stmt_sale->execute(['user_id' => $_SESSION['user'], 'chapter_id' => $chapter_info['id']]);
                        $result_sale = $stmt_sale->fetch();

                        if ($result_sale) {
                            $lock = '<span class="label label-warning"><i class="bi bi-unlock"></i> Unlock</span>';
                        }
                        }
                        

                        echo "
                            <li> 
                            <a href='chapter.php?chapter={$chapter_info['chapter']}&product_id={$proid}'>
                            <img src='images/{$chapter_info['chapter_photo']}' width='70px' height='90px'> 
                            ตอนที่ {$chapter_info['chapter']} {$free}{$lock}
                            </a>
                            </li>
                            ";
                    }
                } catch (PDOException $e) {
                    echo "There is some problem in connection: " . $e->getMessage();
                }
                ?>

            </ul>
        </div>

        <?php include 'includes/navbar.php'; ?>

        <div class="content-wrapper">
            <div class="container bg-black">
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-black">
                                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                                <li class="breadcrumb-item"><a href="product.php?product=<?php echo $chaptercheck['slug']; ?>"><?php echo $main_name ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page">ตอนที่ <?php echo $chaptercheck['chapter'] . " " . $chaptercheck['chapname'] ?></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php
                            $dirname = $chapter_path;
                            $images = scandir($dirname);
                            $ignore = array(".", "..");
                            foreach ($images as $curimg) {
                                if (!in_array($curimg, $ignore)) {
                                    echo "<img width='100%' onclick='footerdown()' src='$chapter_path/$curimg' /><br>\n";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <h2><span class='label label-warning'>สุ่มการ์ตูนไปอ่านเลย</span></h2>
                    <div class="container-fluid bg-black">
                        <div class="scroll-container-wrapper">
                            <div class="scroll-container">
                                <!-- Scrollable content goes here -->
                                <?php
                                $conn = $pdo->open();

                                try {
                                    $stmt = $conn->prepare("SELECT * FROM products ORDER BY RAND() LIMIT 5");
                                    $stmt->execute();

                                    foreach ($stmt as $row) {
                                        $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';

                                        echo '
												<div class="product">
													<a href="product.php?product=' . $row['slug'] . '">
														<img  src="' . $image . '" alt="Product Image">
														<p>' . $row['name'] . '</p>
													</a>
												</div>
											';
                                    }
                                } catch (PDOException $e) {
                                    echo "There is some problem in connection: " . $e->getMessage();
                                }

                                $pdo->close();
                                ?>
                            </div>
                        </div>
                    </div>
                    <br>
            </div>

            </section>



        </div>


    </div>

    <?php $pdo->close(); ?>

    </div>

    <div id="footer">
        <div id="main">

            <?php
            try {
                $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM sub_products WHERE product_id = ?");
                $stmt->execute([$proid]);
                $totalChapters = $stmt->fetch()['total'];
            } catch (PDOException $e) {
                echo "There is some problem in connection: " . $e->getMessage();
            }
            ?>
            <a href="chapter.php?chapter=<?php echo ($_GET['chapter'] - 1); ?>&product_id=<?php echo $proid; ?>" class="btn btn-danger btn-flat <?php echo ($_GET['chapter'] <= 1) ? 'disabled' : ''; ?>"><i class="bi bi-caret-left"></i></a>
            <a class="btn btn-danger btn-flat openbtn" onclick="toggleNav()"> เลือกตอน </a>
            <a href="chapter.php?chapter=<?php echo ($_GET['chapter'] + 1); ?>&product_id=<?php echo $proid; ?>" class="btn btn-danger btn-flat <?php echo ($_GET['chapter'] >= $totalChapters) ? 'disabled' : ''; ?>"><i class="bi bi-caret-right"></i></a>

            <div class="pull-right">
                <a id="btnsubcom" class="btn btn-danger btn-flat "><i class="bi bi-chat-left-text"></i></a>
                <a id="totop" onclick="topFunction()" class="btn btn-danger btn-flat "><i class="bi bi-caret-up"></i></a>
            </div>

        </div>

    </div>
    <?php include 'includes/modal_form.php'; ?>
    <?php include 'includes/modal_comment.php'; ?>

    <?php include 'includes/scripts.php'; ?>

    <script>
        function toggleNav() {
            var element = document.getElementById("mySidepanel");
            if (element.style.width == "250px") {
                element.style.width = "0px";
            } else {
                element.style.width = "250px";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }

        function footerdown() {
            var element = document.getElementById("footer");
            if (element.style.height == "60px") {
                element.style.height = "0px";
            } else {
                element.style.height = "60px";
            }
        }
    </script>

    <script>
        function likeComment(commentId, userId) {
            // Send an AJAX request to check if the user has already liked the comment
            $.ajax({
                url: 'checksub_like.php', // Replace with the correct file name or URL for sub-comment check
                type: 'POST',
                data: {
                    comment_id: commentId,
                    user_id: userId
                },
                success: function(response) {
                    if (response === 'liked') {
                        // User has already liked the comment, do not proceed
                        alert('You have already liked this comment.');
                    } else {
                        // User has not liked the comment, proceed to increment the like count
                        incrementLikeCount(commentId);
                    }
                }
            });
        }

        function incrementLikeCount(commentId) {
            // Send an AJAX request to increment the like count
            $.ajax({
                url: 'incrementsub_like.php', // Replace with the correct file name or URL for sub-comment increment
                type: 'POST',
                data: {
                    comment_id: commentId
                },
                success: function(response) {
                    // Update the like count within the button
                    $('#likeCount' + commentId).text(response);
                }
            });
        }
    </script>

</body>

</html>