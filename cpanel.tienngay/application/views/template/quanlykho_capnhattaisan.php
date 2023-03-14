<!-- page content -->
<div class="right_col" role="main">
<div class="row">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Cập nhật tài sản</h3>
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
                            Tên tài sản <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Tên tài sản...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Kho <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Kho...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Loại tài sản <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Loại tài sản...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Tình trạng <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Tình trạng...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Nhãn hiệu <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Nhãn hiệu...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Model <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Model...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Biển số <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Biển số...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Màu xe <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Màu xe...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Số khung <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Số khung...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Số máy <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Số máy...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Khấu hao <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" placeholder="Khấu hao...">
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload ảnh <span class="red">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <div id="SomeThing" class="simpleUploader">
                          <div class="uploads ">
                            <div class="block">
                              <div class="progressBar" style="width:100%"></div>
                            </div>

                            <div class="block">
                              <div class="error">
                                Upload failed
                              </div>
                            </div>
                            <?php for ($i=0; $i < 2 ; $i++) { ?>
                              <div class="block">
                                  <img src="https://www.belightsoft.com/products/imagetricks/img/intro-video-poster@2x.jpg" alt="">
                                  <button type="button" class="cancelButton "><i class="fa fa-times-circle"></i></button>
                              </div>
                              <div class="block">
                                  <img src="https://upload.wikimedia.org/wikipedia/commons/0/0f/Eiffel_Tower_Vertical.JPG" alt="">
                                  <button type="button" class="cancelButton "><i class="fa fa-times-circle"></i></button>
                              </div>
                            <?php } ?>
                            <label for="uploadinput">
                              <div class="block uploader">
                                <span>+</span>
                              </div>
                            </label>
                        </div>

                        <input id="uploadinput" type="file" name="file" multiple="" class="focus">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Ghi chú <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control" placeholder="Ghi chú..." rows="8" cols="80"></textarea>
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
