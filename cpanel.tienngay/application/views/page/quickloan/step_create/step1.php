<div class="x_panel setup-content" id="step-1">
  <div class="x_content">
    <div class="x_title">
        <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Customer_information')?></strong>
        <div class="clearfix"></div>
    </div>
    <!-- <input type="date" name="DateName" id="DateID" min="2000-01-01" max="2100-12-31"/> -->
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Customer_information')?>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="radio-inline text-primary">
            <label>  <input type="radio" value="1" name="status_customer" checked><?= $this->lang->line('new_customer')?></label>
        </div>
        <div class="radio-inline text-danger">
            <label><input type="radio" value="2" name="status_customer"><?= $this->lang->line('Old_customer')?></label>
        </div>
      </div>
    </div>
    
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Customer_name')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="customer_name" required class="form-control">
      </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('phone_number')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" required id="customer_phone_number" class="form-control phone-autocomplete">
        </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      Email <span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="email" required id="customer_email" class="form-control email-autocomplete">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('number_cmnd')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" required id="customer_identify" class="form-control identify-autocomplete">
      </div>
    </div>
  
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Sex')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="radio-inline text-primary">
            <label><input name='customer_gender' value="1" checked type="radio">&nbsp;<?= $this->lang->line('male')?></label>
        </div>
        <div class="radio-inline text-danger">
            <label><input name='customer_gender' value="2" type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Birthday')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <!-- <div class="input-group date" id="myDatepicker1"> -->
          <input type="date" id="customer_BOD" type='text' class="form-control"  max="2002-12-31" min="1960-01-01"/>
          <!-- <input id="customer_BOD" type='date' min='1960-01-01' max='2002-30-12'> -->
          <!-- <input type="text" class="form-control">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span> -->
        <!-- </div> -->
        <!-- <script>
        $('#myDatepicker1').datetimepicker({format: 'DD-MM-YYYY'});
        </script> -->
      </div>
    </div>

    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Marital_status')?><span class="text-danger">*</span>
      </label>
      <div class="col-lg-6 col-sm-12 col-12">
        <div class="radio-inline text-primary">
            <label><input name='marriage' checked="" value="1" type="radio">&nbsp;Đã kết hôn</label>
        </div>
        <div class="radio-inline text-primary">
            <label><input name='marriage' value="2" type="radio">&nbsp;Chưa kết hôn</label>
        </div>
        <div class="radio-inline text-primary">
            <label><input name='marriage' value="3" type="radio">&nbsp;Ly hôn</label>
        </div>
      </div>
    </div>

    <!--địa chỉ hộ khẩu-->
      <div class="x_title">
          <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('The_address')?></strong>
          <div class="clearfix"></div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Province_City1')?> <span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_province_current_address">
              <option value=""><?= $this->lang->line('Province_City2')?></option>
              <?php 
              if(!empty($provinceData)){
                  foreach($provinceData as $key => $province){
              ?>
                  <option value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('District')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_district_current_address">
              <option value=""><?= $this->lang->line('District1')?></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Wards')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_ward_current_address">
              <option value=""> <?= $this->lang->line('Wards1')?></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('address_is_in')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="current_stay_current_address" required class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
            <?= $this->lang->line('Residence_form')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="form_residence_current_address">
              <option value="Tạm trú"> Tạm trú</option>
              <option value="Thường trú"> Thường trú</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Time_live')?> 
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="time_life_current_address" required class="form-control">
        </div>
      </div>
 <!--địa chỉ đang ở-->
      <div class="x_title">
         <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Household_address')?></strong>
         <div class="clearfix"></div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Province_City1')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control"   id="selectize_province_household">
              <option value=""><?= $this->lang->line('Province_City2')?></option>
              <?php 
                  if(!empty($provinceData)){
                      foreach($provinceData as $key => $province){
                  ?>
                      <option  value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('District')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control"   id="selectize_district_household">
              <option value=""><?= $this->lang->line('District1')?></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Wards')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control"   id="selectize_ward_household">
              <option value=""><option value=""><?= $this->lang->line('Wards1')?></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('address_is_in')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="address_household" required class="form-control">
        </div>
      </div>
      <button class="btn btn-primary  pull-right save_contract" data-step="1"   type="button" data-toggle="modal" data-target="#saveContract">Lưu lại</button>
    <button class="btn btn-primary nextBtnCreate pull-right" data-step="1"  type="button">Tiếp tục</button>
  </div>
</div>
