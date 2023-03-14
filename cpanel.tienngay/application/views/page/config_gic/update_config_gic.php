
<!-- page content -->
<div class="right_col" role="main">
  <div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử Lý...</span>
  </div>
  <div class="row">


    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $this->lang->line('update_config_gic');?>
                  <br/><br/>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('config_gic/listConfig_gic')?>"><?php echo $this->lang->line('config_gic_list')?></a> / <a href="#"><?php echo $this->lang->line('update_config_gic')?></a></small>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_content">
                <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
                <form class="form-horizontal form-label-left" id="form_config_gic" enctype="multipart/form-data" action="<?php echo base_url("config_gic/doAddConfig_gic")?>" method="post">
             <input type="hidden" name="id_config_gic" class="form-control " value="<?= !empty($config_gic->_id->{'$oid'}) ? $config_gic->_id->{'$oid'} : ""?>">
    
        <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    ID sản phẩm <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="id" class="form-control" value="<?= !empty($config_gic->id) ?  $config_gic->id : ""?>">
                  </div>
                </div>
                         <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Tên sản phẩm
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="name" class="form-control" value="<?= !empty($config_gic->name) ?  $config_gic->name : ""?>">
                  </div>
            </div>
                  <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Code sản phẩm
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="code" class="form-control" value="<?= !empty($config_gic->code) ?  $config_gic->code : ""?>">
                  </div>
            </div>
              <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                  ID nhân viên GIC <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="NhanVienId" class="form-control"  value="<?= !empty($config_gic->NhanVienId) ?  $config_gic->NhanVienId : ""?>">
                  </div>
            </div>
             <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                  ID loại người thụ hưởng <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="LoaiNguoiThuHuongId" class="form-control"  value="<?= !empty($config_gic->LoaiNguoiThuHuongId) ?  $config_gic->LoaiNguoiThuHuongId : ""?>">
                  </div>
            </div>
            <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                  Tỉ lệ phí  <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="TyLePhi" value="<?= !empty($config_gic->TyLePhi) ?  $config_gic->TyLePhi : ""?>" class="form-control" >
                  </div>
            </div>
          
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                  Họ và tên (Người vay)
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="ThongTinNguoiChoVay_HoTen" class="form-control" value="<?= !empty($config_gic->ThongTinNguoiChoVay_HoTen) ?  $config_gic->ThongTinNguoiChoVay_HoTen : ""?>">
                  </div>
            </div>
                    <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    CMND (Người vay)
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="ThongTinNguoiChoVay_CMND" class="form-control" value="<?= !empty($config_gic->ThongTinNguoiChoVay_CMND) ?  $config_gic->ThongTinNguoiChoVay_CMND : ""?>">
                  </div>
            </div>
                          <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Điện thoại (Người vay)
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="ThongTinNguoiChoVay_DienThoai" class="form-control" value="<?= !empty($config_gic->ThongTinNguoiChoVay_DienThoai) ?  $config_gic->ThongTinNguoiChoVay_DienThoai : ""?>">
                  </div>
            </div>
          <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Email (Người vay)
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="ThongTinNguoiChoVay_Email" class="form-control" value="<?= !empty($config_gic->ThongTinNguoiChoVay_Email) ?  $config_gic->ThongTinNguoiChoVay_Email : ""?>">
                  </div>
            </div>
            <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Địa chỉ (Người vay)
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="ThongTinNguoiChoVay_DiaChi" class="form-control" value="<?= !empty($config_gic->ThongTinNguoiChoVay_DiaChi) ?  $config_gic->ThongTinNguoiChoVay_DiaChi : ""?>">
                  </div>
            </div>
          <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  update_config_gic">
                      <i class="fa fa-save"></i>
                      <?php echo $this->lang->line('save')?>
                    </button>
                    <a href="#" class="btn btn-info ">
                      <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>

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
     <script src="<?php echo base_url();?>assets/js/config_gic/index.js"></script>

<script>
    function readURL_all(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var parent = $(input).closest('.form-group');
            //console.log(parent);
            reader.onload = function (e) {
                parent.find('.wrap').hide('fast');
                parent.find('.blah').attr('src', e.target.result);
                parent.find('.wrap').show('fast');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".x_content").on('change', '.imgInp', function () {

        readURL_all(this);
    });
</script>