<!-- Delete -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>ลบการ์ตูน...</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="chapter_delete.php">
          <input type="hidden" class="prodid" name="id">
          <div class="text-center">
            <h2><b>ตอนที่ <span class="chapter"></span> <span class="bold name"></span></b></h2>
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
        <h4 class="modal-title"><b>แก้ไข ตอนที่ <span class="chapter"></span> <span class="name"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="chapter_edit.php">

          <input type="hidden" class="prodid" name="id">

          <div class="form-group">
            <!-- ตอนที่ -->
            <label for="chapter" class="col-sm-1 control-label">ตอนที่</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="edit_chapter" name="chapter">
            </div>
            <!-- ชื่อตอน -->
            <label for="chapter_name" class="col-sm-1 control-label">ชื่อ</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="edit_name" name="name">
            </div>

          </div>

          <!-- เรื่องอะไร -->

          <div class="form-group">
            <label for="product_id" class="col-sm-1 control-label">เรื่อง</label>
            <div class="col-sm-5">
              <select class="form-control input-sm" name="pronameid">
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
            <!-- แก้สถานะ -->
            <label for="price" class="col-sm-1 control-label">Status</label>
            <div class="col-sm-2">
              <select class="form-control input-sm" name="chapter_status" required>
                <option>- เลือกสถานะ -</option>
                <option value="Free">Free</option>
                <option value="Lock">Lock</option>
              </select>
            </div>

          </div>
          <div class="form-group">
            <!-- แก้ราคา -->
            <label for="price" class="col-sm-1 control-label">ราคา</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="price" name="price">
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

<!-- view chapter -->
<div class="modal fade" id="view_chapter">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>ตอนที่ <span class="chapter"></span> <span class="name"></span></b></h4>
      </div>
      <div class="modal-body">

      <div id="imageContainer"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
        </form>
      </div>
    </div>
  </div>
</div>