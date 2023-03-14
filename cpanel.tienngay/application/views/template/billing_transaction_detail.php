<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Transaction Detail</h3>

      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <div class="row">
            <div class="col-xs-12 col-lg-1">

            </div>
            <div class="col-xs-12 col-lg-11">
              <div class="row">
                <div class="col-lg-10">

                </div>

                <div class="col-lg-2 text-right">
                  <button class="btn btn-info w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i> In hóa đơn</button>

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
                <table class="table table-bordered m-table table-hover table-calendar table-report" id="datatable-buttons" >
                  <thead>

                    <tr>
                      <th>
                        #

                      </th>
                      <th>
                        Mã giao dịch
                      </th>
                      <th>
                        Dịch vụ
                      </th>
                      <th>
                        Thời gian
                      </th>
                      <th>
                        Nhà phát hành
                      </th>
                      <th>
                        Trạng thái
                      </th>
                      <th>
                        Tài khoản
                      </th>
                      <th>
                        Số tiền
                      </th>
                      <th>
                        Số lượng
                      </th>
                      <th>
                        Khoản thanh toán
                      </th>
                      <th>
                        Ghi chú
                      </th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i=0; $i < 15 ; $i++) {?>

                    <tr>
                      <td>
                        #

                      </td>
                      <td>
                        Mã giao dịch
                      </td>
                      <td>
                        Dịch vụ
                      </td>
                      <td>
                        Thời gian
                      </td>
                      <td>
                        Nhà phát hành
                      </td>
                      <td>
                        Trạng thái
                      </td>
                      <td>
                        Tài khoản
                      </td>
                      <td  class="text-right">
                        Số tiền
                      </td>
                      <td>
                        Số lượng
                      </td>
                      <td class="text-right">
                        1.000.000 vnđ
                      </td>
                      <td>
                        Ghi chú
                      </td>
                    </tr>
                    <?php } ?>

                  </tbody>
                  <tfoot>
                    <tr style="background:#ede8ab">

                      <td colspan="8" class="text-right">
                        <strong>
                        Tổng cộng :
                      </strong>
                      </td>
                      <td colspan="2" class="text-right">
                        <strong>
                        1.000.000 vnđ
                      </strong>
                    </td>
                      <td></td>
                    </tr>
                  </tfoot>
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
