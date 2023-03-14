<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Tạo mới hợp đồng vay</h3>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step">
            <a href="#step-1" class="btn igniter">Thông tin khách hàng</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-2" class="btn disabled" disabled>Địa chỉ hộ khẩu</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-3" class="btn disabled" disabled>Địa chỉ đang ở</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-4" class="btn disabled" disabled>Thông tin việc làm</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-5" class="btn disabled" disabled>Thông tin người thân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-6" class="btn disabled" disabled>Thông tin khoản vay</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-7" class="btn disabled" disabled>Thông tin tài sản</a>
          </div>
        </div>
      </div>

      <form role="form" class="form-horizontal form-label-left">
        <div class="x_panel setup-content" id="step-1">

          <div class="x_content">
            <div class="alert alert-danger alert-dismissible text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Danger!</strong> Indicates a successful or positive action.
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Ảnh CMTND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div>
                    <button class="btn btn-primary">
                      Upload & xác thực
                    </button>
                </div>
                <br>
                <div class="displayimage">
                  <img src="https://via.placeholder.com/350x150" alt="">
                </div>

              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Phòng giao dịch
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control m-select2 select2_customdefault select2-hidden-accessible" id="m-shop-create-customer" name="selectShop" data-select2-id="m-shop-create-customer" tabindex="-1" aria-hidden="true">
                  <option value="2412" data-select2-id="7">lương bốc bát họ</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Tên khách hàng <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập tên khách hàng" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số điện thoại
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số điện thoại khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số CMND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số CMND khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Ngày cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group date" id="myDatepicker1">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
                <script>
                $('#myDatepicker1').datetimepicker({format: 'DD-MM-YYYY'});
                </script>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Nơi cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Địa chỉ
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập địa chỉ khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Trạng thái
              </label>
              <div class="col-lg-6 col-sm-12 col-xs-12 ">
                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>
              </div>
            </div>


            <button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
          </div>
        </div>

        <div class="x_panel setup-content" id="step-2">

          <div class="x_content">
            <div class="alert alert-danger alert-dismissible text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Danger!</strong> Indicates a successful or positive action.
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Phòng giao dịch
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control m-select2 select2_customdefault select2-hidden-accessible" id="m-shop-create-customer" name="selectShop" data-select2-id="m-shop-create-customer" tabindex="-1" aria-hidden="true">
                  <option value="2412" data-select2-id="7">lương bốc bát họ</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Tên khách hàng <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập tên khách hàng" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số điện thoại
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số điện thoại khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số CMND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số CMND khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Ngày cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group date" id="myDatepicker2">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
                <script>
                $('#myDatepicker2').datetimepicker({format: 'DD-MM-YYYY'});
                </script>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Nơi cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Địa chỉ
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập địa chỉ khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Trạng thái
              </label>
              <div class="col-lg-6 col-sm-12 col-xs-12 ">
                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>
              </div>
            </div>
            <button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Back</button>
          </div>
        </div>

        <div class="x_panel setup-content" id="step-3">

          <div class="x_content">
            <div class="alert alert-danger alert-dismissible text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Danger!</strong> Indicates a successful or positive action.
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Phòng giao dịch
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control m-select2 select2_customdefault select2-hidden-accessible" id="m-shop-create-customer" name="selectShop" data-select2-id="m-shop-create-customer" tabindex="-1" aria-hidden="true">
                  <option value="2412" data-select2-id="7">lương bốc bát họ</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Tên khách hàng <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập tên khách hàng" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số điện thoại
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số điện thoại khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số CMND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số CMND khách hàng">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Nơi cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Địa chỉ
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập địa chỉ khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Trạng thái
              </label>
              <div class="col-lg-6 col-sm-12 col-xs-12 ">
                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>
              </div>
            </div>


            <button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Back</button>
          </div>
        </div>

        <div class="x_panel setup-content" id="step-4">

          <div class="x_content">
            <div class="alert alert-danger alert-dismissible text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Danger!</strong> Indicates a successful or positive action.
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Phòng giao dịch
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control m-select2 select2_customdefault select2-hidden-accessible" id="m-shop-create-customer" name="selectShop" data-select2-id="m-shop-create-customer" tabindex="-1" aria-hidden="true">
                  <option value="2412" data-select2-id="7">lương bốc bát họ</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Tên khách hàng <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập tên khách hàng" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số điện thoại
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số điện thoại khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số CMND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số CMND khách hàng">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Nơi cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Địa chỉ
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập địa chỉ khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Trạng thái
              </label>
              <div class="col-lg-6 col-sm-12 col-xs-12 ">
                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>
              </div>
            </div>


            <button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Back</button>
          </div>
        </div>

        <div class="x_panel setup-content" id="step-5">

          <div class="x_content">
            <div class="alert alert-danger alert-dismissible text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Danger!</strong> Indicates a successful or positive action.
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Phòng giao dịch
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control m-select2 select2_customdefault select2-hidden-accessible" id="m-shop-create-customer" name="selectShop" data-select2-id="m-shop-create-customer" tabindex="-1" aria-hidden="true">
                  <option value="2412" data-select2-id="7">lương bốc bát họ</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Tên khách hàng <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập tên khách hàng" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số điện thoại
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số điện thoại khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số CMND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số CMND khách hàng">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Nơi cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Địa chỉ
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập địa chỉ khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Trạng thái
              </label>
              <div class="col-lg-6 col-sm-12 col-xs-12 ">
                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>
              </div>
            </div>


            <button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Back</button>
          </div>
        </div>

        <div class="x_panel setup-content" id="step-6">

          <div class="x_content">
            <div class="alert alert-danger alert-dismissible text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Danger!</strong> Indicates a successful or positive action.
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Phòng giao dịch
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control m-select2 select2_customdefault select2-hidden-accessible" id="m-shop-create-customer" name="selectShop" data-select2-id="m-shop-create-customer" tabindex="-1" aria-hidden="true">
                  <option value="2412" data-select2-id="7">lương bốc bát họ</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Tên khách hàng <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập tên khách hàng" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số điện thoại
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số điện thoại khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số CMND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số CMND khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Ngày cấp
              </label>

            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Nơi cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Địa chỉ
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập địa chỉ khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Trạng thái
              </label>
              <div class="col-lg-6 col-sm-12 col-xs-12 ">
                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>
              </div>
            </div>


            <button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Back</button>
          </div>
        </div>

        <div class="x_panel setup-content" id="step-7">

          <div class="x_content">
            <div class="alert alert-danger alert-dismissible text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Danger!</strong> Indicates a successful or positive action.
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Phòng giao dịch
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control m-select2 select2_customdefault select2-hidden-accessible" id="m-shop-create-customer" name="selectShop" data-select2-id="m-shop-create-customer" tabindex="-1" aria-hidden="true">
                  <option value="2412" data-select2-id="7">lương bốc bát họ</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Tên khách hàng <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập tên khách hàng" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số điện thoại
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số điện thoại khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Số CMND
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập số CMND khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Ngày cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group date" id="myDatepicker7">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
                <script>
                $('#myDatepicker7').datetimepicker({format: 'DD-MM-YYYY'});
                </script>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Nơi cấp
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Địa chỉ
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control " placeholder="Nhập địa chỉ khách hàng">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Trạng thái
              </label>
              <div class="col-lg-6 col-sm-12 col-xs-12 ">
                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>
              </div>
            </div>
            <button class="btn btn-success pull-right" type="submit">Finish!</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Back</button>
          </div>
        </div>
      </form>

    </div>


    <div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Recent Activities</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <ul class="list-unstyled timeline workflow widget">
              <?php for ($i=0; $i < 15 ; $i++) { ?>
                <li>
                  <img class="theavatar" src="https://cdn.pixabay.com/photo/2017/11/19/07/30/girl-2961959_960_720.jpg" alt="">
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Request approved</a>
                      </h2>
                      <div class="byline">
                        <p><strong>13 hours ago</strong> </p>
                        <p>By: <a>Jane Smith</a> </p>
                        <p>To: <a>Smith Jane</a></p>

                      </div>
                      <div class="excerpt">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                        <ul>
                          <li>Một nội dung nào đó</li>
                          <li><strong>Tiêu đề:</strong> ghi chú một điều gì đó</li>
                          <li>123123</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
              <?php } ?>
            </ul>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<style>
  .x_content {
    display: inline-block;
    float: none
  }
</style>


<script>
$(document).ready(function () {

  var navListItems = $('div.setup-panel div a'),
  allWells = $('.setup-content'),
  allNextBtn = $('.nextBtn');
  allBackBtn = $('.backBtn');

  allWells.hide();

  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
    $item = $(this);

    if (!$item.hasClass('disabled')) {
      navListItems.removeClass('active');
      $item.addClass('active');
      allWells.hide();
      $target.show();
      $target.find('input:eq(0)').focus();
    }
  });

  allNextBtn.click(function () {

    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
    curInputs = curStep.find("input[required]"),
    isValid = true;
    $(".form-group").removeClass("has-error");
    for (var i = 0; i < curInputs.length; i++) {
      if (!curInputs[i].validity.valid) {
        isValid = false;
        $(curInputs[i]).closest(".form-group").addClass("has-error");
      }
    }

    if (isValid) nextStepWizard.removeAttr('disabled').removeClass('disabled').trigger('click');
  });

  allBackBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
    prevStepWizard.click();

  });

  $('div.setup-panel div .btn.igniter').trigger('click');
});
</script>
