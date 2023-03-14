<div class="right_col" role="main">
  <br>&nbsp;

  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Đơn hàng</h3>

      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel" >
        <div class="x_content">
          <table class="table table-striped table-interest" >
            <tbody>
              <tr>
                <td colspan="8"  style="font-size:18px;text-align:center;padding: 64px 0;">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-shopping-cart fa-stack-1x"></i>
                    <i class="fa fa-ban fa-stack-2x text-danger"></i>
                  </span>
                  Không có sản phẩm
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table table-striped table-interest" >
            <thead  class="bg-primary">
              <tr>
                <th class="text-center">STT</th>
                <th>Dịch vụ</th>
                <th>Nhà phát hành</th>
                <th class="text-center">Mệnh giá/ Số tiền</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">SĐT/ Mã KH</th>
                <th class="text-right">Thành tiền</th>
                <th class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>

              <?php for ($i=1; $i < 5; $i++) { ?>
                <tr>
                  <td class="text-center"><?php echo $i ?></td>
                  <td>Nạp thẻ điện thoại trả trước</td>
                  <td >Viettel</td>
                  <td class="text-center">50.000</td>
                  <td class="text-center">
                    <button style="width:24px">+</button>
                    <input type="number" class=" text-center" value="1" min="1" style="width: 50px;display: inline-block;margin-right:3px">
                    <button style="width:24px">-</button>
                  </td>
                  <td class="text-center">0868 226868</td>
                  <td class="text-right">50.000</td>
                  <td class="text-center">
                    <button class="btn btn-danger">
                      <i class="fa fa-trash"></i> Xóa
                    </button>
                  </td>
                </tr>
              <?php } ?>

            </tbody>
            <tfoot>
              <tr class="bg-primary">
                <td colspan="8" class="text-center">
                  <h4 style="margin:0">
                    TỔNG THANH TOÁN : 5.450.000
                  </h4>
                </td>
              </tr>
            </tfoot>
          </table>

          <p class="text-center">
            <button class="btn btn-secondary" style="width:110px">Thêm dịch vụ</button>
            <button class="btn btn-danger" style="width:110px" >Hủy</button>
            <button class="btn btn-success" style="width:110px" >Thanh toán</button>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
