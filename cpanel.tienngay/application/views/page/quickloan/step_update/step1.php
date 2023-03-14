<div class="x_panel setup-content" id="step-1">
  <div class="x_content">
    <div class="x_title">
        <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Customer_information')?></strong>
        <div class="clearfix"></div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Customer_name')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="customer_name" required value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_name : "" ?>" class="form-control">
      </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('phone_number')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" required id="customer_phone_number" value="<?= $contractInfor->customer_infor->customer_phone_number ? $contractInfor->customer_infor->customer_phone_number : "" ?>" class="form-control phone-autocomplete">
        <div id="resultsPhone" class="smartsearchresult "></div>
        </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      Email <span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="email" required id="customer_email" value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_email : "" ?>" class="form-control email-autocomplete">
        <div id="results" class="smartsearchresult "></div>
      </div>
    </div>
  
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('number_cmnd')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" required id="customer_identify" value="<?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>" class="form-control identify-autocomplete">
         <div id="resultsIdentify" class="smartsearchresult "></div>
      </div>
    </div>
  
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Sex')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="radio-inline text-primary">
          <label><input name='customer_gender' value="1" <?= $contractInfor->customer_infor->customer_gender == 1 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('male')?></label>
        </div>
        <div class="radio-inline text-danger">
        <label><input name='customer_gender' value="2" <?= $contractInfor->customer_infor->customer_gender == 2 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Birthday')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="date" id="customer_BOD" type='text' value="<?= $contractInfor->customer_infor->customer_BOD ? $contractInfor->customer_infor->customer_BOD : "" ?>" class="form-control" />
      </div>
    </div>
    
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Marital_status')?><span class="text-danger">*</span>
      </label>
      <div class="col-lg-6 col-sm-12 col-12">
        <div class="radio-inline text-primary">
        <label><input name='marriage' value="1" <?= $contractInfor->customer_infor->marriage == 1 ? "checked" : "" ?> type="radio">&nbsp;Đã kết hôn</label>
        </div>
        <div class="radio-inline text-primary">
        <label><input name='marriage' value="2" <?= $contractInfor->customer_infor->marriage == 2 ? "checked" : "" ?> type="radio">&nbsp;Chưa kết hôn</label>
        </div>
        <div class="radio-inline text-primary">
        <label><input name='marriage' value="3" <?= $contractInfor->customer_infor->marriage == 3 ? "checked" : "" ?> type="radio">&nbsp;Ly hôn</label>
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
                    <option <?= $contractInfor->current_address->province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
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
              <?php 
              if(!empty($districtData)){
                  foreach($districtData as $key => $district){
              ?>
                  <option <?= $contractInfor->current_address->district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Wards')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control" id="selectize_ward_current_address">
                <option value=""><?= $this->lang->line('Wards1')?></option>
                <?php 
                if(!empty($wardData)){
                    foreach($wardData as $key => $ward){
                ?>
                    <option <?= $contractInfor->current_address->ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
                <?php }}?>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('address_is_in')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="current_stay_current_address" value="<?= $contractInfor->current_address->current_stay ? $contractInfor->current_address->current_stay : "" ?>" required class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
            <?= $this->lang->line('Residence_form')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="form_residence_current_address">
              <option  <?= $contractInfor->current_address->form_residence == 'Tạm trú' ? "selected" : "" ?>  value="Tạm trú"> Tạm trú</option>
              <option <?= $contractInfor->current_address->form_residence == 'Thường trú' ? "selected" : "" ?>  value="Thường trú"> Thường trú</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Time_live')?> 
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="time_life_current_address" value="<?= $contractInfor->current_address->time_life ? $contractInfor->current_address->time_life : "" ?>" required class="form-control">
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
          <select class="form-control" id="selectize_province_household">
              <option value=""><?= $this->lang->line('Province_City2')?></option>
              <?php 
              if(!empty($provinceData_)){
                  foreach($provinceData_ as $key => $province){
              ?>
                  <option <?= $contractInfor->houseHold_address->province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('District')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_district_household">
              <option value=""><?= $this->lang->line('District1')?> </option>
              <?php 
              if(!empty($districtData_)){
                  foreach($districtData_ as $key => $district){
              ?>
                  <option <?= $contractInfor->houseHold_address->district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Wards')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_ward_household">
              <option value=""><?= $this->lang->line('Wards1')?></option>
              <?php 
              if(!empty($wardData_)){
                  foreach($wardData_ as $key => $ward){
              ?>
                  <option <?= $contractInfor->houseHold_address->ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('address_is_in')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="address_household" value="<?= $contractInfor->houseHold_address->address_household ? $contractInfor->houseHold_address->address_household : "" ?>" required class="form-control">
        </div>
      </div>
    <button class="btn btn-primary nextBtnCreate pull-right" data-step="1"  type="button">Tiếp tục</button>
  </div>
</div>
