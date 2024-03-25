<!-- check -->
<!-- Description -->
<div class="modal fade" id="description">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
                <p id="desc"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
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
              <h4 class="modal-title"><b>เพิ่มมังงะใหม่</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_add.php" enctype="multipart/form-data"> <!-- เพิ่ม products_add.php -->
                <div class="form-group">
                  <label for="name" class="col-sm-1 control-label">ชื่อ</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>

                  <label for="category" class="col-sm-2 control-label">หมวดหมู่</label>

                  <div class="col-sm-3">
                    <select class="form-control" id="category" name="category" required>
                      <option value="" selected>- เลือกหมวดหมู่ -</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="price" class="col-sm-1 control-label">ราคา</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="price" name="price" required>
                  </div>

                  <label for="photo" class="col-sm-3 control-label">รูปปก</label>

                  <div class="col-sm-4">
                    <input type="file" id="photo" name="photo">
                  </div>
                </div>

                <div class="form-group">
                
                  <label  class="col-sm-1 control-label">Tags</label>

                  <div class="col-sm-2 ">
                  <select class="form-control input-sm" name="tag1" >
                          <option style="text-align: center">--เพิ่มแท็ก--</option>
                          <?php
                          $conn = $pdo->open();
                          $stmt = $conn->prepare("SELECT * FROM sub_category");
                          $stmt->execute();
                            foreach($stmt as $crow){ 
                              echo "
                                <option value='".$crow['id']."'>".$crow['name']."</option>
                              ";
                           }
                           $pdo->close();
                          ?>
                  </select>
                  </div>

                  <div class="col-sm-2">
                  <select class="form-control input-sm" name="tag2" >
                          <option style="text-align: center">--เพิ่มแท็ก--</option>
                          <?php
                          $conn = $pdo->open();
                          $stmt = $conn->prepare("SELECT * FROM sub_category");
                          $stmt->execute();
                            foreach($stmt as $crow){ 
                              echo "
                                <option value='".$crow['id']."'>".$crow['name']."</option>
                              ";
                           }
                           $pdo->close();
                          ?>
                  </select>
                  </div>

                  <div class="col-sm-2">
                  <select class="form-control input-sm" name="tag3" >
                          <option style="text-align: center">--เพิ่มแท็ก--</option>
                          <?php
                          $conn = $pdo->open();
                          $stmt = $conn->prepare("SELECT * FROM sub_category");
                          $stmt->execute();
                            foreach($stmt as $crow){ 
                              echo "
                                <option value='".$crow['id']."'>".$crow['name']."</option>
                              ";
                           }
                           $pdo->close();
                          ?>
                  </select>
                  

                  </div>

                  <label class="col-sm-1 control-label">Author</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="aurname" required>
                  </div>

                </div>
                <p><b>เรื่องย่อ :</b></p>
                <div class="form-group">
                
                  <div class="col-sm-12">
                    <textarea id="editor1" name="description" rows="10" cols="42" required></textarea>
                  </div>
                  
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> บันทึก</button>
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
              <h4 class="modal-title"><b><span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_photo.php" enctype="multipart/form-data"> 
                <input type="hidden" class="prodid" name="id">
                <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">รูปปก</label>

                    <div class="col-sm-9">
                      <input type="file" id="photo" name="photo" required>
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
                  <h4 class="modal-title"><b>Activating... เรื่อง <span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_activate.php">
                <input type="hidden" class="prodid" name="id">
                <div class="text-center">
                    <p>ACTIVATE CHAPTER</p>
                    <h2><b>เรื่อง <span class="bold name"></span></b></h2>
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