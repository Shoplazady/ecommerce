<!-- check -->
<!-- Description -->
<div class="modal fade" id="description">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b> เพิ่มรูปภาพ ตอนที่ <span class="chapter"></span> <span class="name"></span></b></h4>
      </div>
      <!--เพิ่มรูปภาพเข้าไฟล์ตอน และ save path ลง database-->
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="chapter_multi_up.php" enctype="multipart/form-data">
          <input type="hidden" class="prodid" name="id">
          <div class="form-group">
            <label class="col-sm-2 control-label">ชื่อเรื่อง</label>
            <div class="col-sm-4">
              <select class="form-control input" name="chaptername" required>
                <option>-- เลือกชื่อเรื่อง --</option>
                <?php
                $conn = $pdo->open();
                $stmt = $conn->prepare("SELECT * FROM products");
                $stmt->execute();

                foreach ($stmt as $crow) {
                  echo "
                            <option value='" . $crow['name'] . "'>" . $crow['name'] . "</option>
                          ";
                }

                $pdo->close();
                ?>
              </select>
            </div>
            <label for="chapter" class="col-sm-2 control-label">ตอนที่</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="edit_pathchapter" name="chapter" required>
            </div>
          </div>
          <div class="form-group">
            <!--------------เลือก folder ที่จะ save------------------->
            <label class="col-sm-2 control-label">หมวดหมู่</label>
            <div class="col-sm-3">
              <select class="form-control input" name="categoryname" required>
                <option>-- หมวดหมู่ --</option>
                <?php
                $conn = $pdo->open();

                $stmt = $conn->prepare("SELECT * FROM category LIMIT 3");
                $stmt->execute();

                foreach ($stmt as $crow) {
                  echo "
                            <option value=" . $crow['name'] . ">" . $crow['name'] . "</option>
                          ";
                }

                $pdo->close();
                ?>
              </select>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <div class="col-sm-12">
            <label class="col-sm-2 control-label">เพิ่มภาพ</label>
            <ul id="media-list" class="clearfix">
                    <li class="myupload">
                        <span>
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <input type="file" click-type="type2" name="chapter_multi_pic[]" accept="image/jpg, image/jpeg, image/png, image/webp" id="picupload" class="picupload" multiple>
                        </span>
                    </li>
                </ul>
            </div>   
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
        <button type="submit" class="btn btn-primary btn-flat" name="multi_up"><i class="fa fa-save"></i> เพิ่ม</button>
        </form>
      </div>
      <!------------------------------------------------>
    </div>
  </div>
</div>


<!-- check -->
<!-- Add -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>เพิ่มตอนใหม่</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="chapter_add.php" enctype="multipart/form-data"> <!-- เพิ่ม products_add.php -->
          <div class="form-group">

            <label for="chapter" class="col-sm-1 control-label">ตอนที่</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="chapter" name="chapter" required>
            </div>

            <label for="chapter_name" class="col-sm-1 control-label">ชื่อ</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="chapter_name" name="chapter_name" required>
            </div>
          </div>

          <div class="form-group">

            <label for="product_id" class="col-sm-1 control-label">เรื่อง</label>
            <div class="col-sm-5">
              <select class="form-control input-sm" name="pronameid" required>
                <option>- เลือกเรื่องหลัก -</option>
                <?php
                $conn = $pdo->open();

                $stmt = $conn->prepare("SELECT * FROM products");
                $stmt->execute();

                foreach ($stmt as $crow) {
                  echo "
                            <option value='" . $crow['id'] . "'>" . $crow['name'] . "</option>
                          ";
                }

                $pdo->close();
                ?>
              </select>
            </div>

            <label for="price" class="col-sm-1 control-label">ราคา</label>

            <div class="col-sm-5">
              <input type="text" class="form-control" id="price" name="price" required>
            </div>
          </div>
          <div class="form-group">
            <label for="price" class="col-sm-1 control-label">Status</label>

            <div class="col-sm-5">
              <select class="form-control input-sm" name="chapter_status" required>
                <option>- เลือกสถานะ -</option>
                <option value="Free">Free</option>
                <option value="Lock">Lock</option>
              </select>
            </div>
          </div>
          <hr>
            <div class="form-group">
            
           <label for="chapter_photo" class="col-sm-1 control-label">รูปปก</label>
            <div class="col-sm-5">
              <input type="file" name="chapter_photo" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
            </div>
            
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
        <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> เพิ่ม</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- check -->
<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>ตอนที่ <span class="chapter"></span> <span class="name"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="chapter_photo.php" enctype="multipart/form-data"> <!-- ส่งรูปไปเก็บ products_photo.php -->
          <input type="hidden" class="prodid" name="id">
          <div class="form-group">
            <label for="chapter_photo" class="col-sm-3 control-label">รูปปก</label>

            <div class="col-sm-9">
              <input type="file" id ="chapter_photo" name="chapter_photo" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
        <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i> อัพเดท</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Activate -->
<div class="modal fade" id="activate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><b>Activating... ตอนที่ <span class="chapter"></span> <span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="chapter_activate.php">
                <input type="hidden" class="prodid" name="id">
                <div class="text-center">
                    <p>ACTIVATE CHAPTER</p>
                    <h2><b>ตอนที่ <span class="bold fullname"></span></b></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="activate"><i class="fa fa-check"></i> Activate</button>
              </form>
            </div>
        </div>
    </div>
</div> 