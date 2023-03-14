
<!-- Modal  -->
<!-- Modal: Add new -->
<div class="modal fade" id="addNewPawnModal" tabindex="-1" role="dialog" aria-labelledby="addNewModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Thêm mới Hợp đồng</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal form-label-left">
          <div class="row">
            <div class="col-xs-12 col-md-6">


          <div class="x_title">
            <strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin khách hàng</strong>

            <div class="clearfix"></div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <div class="radio-inline">
                <label><input type="radio" name="customername" checked>Khách hàng mới</label>
              </div>
              <div class="radio-inline">
                <label><input type="radio" name="customername">Khách hàng cũ</label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
              Tên khách hàng <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
              Số CMND/Hộ chiếu <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
              Mã hợp đồng  <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
              Số điện thoại
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
              Địa chỉ <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control">
            </div>
          </div>
          <div class="x_title">
            <strong><i class="fa fa-motorcycle" aria-hidden="true"></i>  Thông tin tài sản</strong>

            <div class="clearfix"></div>
          </div>
          <div class='properties none' >
            <div class="form-group">
              <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
                Biển kiểm soát <span class="text-danger">*</span>
              </label>
              <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <input type="text" required class="form-control" placeholder="Nhập biển kiểm soát">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
                Số khung <span class="text-danger">*</span>
              </label>
              <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <input type="text" required class="form-control" placeholder="Nhập số khung">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">
                Số máy <span class="text-danger">*</span>
              </label>
              <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <input type="text" required class="form-control" placeholder="Nhập số máy">
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="x_title">
            <strong><i class="fa fa-money" aria-hidden="true"></i> Thông tin khoản vay</strong>

            <div class="clearfix"></div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Loại tài sản <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <select class="form-control"  onchange="changMainProperty(this);" >
              <option></option>
              <?php 
                if(!empty($mainPropertyData)){
                    foreach($mainPropertyData as $key => $property_main){
                  // var_dump($property_main);die;

              ?>
                <option value="<?= !empty($property_main->_id->{'$oid'}) ? $property_main->_id->{'$oid'} : "" ?>"><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
                <?php } }?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Tên tài sản  <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Tổng số tiền vay <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control"  placeholder="">
                <span class="input-group-addon"> VNĐ</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Hình thức lãi <span class="text-danger">*</span>
            </label>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control">
              <div class="checkbox">
                <label><input type="checkbox"> Thu lãi trước</label>
              </div>
            </div>
          </div>

        <div class="form-group">
          <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Số ngày vay  <span class="text-danger">*</span>
          </label>
          <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <input type="text" required class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Lãi  <span class="text-danger">*</span>
          </label>
          <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control"  placeholder="">
              <span class="input-group-addon">/ 1 triệu</span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Kỳ lãi <span class="text-danger">*</span>
          </label>
          <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control"  placeholder="">
              <span class="input-group-addon">NGÀY</span>
            </div>
            <small>
              (VD : 10 ngày đóng lãi 1 lần thì điền số 10)
            </small>
          </div>

        </div>

        <div class="form-group">
          <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Ngày vay  <span class="text-danger">*</span>
          </label>
          <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <div class='input-group date' id='myDatepicker'>
              <input type='text' class="form-control" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            <script>
            $('#myDatepicker').datetimepicker();
            </script>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Ghi chú <span class="text-danger">*</span>
          </label>
          <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <textarea type="text" required class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">NV thu tiền <span class="text-danger">*</span>
          </label>
          <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <select class="form-control" >
              <option>Một ai đó</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
            </select>
          </div>
        </div>
      </div>
    </div>
      </div>
    </div>
    <div class="modal-footer">

      <button class="btn btn-danger"  data-dismiss="modal">
        <i class="fa fa-close" aria-hidden="true"></i> Hủy
      </button>
      <button type="submit" class="btn btn-success">
        <i class="fa fa-save" aria-hidden="true"></i> Lưu lại
      </button>

    </div>
  </div>
</div>
</div>
