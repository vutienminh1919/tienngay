<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          Quản lý nhà đầu tư
          <br>
          <small>
            <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="#">Tier 1</a> / <a href="#">Tier 2</a> / <a href="#">Tier 3</a>
          </small>
        </h3>
      </div>


      <div class="title_right text-right">


        <a href="#" class="btn btn-info ">
          <i class="fa fa-plus" aria-hidden="true"></i>
          Tạo mới

        </a>
      </div>

    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <div class="x_content">
        <div class="row">
          <div class="col-xs-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mã NĐT</th>
                    <th>Tên NĐT</th>
                    <th>CMND-CCCD/SĐT/MST</th>
                    <th>Số dư</th>
                    <th>Trạng thái</th>
                    <th>Ngày sinh/ĐC/Email</th>
                    <th>% Lãi vay</th>
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
                    <td>187253519</td>
                    <td>Tăng Thị Huyền</td>
                    <td>
                      CMND-CCCD: <br>
                      SĐT:<br>
                      MST:
                    </td>

                    <td>23123213 vnđ</td>
                    <td></td>
                    <td>
                      Ngày sinh:  <br>
                      Địa chỉ: <br>
                      Email
                    </td>
                    <td></td>
                    <td>
                      <a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chi tiết</a>
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
