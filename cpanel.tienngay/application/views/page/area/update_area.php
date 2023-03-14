
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
                <h3><?php print $this->lang->line('update_area')?>
                  <br/><br/>
                  <small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('area/listArea')?>"><?php print $this->lang->line('area_list')?></a> / <a href="#"><?php print $this->lang->line('update_area')?></a></small>
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
                <form class="form-horizontal form-label-left" id="form_area"  action="<?php print base_url("area/doUpdateArea")?>" method="post">

                 <input type="hidden" name="id_area" class="form-control " value="<?= !empty($area->_id->{'$oid'}) ? $area->_id->{'$oid'} : ""?>">
                 
     
              <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Miền <span class="text-danger">*</span>
            </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
                       <select class="form-control" name="domain">
                      <option>Chọn miền</option>
                       <?php 
                          if(!empty(domain())) {
                            foreach(domain() as $key => $domain){
                        ?>
                    <option  value="<?= $key ?>" <?php ($area->domain->code!=$key) ? print '' : print "selected" ?>><?= $domain?></option>
                            <?php }}?>
                      
                    </select>
                </div>
            </div>
            <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Vùng <span class="text-danger">*</span>
            </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
                       <select class="form-control" name="region">
                      <option>Chọn Vùng</option>
                       <?php 
                          if(!empty(region())) {
                            foreach(region() as $key => $region){
                        ?>
                    <option  value="<?= $key ?>" <?php ($area->region->code!=$key) ? print '' : print "selected" ?>><?= $region?></option>
                            <?php }}?>
                      
                    </select>
                </div>
            </div>
            <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                   Khu vực <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="title" class="form-control " value="<?php !empty($area->title) ? print $area->title : print "" ?>" placeholder="<?php print $this->lang->line('title_pla')?>" select>
                  </div>
            </div>
          <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Mã Khu vực<span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="code" class="form-control " value="<?php !empty($area->code) ? print $area->code : print "" ?>" placeholder="Code" select>
                  </div>
            </div>
             
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('content')?> <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea rows="5" cols="100" class="form-control" id="content"  name="content" placeholder="<?php print $this->lang->line('content_pla')?>" ><?php !empty($area->content) ? print $area->content : print  "" ?></textarea>
                  </div>
                </div>

              
            
        
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('status')?>
                  </label>
                  <div class="col-lg-6 col-sm-12 col-xs-12 ">
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="status" value="active" <?php ($area->status=="active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="status" value="deactive" <?php ($area->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
          <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  update_area">
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
    <script src="<?php echo base_url();?>assets/js/area/index.js"></script>
    <style type="text/css">
      textarea {

  white-space: pre;

  overflow-wrap: normal;

  overflow-x: scroll;

}
    </style>
