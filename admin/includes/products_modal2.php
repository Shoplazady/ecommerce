<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>ลบสินค้า...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_delete.php">
                <input type="hidden" class="prodid" name="id">
                <div class="text-center">
                    <p>ลบสินค้าชื่อ</p>
                    <h2 class="bold name"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
              <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> ลบ</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>แก้ไขสินค้า</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_edit.php">
                <input type="hidden" class="prodid" name="id">
                <div class="form-group">
                  <label for="edit_name" class="col-sm-1 control-label">ชื่อ</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_name" name="name">
                  </div>

                  <label for="edit_category" class="col-sm-2 control-label">หมวดหมู่</label>

                  <div class="col-sm-3">
                    <select class="form-control" id="edit_category" name="category">
                      <option selected id="catselected"></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_price" class="col-sm-1 control-label">ราคา</label>

                  <div class="col-sm-1">
                    <input type="text" class="form-control" id="edit_price" name="price">
                  </div>

                  <label for="edit_price" class="col-sm-1 control-label">Coin</label>

                  <label for="edit_price" class="col-sm-1 control-label">Status</label>

                  <div class="col-sm-2">
                  <select class="form-control input-sm" name="status" >
                          <option>--เลือกสถานะ--</option>
                          <option value="INACTIVE">INACTIVE</option>
                          <option value="ACTIVE">ACTIVE</option>
                          
                  </select>
                  </div>
                </div>
                  <div class="form-group">
                  <label class="col-sm-1 control-label">Tags</label>
                  
                  <div class="col-sm-2">
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
                </div>    
                <p><b>เรื่องย่อ :</b></p>
                <div class="form-group">
                  <div class="col-sm-12">
                  <textarea id="editor2" name="description" rows="10" cols="50"  required></textarea>
                  </div>
                  
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> อัพเดท</button>
              </form>
            </div>
        </div>
    </div>
</div>

