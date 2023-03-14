<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">

        <h3>Active Expenditure</h3>

      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="row">
        <div class="col-xs-12 col-md-6">
          <div class="x_panel">
            <div class="x_title">
              <h2>Nhập phiếu chi tiền</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br>
              <form  class="form-horizontal form-label-left" >

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Người nhận <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" >Số tiền<span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="input-group input-group-sm col-xs-12">
                      <input type="text" class="form-control" placeholder="">
                      <span class="input-group-addon"> VNĐ</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Loại phiếu</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-7 col-xs-12">
                      <option>Choose option</option>
                      <option>Option one</option>
                      <option>Option two</option>
                      <option>Option three</option>
                      <option>Option four</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Ghi chú</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" rows="3" ></textarea>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-danger">
                      <i class="fa fa-money"></i> Chi tiền
                    </button>
                  </div>
                </div>

              </form>

            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-6">
          <div class="x_panel">
            <div class="x_title">
              <h2>Lịch sử lập phiếu chi</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                  <div class="col-lg-5">
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

                  <div class="col-lg-4">
                    <select class="form-control">
                      <option>Tất cả loại phiếu</option>
                      <option>Option one</option>
                      <option>Option two</option>
                      <option>Option three</option>
                      <option>Option four</option>
                    </select>
                  </div>
                  <div class="col-lg-3 text-right">
                    <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>

                  </div>
                </div>
              <br>
              <table id="datatable" class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ngày</th>
                    <th>Người giao dịch</th>
                    <th>Số tiền</th>
                    <th>Hoạt động</th>
                  </tr>
                </thead>

                <tbody>
                  <?php for ($i=0; $i < 20; $i++) { ?>
                    <tr>
                      <td>1</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>123</td>
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
