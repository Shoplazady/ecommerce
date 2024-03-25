<?php include 'includes/session.php';  /* check */ ?>
<?php
  $where = '';
  if(isset($_GET['category'])){                             // get category จาก funtions getCategory() category_fetch.php เพื่อใช้กับ #category #edit_category เป้น json
    $catid = $_GET['category'];                             // แก้ เปลี่ยน get category to get products จาก funtions getCategory() to getProducts() products_fetch.php ใช้กับ #products #edit_products เป้น json
    $where = 'WHERE category_id ='.$catid;
  }

?>
<?php include 'includes/header.php'; /* check */ ?>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; /* check */ ?>
  <?php include 'includes/menubar.php'; /* check */ ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Products</li>
        <li class="active">Product List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
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
                <!--------------------------------------show จาก หมวดหมู่ที่เลือก------------------------------------------------>
                <form class="form-inline">
                  <div class="form-group">
                    <label>หมวดหมู่: </label>
                    <select class="form-control input-sm" id="select_category"> <!--แก้ select_category to select_product-->
                      <option value="0">ALL</option>
                      <?php
                        $conn = $pdo->open();

                        $stmt = $conn->prepare("SELECT * FROM category"); /* แก้ form category to products และแก้ $catid to proid */
                        $stmt->execute();

                        foreach($stmt as $crow){
                          $selected = ($crow['id'] == $proid) ? 'selected' : ''; 
                          echo "
                            <option value='".$crow['id']."' ".$selected.">".$crow['name']."</option>
                          ";
                        }

                        $pdo->close();
                      ?>
                    </select>
                  </div>
                </form>
                <!------------------------------------------------------------------------------------------------------------->
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                  <th>ชื่อเรื่อง</th>
                  <th>รูปปก</th>
                  <th>เรื่องย่อ</th>
                  <th>Status</th>
                  <th>Views Today</th>
                  <th>ราคา</th> 
                  <th>Tools</th>
                  
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $now = date('Y-m-d');
                      $stmt = $conn->prepare("SELECT * FROM products $where"); //แก้ชื่อตารางเป็น sub_products และแก้ photo to chapter_photo
                      $stmt->execute();
                      foreach($stmt as $row){
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                        $counter = ($row['date_view'] == $now) ? $row['counter'] : 0;
                        $status = ($row['product_status']) ? '<span class="label label-success">ACTIVE</span>' : '<span class="label label-danger">INACTIVE</span>';
                        $active = (!$row['product_status']) ? '<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="fa fa-check-square-o"></i></a></span>' : '';
                        echo "
                          <tr>
                            <td>".$row['name']."</td>
                            <td>
                              <img src='".$image."' height='30px' width='30px'>
                              <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='".$row['id']."'><i class='fa fa-edit'></i></a></span>
                            </td>
                            <td><a href='#description' data-toggle='modal' class='btn btn-info btn-sm btn-flat desc' data-id='".$row['id']."'><i class='fa fa-search'></i> View</a></td>
                            <td>
                            ".$status."
                            ".$active."
                            </td>
                            <td>".$counter."</td>
                            <td>".number_format($row['price'])." บาท</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                            </td> 
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
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

    <?php include 'includes/products_modal.php'; /* check */ ?>

    <?php  include 'includes/products_modal2.php';  /*check */ ?>

</div>

<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.desc', function(e){
    e.preventDefault();
    var id = $(this).data('id');                     //ดู
    getRow(id);
  });

  $(document).on('click', '.status', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

  $('#select_category').change(function(){
    var val = $(this).val();
    if(val == 0){
      window.location = 'products.php';                   //แก้#select_products แก้ เป็นchapter2.php
    }
    else{
      window.location = 'products.php?category='+val;     //'products.php?category='+val to 'chapter2.php?products='+val
    }
  });

  $('#addproduct').click(function(e){
    e.preventDefault();
    getCategory(); //getProducts() 
  });

  $("#addnew").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

  $("#edit").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'products_row.php',                                  //sub_products_row.php
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#desc').html(response.description);                  //ไม่ได้ใช้
      $('.name').html(response.prodname);                     //.chapter_name
      $('.prodid').val(response.prodid);                      //.subproid
      $('#edit_name').val(response.prodname);                 //#edit_chapter_name
      $('#catselected').val(response.category_id).html(response.catname); //#proselected
      $('#edit_price').val(response.price);                   
      CKEDITOR.instances["editor2"];
      getCategory();//getProducts() 
    }
  });
}
function getCategory(){
  $.ajax({
    type: 'POST',
    url: 'category_fetch.php',              //category_fetch.php to products_fetch.php
    dataType: 'json',
    success:function(response){
      $('#category').append(response);      //#products
      $('#edit_category').append(response); //#edit_products
    }
  });
}
</script>
</body>
</html>
