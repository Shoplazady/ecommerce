<?php include 'includes/session.php';  /* check */ ?>
<?php

$where = '';
if (isset($_GET['product'])) {
  $proid = $_GET['product'];
  $where = 'WHERE product_id =' . $proid;
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-yellow sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; /* check */ ?>
    <?php include 'includes/menubar.php'; /* check */ ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Chapter
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li>Products</li>
          <li class="active">Chapter</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addproduct"><i class="fa fa-plus"></i> New</a>
                <div class="pull-right">

                  <!--------------------------------------show จาก ชื่อเรื่องที่เลือก---------------------------------------------->
                  <form class="form-inline">
                    <div class="form-group">
                      <label>ชื่อเรื่อง : </label>
                      <select class="form-control input" id="select_product"> <!--แก้ select_category to select_product-->
                        <option value="0">ALL</option>
                        <?php
                        $conn = $pdo->open();

                        $stmt = $conn->prepare("SELECT * FROM products"); /* แก้ form category to products และแก้ $catid to proid */
                        $stmt->execute();

                        foreach ($stmt as $crow) {
                          $selected = ($crow['id'] == $proid) ? 'selected' : '';
                          echo "
                            <option value='" . $crow['id'] . "' " . $selected . ">" . $crow['name'] . "</option>
                          ";
                        }

                        $pdo->close();
                        ?>
                      </select>
                    </div>
                  </form>
                  <!----------------------------------------------------------------------------------------------------------->

                </div>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-striped table-bordered nowrap" style="width:100%">
                  <thead>
                    <th>ชื่อตอน</th>
                    <th>รูปปก</th>
                    <th>chapter state</th>
                    <th>ยอดคนดูทั้งหมด</th>
                    <th>Views Today</th>
                    <th>ราคา</th>
                    <th>Tools</th>


                  </thead>
                  <tbody>
                    <?php
                    $conn = $pdo->open();

                    try {
                      $now = date('Y-m-d');
                      $stmt = $conn->prepare("SELECT * FROM sub_products" . " " . $where); //แก้ชื่อตารางเป็น sub_products และแก้ photo to chapter_photo
                      $stmt->execute();
                      foreach ($stmt as $row) {
                        $image = (!empty($row['chapter_photo'])) ? '../images/' . $row['chapter_photo'] : '../images/noimage.jpg';
                        $counter = ($row['date_view'] == $now) ? $row['chapter_count'] : 0;
                        $status = ($row['chapter_state']) ? '<span class="label label-success">ACTIVE</span>' : '<span class="label label-danger">INACTIVE</span>';
                        $active = (!$row['chapter_state']) ? '<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id="' . $row['id'] . '"><i class="fa fa-check-square-o"></i></a></span>' : '';
                        echo "
                                <tr>
                                  <td>ตอนที่ " . $row['chapter'] . " " . $row['chapter_name'] . "</td>
                                  <td>
                                    <img src='" . $image . "' height='50px' width='50px'>
                                    <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i></a></span>
                                  </td>
                                  <td>
                                  " . $status . "
                                  " . $active . "
                                  </td>
                                  <td>
                                  {$row['chapter_all_count']}
                                  </td>
                                  <td>" . $counter . "</td>
                                  <td>" . number_format($row['price']) . " บาท</td>
                                  <td>
                                    <a href='#description' data-toggle='modal' class='btn btn-warning btn-sm btn-flat desc' data-id='" . $row['id'] . "'><i class='fa fa-plus'></i> Add</a>
                                    <a href='#' class='btn btn-info btn-sm btn-flat viewchapter' data-id='" . $row['id'] . "'><i class='fa fa-search'></i> View</a>
                                    <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Edit</button>
                                    <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                                  </td>
                                </tr>
                              ";
                      }
                    } catch (PDOException $e) {
                      echo $e->getMessage();
                    }

                    $pdo->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/products_modal3.php'; ?>
    <?php include 'includes/products_modal4.php'; ?>
    <?php include 'includes/products_modal5.php'; ?>

  </div>
  <!-- ./wrapper -->

  <?php include 'includes/scripts.php'; ?>

  <script>
    $(function() {
      $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.photo', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.desc', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.viewchapter', function(e) {
        e.preventDefault();
        $('#view_chapter').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.status', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

      $('#select_product').change(function() {
        var val = $(this).val();
        if (val == 0) {
          window.location = 'chapter.php';
        } else {
          window.location = 'chapter.php?product=' + val;
        }
      });

      $('#addproduct').click(function(e) {
        e.preventDefault();
        getCategory();
      });

      $("#addnew").on("hidden.bs.modal", function() {
        $('.append_items').remove();
      });

      $("#edit").on("hidden.bs.modal", function() {
        $('.append_items').remove();
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'chapter_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#desc').html(response.description);
          $('.chapter').html(response.chapter);
          $('.name').html(response.prodname);
          $('.prodid').val(response.prodid);
          $('#edit_pathchapter').val(response.chapter);
          $('#edit_chapter').val(response.chapter);
          $('#edit_name').val(response.prodname);
          $('#catselected').val(response.category_id).html(response.catname);
          $('#edit_price').val(response.price);
          $('.fullname').html(response.chapter + ' ' + response.prodname);
          getCategory();

          loadChapterImages(response.chapter_path);
        }
      });
    }

    function loadChapterImages(chapterPath) {
      var imageContainer = $('#imageContainer');
      imageContainer.empty();

      if (chapterPath !== "") {
        $.ajax({
          type: 'GET',
          url: 'load_images.php',
          data: {
            chapter_path: chapterPath
          },
          dataType: 'json',
          success: function(response) {
            if (response.images.length > 0) {
              response.images.forEach(function(image) {
                var imgElement = $('<img>').attr('src', image).css('width', '100%');
                imageContainer.append(imgElement);
              });
            } else {
              imageContainer.html('<p>No images found</p>');
            }
          },
          error: function() {
            imageContainer.html('<p>Error loading images</p>');
          }
        });
      } else {
        imageContainer.html('<p>No chapter path available</p>');
      }
    }


    function getCategory() {
      $.ajax({
        type: 'POST',
        url: 'products_fetch.php',
        dataType: 'json',
        success: function(response) {
          $('#product').append(response);
          $('#edit_product').append(response);
        }
      });
    }
  </script>
</body>

</html>