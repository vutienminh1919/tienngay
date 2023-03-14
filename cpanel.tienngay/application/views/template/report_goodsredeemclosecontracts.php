
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
          <h3>Report: Redeem goods & close contracts</h3>

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
                <div class="col-lg-3">

                </div>

                <div class="col-lg-3">
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
                    <option disabled selected>Loại tài sản</option>
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
                      <th>Mã hợp đồng</th>
                      <th>Khách hàng</th>
                      <th>Sản phẩm</th>
                      <th>Tiền cầm</th>
                      <th>Ngày cầm</th>
                      <th>Lãi đã đóng</th>
                      <th>Tiền vay</th>
                      <th>Lãi đến hôm nay</th>
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
