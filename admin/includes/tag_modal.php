<!-- check -->
<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>เพิ่มแท็กใหม่</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="tag_add.php"> <!--ส่งไป tag_add.php -->
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">ชื่อแท็ก</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" required>
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
<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>แก้ไขชื่อแท็ก</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="tag_edit.php"> <!--แก้ไขชื่อและส่งไป tag_edit.php -->
                <input type="hidden" class="tagid" name="id">
                <div class="form-group">
                    <label for="edit_name" class="col-sm-3 control-label">ชื่อใหม่</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_name" name="name">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> ปิด</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> เปลี่ยนชื่อ</button>
              </form>
            </div>
        </div>
    </div>
</div>
<!-- check -->
<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>ลบแท็ก...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="tag_delete.php"> <!--ลบหมวดหมู่ tag_delete.php -->
                <input type="hidden" class="tagid" name="id">
                <div class="text-center">
                    <p>ทำการลบแท็ก</p>
                    <h2 class="bold tagname"></h2>
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
