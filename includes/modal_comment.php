<!--------------Commentmaincartoon modal------------------>
<div id="modalmaincom" class="modal fade">
    <div class="modal-dialog mb-2 p-2">
        <div class="modal-content">
            <!-- หัวข้อ-->
            <div class="modal-header text-center">
                <button class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title"><i class="bi bi-chat-right-dots"></i> Comment Chat</h2>
            </div>
            <!-- chat comments-->
            <div class="modal-body" style="max-height: 700px; overflow-y: auto; overflow-x: hidden;">
                <div class="row">
                    <ul class="list-group" style="margin-right: -15px; margin-left: -15px; overflow-y: scroll; overflow-x: hidden;">
                        <?php
                        $conn = $pdo->open();
                        try {
                            $stmt = $conn->prepare("SELECT * FROM comment LEFT JOIN users ON users.id=comment.user_id WHERE product_id=:product_id ORDER BY data_time_com DESC");
                            $stmt->execute(['product_id' => $product['prodid']]);
                            foreach ($stmt as $comment) {
                                $u_photo = (!empty($comment['fb_id'])) ? $comment['photo'] : ((!empty($comment['photo'])) ? 'images/' . $comment['photo'] : 'images/noimage.jpg');
                                $pro_comment = $comment['pro_comment'];
                                $max_length = 50; // maximum length of the comment
                                if (strlen($pro_comment) > $max_length) {
                                    $pro_comment = wordwrap($pro_comment, $max_length, "</p><p style='text-align: center;'>", true); // wrap the comment at the maximum length and add new paragraphs
                                }
                                $likeCount = $comment['like_comment'];
                                $commentId = $comment['comment_id'];
                                $userId = isset($_SESSION['user']) ? $_SESSION['user'] : null; // Check if user is logged in, otherwise set userId to null
                                
                                echo "
                                    <li class='list-group-item'>
                                        <h5><span class='label label-danger'>{$comment['firstname']} {$comment['lastname']}</span><span class='label label-primary pull-right'>{$comment['data_time_com']}</span></h5>
                                        <div class='row'>
                                            <div class='col-sm-2'>
                                                <img class='pull-left' src='{$u_photo}' width='50' height='50' alt='User Image'>
                                            </div>
                                            <div class='col-sm-10'>
                                                <p style='text-align: center;'>{$pro_comment}</p>
                                            </div>
                                        </div>
                                        <h5>" . ($userId ? "<button class='btn btn-primary btn-sm' onclick='likeComment(\"{$commentId}\", \"{$userId}\")' " . ">Like <span id='likeCount{$commentId}'>{$likeCount}</span></button>" : "Like <span class='label label-primary' id='likeCount{$commentId}'>{$likeCount}</span>") . "</h5>
                                    </li>
                                ";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        $pdo->close();
                        ?>
                    </ul>
                </div>
            </div>

            <!-- ใส่comment-->
            <div class="modal-footer">
                <div class="row">
                    <?php
                    if (!isset($_SESSION['user'])) {
                        echo '
                                <div class="text-center">
                                <h3>กรุณา <span class="label label-success"><i class="bi bi-door-open"></i> Login </span>เพื่อทำการComment&like</h3>
                                </div>
                                ';
                    } else {

                        echo '
                        <form class="form-horizontal" method="POST" action="comment_main.php" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" value="' . $product['prodid'] . '" name="productid" required>
                        <div class="col-sm-10">
                            <textarea id="editor1" class="pull-left" name="comment" rows="2" cols="8" style="width: 100%;" required></textarea>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" name="maincomment" class="btn btn-warning pull-right"><i class="bi bi-send"></i> ส่งเบย</button>
                        </div>
                    </form>
                                ';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<!--------------Commentchaptercartoon modal------------------>
<div id="modalsubcom" class="modal fade">
    <div class="modal-dialog mb-2 p-2">
        <div class="modal-content">
            <!-- หัวข้อ-->
            <div class="modal-header text-center">
                <button class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title"><i class="bi bi-chat-right-dots"></i> Comment Chat</h2>
            </div>
            <!-- chat comments-->
            <div class="modal-body" style="max-height: 700px; overflow-y: auto; overflow-x: hidden;">
                <div class="row">
                    <ul class="list-group mt-5" style="margin-right: -15px; margin-left: -15px; overflow-y: scroll; overflow-x: hidden;">
                        <?php
                        $conn = $pdo->open();
                        try {
                            $stmt = $conn->prepare("SELECT * FROM sub_comment LEFT JOIN users ON users.id=sub_comment.user_id WHERE chapter_id=:chapter_id ORDER BY datetime_subcom DESC");
                            $stmt->execute(['chapter_id' => $sub_id]);
                            foreach ($stmt as $comment) {
                                $u_photo = (!empty($comment['fb_id'])) ? $comment['photo'] : ((!empty($comment['photo'])) ? 'images/' . $comment['photo'] : 'images/noimage.jpg');
                                $pro_comment = $comment['sub_comment'];
                                $max_length = 50; // maximum length of the comment
                                if (strlen($pro_comment) > $max_length) {
                                    $pro_comment = wordwrap($pro_comment, $max_length, "</p><p style='text-align: center;'>", true); // wrap the comment at the maximum length and add new paragraphs
                                }
                                $likeCount = $comment['like_comment'];
                                $commentId = $comment['sub_com_id'];
                                $userId = isset($_SESSION['user']) ? $_SESSION['user'] : null; // Check if user is logged in, otherwise set userId to null
                                
                                echo "
                                        <li class='list-group-item'>
                                            <h5><span class='label label-danger'>{$comment['firstname']} {$comment['lastname']}</span><span class='label label-primary pull-right'>{$comment['datetime_subcom']}</span></h5>
                                            <div class='row'>
                                                <div class='col-sm-2'>
                                                    <img class='pull-left' src='{$u_photo}' width='50' height='50' alt='User Image'>
                                                </div>
                                                <div class='col-sm-10'>
                                                    <p style='text-align: center;'>{$pro_comment}</p>
                                                </div>
                                            </div>
                                            <h5>" . ($userId ? "<button class='btn btn-primary btn-sm' onclick='likeComment(\"{$commentId}\", \"{$userId}\")' " . ">Like <span id='likeCount{$commentId}'>{$likeCount}</span></button>" : "Like <span class='label label-primary' id='likeCount{$commentId}'>{$likeCount}</span>") . "</h5>
                                        </li>
                                        ";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        $pdo->close();
                        ?>
                    </ul>
                </div>
            </div>

            <!-- ใส่comment-->
            <div class="modal-footer">
                <div class="row">
                    <?php
                    if (!isset($_SESSION['user'])) {
                        echo '
                                <div class="text-center">
                                <h3>กรุณา <span class="label label-success"><i class="bi bi-door-open"></i> Login </span>เพื่อทำการComment&like</h3>
                                </div>
                                ';
                    } else {

                        echo '
                                <form class="form-horizontal" method="POST" action="comment_sub.php" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" value="' . $sub_id . '" name="chapterid" required>
                                <div class="col-sm-10">
                                    <textarea id="editor1" class="pull-left" name="comment" rows="2" cols="8" style="width: 100%;" required></textarea>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" name="subcomment" class="btn btn-warning pull-right"><i class="bi bi-send"></i> ส่งเบย</button>
                                </div>
                                </form>
                                ';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>