
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
                <h3><?php echo $this->lang->line('create_warehouse')?>
                  <br/><br/>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('warehouse/listWarehouse')?>"><?php echo $this->lang->line('warehouse_list')?></a> / <a href="#"><?php echo $this->lang->line('create_warehouse')?></a></small>
                </h3>
            </div>
        </div>
    </div>

 

            <div class="x_content">
            	  <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>

            			<div class="x_panel setup-content" id="step-1" style="display: inline-block;">
  <div class="x_content">
    <div class="x_title">
        <strong><i class="fa fa-user" aria-hidden="true"></i> <?php echo $this->lang->line('Info_warehouse')?></strong>
        <div class="clearfix"></div>
    </div>
    <form class="form-horizontal form-label-left" id="form_warehouse" action="<?php echo base_url("warehouse/doAddWarehouse")?>" method="post">
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?php echo $this->lang->line('code_warehouse')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="code" name="code" required="" class="form-control">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?php echo $this->lang->line('name_warehouse')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="name" name="name" required="" class="form-control">
      </div>
    </div>
       <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?php echo $this->lang->line('max_xe_may')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="number" id="max_xe_may" name="max_xe_may" required="" class="form-control">
      </div>
    </div>
     <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?php echo $this->lang->line('max_oto')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="number" id="max_oto" name="max_oto" required="" class="form-control">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
       <?php echo $this->lang->line('address')?> 
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="address" required="" id="address" name="address" class="form-control email-autocomplete ui-autocomplete-input" autocomplete="off">
      </div>
    </div>
 
  
  
      <div class="x_title">
          <strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin người quản lý</strong>
          <div class="clearfix"></div>
      </div>
   
     <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
       <?php echo $this->lang->line('manager')?>
      </label>
   
       <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control"  id="manager_id" name="manager_id"  id="selectize_province">
                  <option value="">Chọn người quản lý</option>
                  <?php 
                    if(!empty($managerData)){
                      foreach($managerData as $key => $manager){
                  ?>
                      <option  value="<?= !empty($manager->_id->{'$oid'}) ? $manager->_id->{'$oid'} : "" ?>"><?= !empty($manager->full_name) ? $manager->full_name : "";?> - <?= !empty($manager->email) ? $manager->email : "";?></option>
                      <?php }}?>
                  </select>

              </div>
       
    </div>
     <div class="form-group row">
		<label class="control-label col-md-3 col-sm-3 col-xs-12">
			<?php echo $this->lang->line('status')?>
		</label>
		<div class="col-lg-6 col-sm-12 col-xs-12 ">
			<div class="radio-inline text-primary">
				<label>
					<input type="radio" name="status" value="active" checked="checked"> <?php echo $this->lang->line('active')?>
				</label>
			</div>
			<div class="radio-inline text-danger">
				<label>
					<input type="radio"   name="status" value="deactive"> <?php echo $this->lang->line('deactive')?>
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			<button class="btn btn-success  create_warehouse">
				<i class="fa fa-save"></i>
				<?php echo $this->lang->line('save')?>
			</button>
			<a href="<?php echo base_url('warehouse/listWarehouse')?>" class="btn btn-info ">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>

			</a>
		</div>
     </div>
     </form>
  </div>
</div>
							

            </div>
        </div>
  
    <!-- /page content -->
    <script src="<?php echo base_url();?>assets/js/warehouse/index.js"></script>
   
    <style type="text/css">
    	textarea {

  white-space: pre;

  overflow-wrap: normal;

  overflow-x: scroll;

}
    </style>
