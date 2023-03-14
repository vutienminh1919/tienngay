
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
                <h3><?php echo $this->lang->line('update_user_phonenet');?>
                  <br/><br/>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('user_phonenet/listUser_phonenet')?>"><?php echo $this->lang->line('user_phonenet_list')?></a> / <a href="#"><?php echo $this->lang->line('update_user_phonenet')?></a></small>
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
                <form class="form-horizontal form-label-left" id="form_user_phonenet" enctype="multipart/form-data" action="<?php echo base_url("user_phonenet/doAddUser_phonenet")?>" method="post">
             <input type="hidden" name="id" class="form-control " value="<?= !empty($upnetInfor->_id->{'$oid'}) ? $upnetInfor->_id->{'$oid'} : ""?>">
             <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
             Người dùng
              </label>
   
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control"  id="email_user" name="email_user"  id="selectize_province">
                      <option value="">Chọn người dùng</option>
                      <?php 
                        if(!empty($userData)){
                          foreach($userData as $key => $user){ ?>
                          <option  <?= $upnetInfor->email_user == $user->email ? "selected" : "" ?>  value="<?= !empty($user->email) ? $user->email : "" ?>"><?= !empty($user->email) ? $user->email : "";?></option>
                          <?php }}?>
                      </select>

                    </div>
                  </div>
                  
            <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                  Số máy lẻ  <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="extension_number" value="<?= !empty($upnetInfor->extension_number) ?  $upnetInfor->extension_number : ""?>" class="form-control" >
                  </div>
            </div>
           
          <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  update_user_phonenet">
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
     <script src="<?php echo base_url();?>assets/js/user_phonenet/index.js"></script>

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