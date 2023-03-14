<!-- page content -->
<div class="right_col" role="main">
  <div class="row">


    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $this->lang->line('update_store')?>
                <br>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('store/listStore')?>"><?php echo $this->lang->line('store_list')?></a> / <a href="#"><?php echo $this->lang->line('update_store')?></a></small>
                </h3>
            </div>
            <div class="title_right text-right">

                <a href="<?php echo base_url('store/listStore')?>" class="btn btn-info ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>

                </a>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_content">
              <form class="form-horizontal form-label-left" action="<?php echo base_url("store/doUpdateStore")?>" method="post">
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
                <input type="hidden" name="id_shop" class="form-control " value="<?= !empty($store->_id->{'$oid'}) ? $store->_id->{'$oid'} : ""?>">
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('store_name')?> <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="name_shop" class="form-control " placeholder="<?php echo $this->lang->line('typing_store_name')?>" required value="<?= !empty($store->name) ? $store->name : ""?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						        <?php echo $this->lang->line('phone_number')?> <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="phone_shop" class="form-control " placeholder="<?php echo $this->lang->line('typing_store_phone')?>" required value="<?= !empty($store->phone) ? $store->phone : ""?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                       Số hotline
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="phone_hotline" class="form-control " placeholder="Nhập số hotline" value="<?= !empty($store->phone_hotline) ? $store->phone_hotline : ""?>" required >
                    </div>
                </div>
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
                              <option  value="<?= !empty($province->code) ? $province->code : "";?>" <?php if($province->code == $store->province_id) echo "selected"?>><?= !empty($province->name) ? $province->name : "";?></option>
                              <?php }}?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('district')?> <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control"   id="selectize_district">
                          <option value="">none</option>
                          <?php 
                            if(!empty($districtData)){
                              foreach($districtData as $key => $district){
                          ?>
                              <option  value="<?= !empty($district->code) ? $district->code : "";?>" <?php if($district->code == $store->district_id) echo "selected"?>><?= !empty($district->name) ? $district->name : "";?></option>
                              <?php }}?>
                        </select>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('Address')?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="address_shop" class="form-control " placeholder="<?php echo $this->lang->line('typing_address')?>" required value="<?= !empty($store->address) ? $store->address : ""?>" />
                     
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('representative')?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="representative" class="form-control " placeholder="<?php echo $this->lang->line('typing_representative')?>" select value="<?= !empty($store->representative) ? $store->representative : ""?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('amount_of_investment')?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  type="text" name="investment" class="form-control" placeholder="<?php echo $this->lang->line('amount_of_investment')?>" select value="<?= !empty($store->investment) ? $store->investment : ""?>">
                    </div>
                </div>
				  <div class="form-group row">
					  <label class="control-label col-md-3 col-sm-3 col-xs-12">
						  Mã khu vực <span class="text-danger">*</span>
					  </label>
					  <div class="col-md-6 col-sm-6 col-xs-12">
						  <select class="form-control district_shop" name="code_province_store" id="code_province_store" required>
							  <option value="">Chọn khu vực</option>
						
                 <?php 
                          if(!empty($areaData)){
                            foreach($areaData as $key => $area){
                          $code_province_store=  !empty($store->code_area) ? 'selected' : '';
                        ?>
                            <option  value="<?= !empty($area->code) ? $area->code : "";?>" <?=($area->code==$store->code_area) ? 'selected' : '' ?>><?= !empty($area->title) ? $area->title : "";?></option>
                            <?php }}?>
						  </select>
					  </div>
				  </div>
				  <div class="form-group row">
					  <label class="control-label col-md-3 col-sm-3 col-xs-12">
						  Mã địa chỉ phòng giao dịch <span class="text-danger">*</span>
					  </label>
					  <div class="col-md-6 col-sm-6 col-xs-12">
						  <input  type="text" name="code_address_store" value="<?php echo !empty($store->code_address_store) ? $store->code_address_store : ''?>" class="form-control" placeholder="" required/>
					  </div>
				  </div>
          <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
             Lat <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  type="text" name="lat" value="<?php echo !empty($store->location->lat) ? $store->location->lat : ''?>" class="form-control" placeholder="" required/>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Lng <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  type="text" name="lng" value="<?php echo !empty($store->location->lng) ? $store->location->lng : ''?>" class="form-control" placeholder="" required/>
            </div>
          </div>
             <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
            <?php echo $this->lang->line('type')?>
                    </label>
                    <div class="col-lg-6 col-sm-12 col-xs-12 ">
                      <div class="radio-inline text-primary">
                      <?php
                        $type = !empty($store->type_pgd) ? $store->type_pgd : "";
                        // var_dump($status);die;
                      ?>
                        <label>
                          <input type="radio" name="type_pgd" value="1" <?php if($type =="1") echo "checked"?>> Phòng giao dịch
                        </label>
                      </div>
                      <div class="radio-inline text-danger">
                        <label>
                          <input type="radio" name="type_pgd" value="2"  <?php if($type =="2") echo "checked"?>> Trung tâm bán
                        </label>
                      </div>
                      <div class="radio-inline text-warning">
                        <label>
                          <input type="radio" name="type_pgd" value="3"  <?php if($type =="3") echo "checked"?>> Đã cơ cấu
                        </label>
                      </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('status')?>
                    </label>
                    <div class="col-lg-6 col-sm-12 col-xs-12 ">
                      <div class="radio-inline text-primary">
                      <?php
                        $status = !empty($store->status) ? $store->status : "";
                        // var_dump($status);die;
                      ?>
                        <label>
                          <input type="radio" name="status" value="active" <?php if($status =="active") echo "checked"?>> <?php echo $this->lang->line('active')?>
                        </label>
                      </div>
                      <div class="radio-inline text-danger">
                        <label>
                          <input type="radio"   name="status" value="deactive"  <?php if($status =="deactive") echo "checked"?>> <?php echo $this->lang->line('deactive')?>
                        </label>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success update_store">
                      <i class="fa fa-save"></i>
						<?php echo $this->lang->line('save')?>
                    </button>
                    <a href="<?php echo base_url('store/listStore')?>" class="btn btn-info ">
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
    <script src="<?php echo base_url();?>assets/js/store/index.js"></script>
    <script type="text/javascript">
   var select =  $('#selectize_province').selectize({
        create: false,
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        maxItems: 1,
        sortField: {
            field: 'name',
            direction: 'asc'
        },
        onChange: function(value) {
          var formData = {
                id: value,
                // code: code
            };
            $.ajax({
            url :  _url.base_url + '/store/get_district_by_province',
            type: "POST",
            data : formData,
            dataType : 'json',
            beforeSend: function(){$("#loading").show();},
            success: function(data) {
                if (data.res) {
                  var selectClass = $('#selectize_district').selectize();
                  var selectizeClass = selectClass[0].selectize;
                  selectizeClass.clear();
                  selectizeClass.clearOptions();
                  selectizeClass.load(function(callback) {
                      callback(data.data);
                  });

                } else {
                 
                }
            },
            error: function(data) {
               
            }
          });
        }
       
    });

    var select_district =  $('#selectize_district').selectize({
        create: false,
        valueField: 'code',
        labelField: 'name',
        searchField: 'name',
        maxItems: 1,
        sortField: {
            field: 'name',
            direction: 'asc'
        }
    });
</script>
