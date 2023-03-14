
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
                <h3><?php print $this->lang->line('update_landing_page')?>
                  <br/><br/>
                  <small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('landing_page/listLanding_page')?>"><?php print $this->lang->line('landing_page_list')?></a> / <a href="#"><?php print $this->lang->line('update_landing_page')?></a></small>
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
                <form class="form-horizontal form-label-left" id="form_landing_page" enctype="multipart/form-data" action="<?php print base_url("landing_page/doUpdateLanding_page")?>" method="post">

                 <input type="hidden" name="id_landing_page" class="form-control " value="<?= !empty($landing_page->_id->{'$oid'}) ? $landing_page->_id->{'$oid'} : ""?>">
                 
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
            <?php echo $this->lang->line('province')?> <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control"   id="selectize_province">
                          <option value="">none</option>
                          <?php 
                            if(!empty($provinceData)){
                              foreach($provinceData as $key => $province){
                          ?>
                              <option  value="<?= !empty($province->code) ? $province->code : "";?>" <?php if($province->code == $landing_page->province_id) echo "selected"?>><?= !empty($province->name) ? $province->name : "";?></option>
                              <?php }}?>
                        </select>
                    </div>
                </div>
                 <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
            <?php echo $this->lang->line('Address')?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="url" id="url" class="form-control " value="<?= !empty($landing_page->url) ? $landing_page->url : "";?>" placeholder="<?php echo $this->lang->line('typing_address')?>" required />
                    </div>
                </div>
        
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('status')?>
                  </label>
                  <div class="col-lg-6 col-sm-12 col-xs-12 ">
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="status" value="active" <?php ($landing_page->status=="active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="status" value="deactive" <?php ($landing_page->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
          <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  update_landing_page">
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
    <script src="<?php print base_url();?>assets/js/landing_page/index.js"></script>
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