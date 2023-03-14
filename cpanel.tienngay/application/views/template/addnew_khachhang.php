<!-- page content -->
<div class="right_col" role="main">
<div class="row">


    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Thêm mới khách hàng</h3>
            </div>
            <div class="title_right text-right">

                <a href="#" class="btn btn-info ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại

                </a>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_content">
              <form class="form-horizontal form-label-left">
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Phòng giao dịch <span class="text-danger">*</span>
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
                            <input  type="text" class="form-control " placeholder="Nhập tên khách hàng">
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
                          <div class='input-group date' id='myDatepicker'>
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                          </div>
                          <script>
                          $('#myDatepicker').datetimepicker({format: 'DD-MM-YYYY'});
                          </script>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Nơi cấp
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control  " placeholder="Hãy điền nơi cấp" >
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
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-success">
                          <i class="fa fa-save"></i>
                          Lưu lại
                        </button>
                        <a href="#" class="btn btn-info ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại

                </a>
                      </div>
                    </div>
                </form>
                </div>

        </div>
    </div>
  </div>
</div>
    <!-- /page content -->
