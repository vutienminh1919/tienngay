
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Custommer need loans</h3>
      </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <div class="row">
            <div class="col-xs-12 col-lg-1">
              <h2> </h2>
            </div>
            <div class="col-xs-12 col-lg-11">
              <div class="row">
                <div class="col-lg-7 text-right ">


                </div>

                <div class="col-lg-3">
                  <select class="form-control">
                    <option>Đã tạo khoản vay</option>
                    <option>Option one</option>
                    <option>Option two</option>
                    <option>Option three</option>
                    <option>Option four</option>
                  </select>
                </div>

                <div class="col-lg-2 text-right">
                  <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>

                </div>
              </div>

            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">
              <div class="row">

              </div>
            </div>
            <div class="col-xs-12">

              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Khách hàng</th>
                      <th>Địa chỉ</th>
                      <th>Điện thoại</th>
                      <th>CMND</th>
                      <th>Phòng giao dịch</th>
                      <th>Ngày tạo</th>
                      <th>Tình trạng</th>
                      <th>Chức năng</th>
                    </tr>
                  </thead>

                  <tbody>
                    <!-- <tr>
                    <td colspan="13" class="text-center">Không có dữ liệu</td>
                  </tr> -->
                  <?php for ($i=1; $i < 100; $i++) { ?>
                    <tr>
                      <td><?php echo $i ?></td>
                      <td>demodemo</td>
                      <td>modemode</td>
                      <td>acb</td>
                      <td>1234</td>
                      <td>qwer</td>
                      <td>235</td>
                      <td>235</td>
                      <td>
                        <a href="#">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /page content -->



<!-- Modal  -->
<!-- Modal: Add new -->
<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModal">
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
                  Tên khách hàng <span class="text-danger">*</span>
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
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="x_title">
                <strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin khoản vay</strong>

                <div class="clearfix"></div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-4 col-md-3 col-sm-3 col-xs-12">Loại tài sản <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" >
                    <option>Xe máy</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
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
                    <span class="input-group-addon">/ NGÀY</span>
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
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control"  placeholder="">
                    <span class="input-group-addon">NGÀY</span>
                  </div>
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
