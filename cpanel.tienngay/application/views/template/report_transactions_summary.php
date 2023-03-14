
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
          <h3>Report: Transactions Summary</h3>

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
                <div class="col-lg-4">
                  <div class="form-horizontal">
                    <fieldset>
                      <div class="control-group">
                        <div class="controls">
                          <div class="input-prepend input-group ">
                            <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                            <input type="text" name="reservation" id="reservation" class="form-control" value="01/01/2019 - 01/25/2019" />
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                </div>

                <div class="col-lg-3">
                  <select class="form-control">
                    <option>Tất cả loại hình giao dịch</option>
                    <option>Option one</option>
                    <option>Option two</option>
                    <option>Option three</option>
                    <option>Option four</option>
                  </select>
                </div>
                <div class="col-lg-3">
                  <select class="form-control">
                    <option>Tất cả nhân viên</option>
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
              <h4><i class="fa fa-file-text-o" aria-hidden="true"></i> Bảng tổng kết giao dịch <small>Từ ngày 09/09/2019 - 09/09/2019</small> </h4>
              <hr class="mt-0">
              <div class="table-responsive">
                <table class="table table-striped ">
                  <thead>
                    <tr>
                      <th> <strong>Loại hình giao dịch</strong></th>
                      <th>Thu</th>
                      <th>Chi</th>
                      <td class="text-right">Tổng cộng</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Tiền đầu ngày</td>
                      <td>-</td>
                      <td>-</td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                    <tr>
                      <td>Cầm Đồ</td>
                      <td class="text-primary"> <strong>1,00,000</strong></td>
                      <td class="text-danger"> <strong>1,00,000</strong></td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                    <tr>
                      <td>Vay Lãi</td>
                      <td class="text-primary"> <strong>1,00,000</strong></td>
                      <td class="text-danger"> <strong>1,00,000</strong></td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                    <tr>
                      <td>Bát Họ</td>
                      <td class="text-primary"> <strong>1,00,000</strong></td>
                      <td class="text-danger"> <strong>1,00,000</strong></td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                    <tr>
                      <td>Thu Hoạt Động</td>
                      <td class="text-primary"> <strong>1,00,000</strong></td>
                      <td class="text-danger"> <strong>1,00,000</strong></td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                    <tr>
                      <td>Chi Hoạt Động</td>
                      <td class="text-primary"> <strong>1,00,000</strong></td>
                      <td class="text-danger"> <strong>1,00,000</strong></td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                    <tr>
                      <td>Nguồn Vốn</td>
                      <td class="text-primary"> <strong>1,00,000</strong></td>
                      <td class="text-danger"> <strong>1,00,000</strong></td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                    <tr>
                      <td>Tiền mặt còn lại</td>
                      <td class="text-primary"> <strong>1,00,000</strong></td>
                      <td class="text-danger"> <strong>1,00,000</strong></td>
                      <td class="text-right"><strong>1,000,000,000</strong> </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-xs-12">
              <h4><i class="fa fa-files-o" aria-hidden="true"></i> Chi tiết giao dịch</h4>
              <hr class="mt-0">
              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Mã hợp đồng</th>
                      <th>Khách hàng</th>
                      <th>Tên hàng</th>
                      <th>Tiền vay</th>
                      <th>Người giao dịch</th>
                      <th>Ngày giao dịch</th>
                      <th>Tiền lãi</th>
                      <th>Tiền khác</th>
                      <th>Tổng lãi</th>
                      <th>Loại GD</th>
                    </tr>
                  </thead>

                  <tbody>
                    <!-- <tr>
                      <td colspan="13" class="text-center">Không có dữ liệu</td>
                    </tr> -->
                    <?php for ($i=1; $i < 100; $i++) { ?>
                      <tr>
                        <td><?php echo $i ?></td>
                        <td>lore</td>
                        <td>ifsum</td>
                        <td>somthing</td>
                        <td>demo</td>
                        <td>kappa</td>
                        <td>demodemo</td>
                        <td>modemode</td>
                        <td>acb</td>
                        <td>1234</td>
                        <td>qwer</td>
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
