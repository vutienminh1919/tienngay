<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          Quản lý HĐ vay
          <br>
          <small>
            <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="#">Tier 1</a> / <a href="#">Tier 2</a> / <a href="#">Tier 3</a>
          </small>
        </h3>
      </div>

    </div>
  </div>



  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">

        <div class="row">
          <div class="col-xs-12 col-lg-1">
            <h2> HĐ vay đến hạn (Quản lý HĐ vay)</h2>
          </div>
          <div class="col-xs-12 col-lg-11">
            <div class="row">
              <div class="col-lg-2">

              </div>

              <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-addon">From</span>
                  <input type="date" class="form-control" >
                </div>
              </div>
              <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-addon">To</span>
                  <input type="date" class="form-control" >
                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group">
                  <select class="form-control">
                    <option>Tất cả</option>
                    <option>Tiêu chuẩn</option>
                    <option>xấu cấp 1</option>
                    <option>xấu cấp 2</option>
                    <option>Chưa đến kỳ</option>
                    <option>Quá hạn</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-2 text-right">
                <button class="btn btn-primary w-100"><i class="fa fa-filter"></i> Lọc</button>

              </div>
            </div>

          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-xs-12">
            <table class="table table-borderless" style="table-layout:fixed">
  <thead>
    <tr>
      <td>
        <p>Tổng số HĐ</p>
        <h3 class="m-0 green">123</h3>
      </td>
      <td>
        <p>Mới</p>
        <h3 class="m-0 green">123</h3>
      </td>
      <td>
        <p>Đã hủy</p>
        <h3 class="m-0 green">123</h3>
      </td>
      <td>
        <p>Chờ duyệt</p>
        <h3 class="m-0 green">123</h3>
      </td>
      <td>
        <p>Chưa giải ngân</p>
        <h3 class="m-0 green">123</h3>
      </td>
      <td>
        <p>Đã duyệt</p>
        <h3 class="m-0 green">123</h3>
      </td>
      <td>
        <p>Đã giải ngân</p>
        <h3 class="m-0 green">123</h3>
      </td>
      <td>
        <p>Đã tất toán</p>
        <h3 class="m-0 green">123</h3>
      </td>


    </tr>

  </tbody>
</table>
          </div>
          <div class="col-xs-12">

            <div class="table-responsive">
              <table id="datatable-buttons" class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mã hợp đồng</th>
                    <th>Khách hàng</th>
                    <th>Ngày giải ngân</th>
                    <th>Thời hạn vay</th>
                    <th>Ngày đến hạn</th>
                    <th>Tình trạng thanh toán</th>
                    <th>Số ngày quá hạn</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>

                <tbody>
                  <!-- <tr>
                  <td colspan="13" class="text-center">Không có dữ liệu</td>
                </tr> -->
                <?php for ($i=1; $i < 100; $i++) { ?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td>HĐ_0001</td>
                    <td>Nguyễn Văn Quang</td>
                    <td>15/11/2019</td>
                    <td>180</td>
                    <td>15/11/2019</td>
                    <td>xấu cấp 2</td>
                    <td>70</td>
                    <td>Kỳ 1: 70</td>
                    <td>
                      <a href="#">
                        <i class="fa fa-info-circle" ></i> Chi tiết
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
<!-- /page content -->
