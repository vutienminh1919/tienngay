
<!-- page content -->
<div class="right_col" role="main">
  <div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử lý...</span>
  </div>
  <div class="row">


    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?php print $this->lang->line('update_email_template')?>
                  <br/><br/>
                  <small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('email_template/listEmail_template')?>"><?php print $this->lang->line('email_template_list')?></a> / <a href="#"><?php print $this->lang->line('update_email_template')?></a></small>
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
                <form class="form-horizontal form-label-left" id="form_email_template" enctype="multipart/form-data" action="<?php print base_url("email_template/doUpdateEmail_template")?>" method="post">

                 <input type="hidden" name="id_email_template" class="form-control " value="<?= !empty($email_template->_id->{'$oid'}) ? $email_template->_id->{'$oid'} : ""?>">
                 <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Code *</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="code" class="form-control " value="<?php !empty($email_template->code) ? print $email_template->code : print "" ?>" placeholder="" select>
                  </div>
            </div>
          
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Message <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea rows="10" cols="50" class="form-control" id="message" style="white-space: initial;" name="message" placeholder="message"><?php !empty($email_template->message) ? print $email_template->message : print "" ?></textarea>
                  </div>
                </div>
                            <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Code name *</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="code_name" class="form-control " value="<?php !empty($email_template->code_name) ? print $email_template->code_name : print "" ?>" placeholder="" select>
                  </div>
            </div>
              <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    From *</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="from" class="form-control " value="<?php !empty($email_template->from) ? print $email_template->from : print "" ?>" placeholder="" select>
                  </div>
            </div>
              <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    From_name *</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="from_name" class="form-control " value="<?php !empty($email_template->from_name) ? print $email_template->from_name : print "" ?>" placeholder="" select>
                  </div>
            </div>
              <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Subject *</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="subject" class="form-control " value="<?php !empty($email_template->subject) ? print $email_template->subject : print "" ?>" placeholder="" select>
                  </div>
            </div>
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('status')?>
                  </label>
                  <div class="col-lg-6 col-sm-12 col-xs-12 ">
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="status" value="active" <?php ($email_template->status=="active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="status" value="deactive" <?php ($email_template->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
          <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  update_email_template">
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
    <script src="<?php print base_url();?>assets/js/email_template/index.js"></script>
    
    <style type="text/css">
      textarea {

  white-space: pre;

  overflow-wrap: normal;

  overflow-x: scroll;

}
    </style>
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