
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
                <h3><?php print $this->lang->line('update_faq')?>
                  <br/><br/>
                  <small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('faq/listFaq')?>"><?php print $this->lang->line('faq_list')?></a> / <a href="#"><?php print $this->lang->line('update_faq')?></a></small>
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
                <form class="form-horizontal form-label-left" id="form_faq" enctype="multipart/form-data" action="<?php print base_url("faq/doUpdateFaq")?>" method="post">

                 <input type="hidden" name="id_faq" class="form-control " value="<?= !empty($faq->_id->{'$oid'}) ? $faq->_id->{'$oid'} : ""?>">
                 
               

        <div class="group-tabs">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#vi" aria-controls="home" role="tab" data-toggle="tab">Vietnamese</a></li>
            <li role="presentation"><a href="#en" aria-controls="profile" role="tab" data-toggle="tab">English</a></li>
          </ul>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="vi">
            <br/>
            <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('title')?> <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="title_vi" class="form-control " value="<?php !empty($faq->title_vi) ? print $faq->title_vi : print "" ?>" placeholder="<?php print $this->lang->line('title_pla')?>" select>
                  </div>
            </div>
          
             
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('content')?> <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea rows="5" cols="100" class="form-control" id="content_vi"  name="content_vi" placeholder="<?php print $this->lang->line('content_pla')?>" ><?php !empty($faq->content_vi) ? print $faq->content_vi : print  "" ?></textarea>
                  </div>
                </div>

              
            </div>
            <div role="tabpanel" class="tab-pane" id="en">
              <br/>
                         <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('title')?>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="title_en" class="form-control " placeholder="<?php print $this->lang->line('title_pla')?>"  value="<?php !empty($faq->title_en) ? print $faq->title_en : print  "" ?>" select>
                  </div>
            </div>
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('content')?> 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea rows="5" cols="100" class="form-control" id="content_en"  name="content_en" placeholder="<?php print $this->lang->line('content_pla')?>" ><?php !empty($faq->content_en) ? print $faq->content_en : print "" ?></textarea>
                  </div>
                </div>
                

            </div>

          </div>
        
        </div>
        <br/>
          
        <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('type')?>
                  <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control district_shop"  placeholder="<?php print $this->lang->line('type_pla')?>" name="type_faq" id="type_faq" required>
                      <option <?php ($faq->type=="1") ? print "selected" : print "" ?> value="1">Sản phẩm/ Dịch vụ</option>
                      <option <?php ($faq->type=="2") ? print "selected" : print "" ?> value="2">Về khoản vay</option>
                      <option <?php ($faq->type=="3") ? print "selected" : print "" ?> value="3">Thanh toán khoản vay</option>
                

                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('status')?>
                  </label>
                  <div class="col-lg-6 col-sm-12 col-xs-12 ">
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="status" value="active" <?php ($faq->status=="active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="status" value="deactive" <?php ($faq->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
          <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  update_faq">
                      <i class="fa fa-save"></i>
                      <?php print $this->lang->line('save')?>
                    </button>
                    <a href="#" class="btn btn-info ">
                      <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php print $this->lang->line('back')?>

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
    <script src="<?php print base_url();?>assets/js/faq/index.js"></script>
           <script>
    CKEDITOR.replace( 'content_vi', {height:['200px'] } );
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.language  = vi;
        CKEDITOR.replace('body', {height: 200});
    </script> 
       <script>
    CKEDITOR.replace( 'content_en',  {height:['200px'] } );
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('body', {height: 200});
    </script> 
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