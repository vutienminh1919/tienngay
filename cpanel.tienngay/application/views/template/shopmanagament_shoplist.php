
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>Shop List</h3>
        </div>
        <div class="title_right text-right">
          <a href="#" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới</a>
        </div>
      </div>
    </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <div class="row">
            <div class="col-xs-12 col-lg-1">
              <h2>Dữ liệu</h2>
            </div>
            <div class="col-xs-12 col-lg-11">
              <div class="row">
                <div class="col-lg-10 text-right ">
                  <div class="form-group m-0 h-100">
                    <div class="checkbox-inline h-100">

                    </div>
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="thefilter" value="" checked> Xem tất cả.
                      </label>
                    </div>
                    <div class="radio-inline text-warning">
                      <label>
                        <input type="radio" name="thefilter" value=""> Đang hoạt động
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio" name="thefilter"value=""> Tạm dừng hoạt động
                      </label>
                    </div>
                  </div>

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
                      <th>Phòng giao dịch</th>
                      <th>Địa chỉ</th>
                      <th>Điện thoại</th>
                      <th>Vốn đầu tư</th>
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
