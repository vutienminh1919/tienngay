                
<div class="col-xs-12 col-lg-12">
            <div class="x_panel ">
                <div class="x_content ">
					<div class="row">
						<div class="col-xs-10">
						</div>
						<div class="col-xs-2">
							<a  data-toggle="modal" data-target="#modal_edit_phone" class="btn btn-info "> Cập nhật </a>
						</div>
					</div>
					<div class="form-horizontal form-label-left">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <!--thông tin cá nhân-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Customer_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Email<span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="email" required id="customer_email" value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_email : "" ?>" class="form-control email-autocomplete">
                                        <div id="results" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <?= $this->lang->line('Customer_name')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="customer_name" required value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_name : "" ?>" class="form-control">
                                    </div>
                                </div>
                              
                              
                           <!--      <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('number_cmnd')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" required id="customer_identify" value="<?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>" class="form-control identify-autocomplete">
                                        <div id="resultsIdentify" class="smartsearchresult "></div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Sex')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                                         <label><input disabled name='customer_gender' value="1" <?= $contractInfor->customer_infor->customer_gender == 1 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('male')?></label>
                                         <label><input disabled name='customer_gender' value="2" <?= $contractInfor->customer_infor->customer_gender == 2 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <?= $this->lang->line('Birthday')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="date" id="customer_BOD" type='text' value="<?= $contractInfor->customer_infor->customer_BOD ? $contractInfor->customer_infor->customer_BOD : "" ?>" class="form-control" />
                                    </div>
                                 
                                </div>
    <div class="form-group">
        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('phone_number')?><span class="text-danger"> *</span>
        </label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
          <div class="input-group ">
        <input disabled type="text" required id="customer_phone_number" value="<?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number,$role) : "" ?>" class="form-control phone-autocomplete">
        <a class="input-group-addon" href="javascript:void(0)"
       onclick="call_for_customer('<?= !empty($contractInfor->customer_infor->customer_phone_number) ? encrypt($contractInfor->customer_infor->customer_phone_number) : "" ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'customer')"
       class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
   </div>
                <div id="resultsPhone" class="smartsearchresult "></div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <?= $this->lang->line('phone_number')?> mới
            </label>
            <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group ">
                <input disabled type="text" required id="customer_phone_number" value="<?= $log_contract_thn->customer_phone_number ? hide_phone($log_contract_thn->customer_phone_number,$role) : "" ?>" class="form-control phone-autocomplete">
                <a class="input-group-addon" href="javascript:void(0)"
                           onclick="call_for_customer('<?= !empty($log_contract_thn->customer_phone_number) ? encrypt($log_contract_thn->customer_phone_number) : "" ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'customer')"
                           class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
                       </div>
                <div id="resultsPhone" class="smartsearchresult "></div>
            </div>
        </div>
                <div class="form-group">
                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Marital_status')?> <span class="text-danger"> *</span>
                    </label>
                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                        <label><input disabled name='marriage' value="1" <?= $contractInfor->customer_infor->marriage == 1 ? "checked" : "" ?> type="radio">&nbsp;Đã kết hôn</label>
                        <label><input disabled name='marriage' value="2" <?= $contractInfor->customer_infor->marriage == 2 ? "checked" : "" ?> type="radio">&nbsp;Chưa kết hôn</label>
                    </div>
                </div>
                               
                                <!--end thông tin cá nhân-->
                                <!-- địa chỉ đang ở-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('The_address')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                               
                                  <div class="form-group">
                                   <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Địa chỉ cũ
                                  </label>
                                  <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                    <strong><?php echo $address?></strong>
                                  </div>
                                </div>
                                   <div class="form-group">
                                   <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Địa chỉ mới
                                  </label>
                                  <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                    <strong id="address"><?php echo $address_log ?></strong>
                                  </div>
                                </div>
                               
                                 <!--end địa chỉ đang ở-->
                                <!--địa chỉ hộ khẩu-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i>  <?= $this->lang->line('Household_address')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Province_City1')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select disabled class="form-control" id="selectize_province_household">
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
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('District')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select disabled class="form-control" id="selectize_district_household">
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
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Wards')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select disabled class="form-control" id="selectize_ward_household">
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
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('address_is_in')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="address_household" value="<?= $contractInfor->houseHold_address->address_household ? $contractInfor->houseHold_address->address_household : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <!--end địa chỉ hộ khẩu-->
                                <!--Thông tin việc làm-->   
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Employment_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                             
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Company_name')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="name_company" value="<?= $contractInfor->job_infor->name_company ? $contractInfor->job_infor->name_company : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Company_address')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="address_company" value="<?= $contractInfor->job_infor->address_company ? $contractInfor->job_infor->address_company : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Company_phone_number')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" disabled id="phone_number_company" value="<?= $contractInfor->job_infor->phone_number_company ? $contractInfor->job_infor->phone_number_company : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Job_position')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" disabled id="job_position" value="<?= $contractInfor->job_infor->job_position ? $contractInfor->job_infor->job_position : "" ?>" required class="form-control">
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Income')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="salary" value="<?= $contractInfor->job_infor->salary ? $contractInfor->job_infor->salary : "" ?>" required class="form-control">
                                    </div>
                                </div>
                              
                               
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Form_payment_wages')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                    <?php 
                                        $receive = !empty($contractInfor->job_infor->receive_salary_via) ? $contractInfor->job_infor->receive_salary_via : "";
                                        if(!empty($receive) && $receive == 1){
                                            $receive_salary_via = 'Tiền mặt';
                                        }else{
                                            $receive_salary_via = 'Chuyển khoản';
                                        }

                                    ?>
                                        <input disabled type="text" id="receive_salary_via" value="<?= !empty($receive_salary_via) ? $receive_salary_via : "" ?>" required class="form-control">
                                    </div>
                                </div>
                        
                                <!--end Thông tin việc làm-->
                                <!--Thông tin người thân-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Information_relatives')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                             
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Tên người tham chiếu 1<span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="fullname_relative_1" value="<?= $contractInfor->relative_infor->fullname_relative_1 ? $contractInfor->relative_infor->fullname_relative_1 : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Mối quan hệ<span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="type_relative_1" value="<?= $contractInfor->relative_infor->type_relative_1 ? $contractInfor->relative_infor->type_relative_1 : "" ?>" required class="form-control">
                                    </div>
                                </div>
      <?php if(!$log_contract_thn->phone_number_relative_1){ ?>                          
    <div class="form-group">
        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
       Số điện thoại<span class="text-danger"> *</span>
        </label>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
              <div class="input-group ">
            <input disabled type="text" id="phone_number_relative_1" value="<?= $contractInfor->relative_infor->phone_number_relative_1 ? hide_phone($contractInfor->relative_infor->phone_number_relative_1,$role) : ''  ?>" required class="form-control">
              <a class="input-group-addon" href="javascript:void(0)"
                       onclick="call_for_customer('<?= $contractInfor->relative_infor->phone_number_relative_1 ? encrypt($contractInfor->relative_infor->phone_number_relative_1) : ''  ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel1')"
                       class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
                   </div>
        </div>
    </div>
<?php }else{ ?>
<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
    Số điện thoại mới<span class="text-danger"> *</span>
    </label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
          <div class="input-group ">
        <input disabled type="text" id="phone_number_relative_1" value="<?= $log_contract_thn->phone_number_relative_1 ? hide_phone($log_contract_thn->phone_number_relative_1,$role) : '' ?> " required class="form-control">
          <a class="input-group-addon" href="javascript:void(0)"
                   onclick="call_for_customer('<?= $log_contract_thn->phone_number_relative_1 ? encrypt($log_contract_thn->phone_number_relative_1) : ''  ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel1')"
                   class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
               </div>
    </div>
</div>
<?php } ?>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo mật khoản vay tham chiếu 1</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='loan_security_one'
													  value="1" <?= $contractInfor->relative_infor->loan_security_1 == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Công khai</label>
										<label><input disabled name='loan_security_one'
													  value="2" <?= $contractInfor->relative_infor->loan_security_1 == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;Bảo mật</label>
									</div>
								</div>
                                 
                <div class="form-group">
                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <?= $this->lang->line('Residential_address')?><span class="text-danger"> *</span>
                    </label>
                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                        <input disabled type="text" id="hoursehold_relative_1" value="<?= $log_contract_thn->hoursehold_relative_1 ? $log_contract_thn->hoursehold_relative_1 : $contractInfor->relative_infor->hoursehold_relative_1  ?>"  required class="form-control">
                    </div>
                </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        Phản hồi <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                            <textarea disabled type="text" id="confirm_relativeInfor1" required="" class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_1) ? $contractInfor->relative_infor->confirm_relativeInfor_1 : "" ?></textarea>
                        </div>
                    </div>
                <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        Tên người tham chiếu 2<span class="text-danger"> *</span>
                        </label>
                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                            <input disabled type="text" id="fullname_relative_2" value="<?= $contractInfor->relative_infor->fullname_relative_2 ? $contractInfor->relative_infor->fullname_relative_2 : "" ?>" required class="form-control">
                        </div>
                    </div>
            <div class="form-group">
                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    Mối quan hệ<span class="text-danger"> *</span>
                    </label>
                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                        <input disabled type="text" id="type_relative_2" value="<?= $contractInfor->relative_infor->type_relative_2 ? $contractInfor->relative_infor->type_relative_2 : "" ?>" required class="form-control">
                    </div>
                </div>
     <?php if(!$log_contract_thn->phone_number_relative_2){ ?>                              
<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
  Số điện thoại<span class="text-danger"> *</span>
    </label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
          <div class="input-group ">
        <input disabled type="text" id="phone_number_relative_2" value="<?= $contractInfor->relative_infor->phone_number_relative_2 ? hide_phone($contractInfor->relative_infor->phone_number_relative_2,$role) : ''  ?>" required class="form-control">
          <a class="input-group-addon" href="javascript:void(0)"
               onclick="call_for_customer('<?= $contractInfor->relative_infor->phone_number_relative_2 ? encrypt($contractInfor->relative_infor->phone_number_relative_2) : ''  ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel2')"
               class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
           </div>
    </div>
</div>
<?php }else{ ?>
      <div class="form-group">
        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
       Số điện thoại mới<span class="text-danger"> *</span>
        </label>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
              <div class="input-group ">
            <input disabled type="text" id="phone_number_relative_2" value="<?= $log_contract_thn->phone_number_relative_2 ? hide_phone($log_contract_thn->phone_number_relative_2,$role) : ''  ?>" required class="form-control">
              <a class="input-group-addon" href="javascript:void(0)"
                   onclick="call_for_customer('<?= $log_contract_thn->phone_number_relative_2 ? encrypt($log_contract_thn->phone_number_relative_2) : ''  ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel2')"
                   class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
               </div>
        </div>
    </div>
<?php } ?>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo mật khoản vay tham chiếu 2</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='loan_security_two'
													  value="1" <?= $contractInfor->relative_infor->loan_security_2 == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Công khai</label>
										<label><input disabled name='loan_security_two'
													  value="2" <?= $contractInfor->relative_infor->loan_security_2 == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;Bảo mật</label>
									</div>
								</div>
    <div class="form-group">
        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Residential_address')?><span class="text-danger"> *</span>
        </label>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <input disabled type="text" id="hoursehold_relative_2"  value="<?= $log_contract_thn->hoursehold_relative_2 ? $log_contract_thn->hoursehold_relative_2 : $contractInfor->relative_infor->hoursehold_relative_2  ?>" required class="form-control">
        </div>
    </div>
        <div class="form-group">
            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
            Phản hồi <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                <textarea disabled type="text" id="confirm_relativeInfor2" required="" class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_2) ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?></textarea>
            </div>
        </div>
							<!--Tham chiếu 3-->
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Tên người tham chiếu 3<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="fullname_relative_3" value="<?= $contractInfor->relative_infor->fullname_relative_3 ? $contractInfor->relative_infor->fullname_relative_3 : "" ?>" required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Mối quan hệ<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="type_relative_3" value="<?= $contractInfor->relative_infor->type_relative_3 ? $contractInfor->relative_infor->type_relative_3 : "" ?>" required class="form-control">
									</div>
								</div>
								<?php if(!$log_contract_thn->phone_number_relative_3){ ?>
									<div class="form-group">
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
											Số điện thoại<span class="text-danger"> *</span>
										</label>
										<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
											<div class="input-group ">
												<input disabled type="text" id="phone_number_relative_3" value="<?= $contractInfor->relative_infor->phone_number_relative_3 ? hide_phone($contractInfor->relative_infor->phone_number_relative_3,$role) : ''  ?>" required class="form-control">
												<a class="input-group-addon" href="javascript:void(0)"
												   onclick="call_for_customer('<?= $contractInfor->relative_infor->phone_number_relative_3 ? encrypt($contractInfor->relative_infor->phone_number_relative_3) : ''  ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel2')"
												   class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
											</div>
										</div>
									</div>
								<?php }else{ ?>
									<div class="form-group">
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
											Số điện thoại mới<span class="text-danger"> *</span>
										</label>
										<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
											<div class="input-group ">
												<input disabled type="text" id="phone_number_relative_3" value="<?= $log_contract_thn->phone_number_relative_3 ? hide_phone($log_contract_thn->phone_number_relative_3,$role) : ''  ?>" required class="form-control">
												<a class="input-group-addon" href="javascript:void(0)"
												   onclick="call_for_customer('<?= $log_contract_thn->phone_number_relative_3 ? encrypt($log_contract_thn->phone_number_relative_3) : ''  ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel3')"
												   class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo mật khoản vay tham chiếu 3</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='loan_security_three'
													  value="1" <?= $contractInfor->relative_infor->loan_security_3 == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Công khai</label>
										<label><input disabled name='loan_security_three'
													  value="2" <?= $contractInfor->relative_infor->loan_security_3 == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;Bảo mật</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Residential_address')?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="hoursehold_relative_3"  value="<?= $log_contract_thn->hoursehold_relative_3 ? $log_contract_thn->hoursehold_relative_3 : $contractInfor->relative_infor->hoursehold_relative_3  ?>" required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Phản hồi <span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="confirm_relativeInfor2" required="" class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_2) ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?></textarea>
									</div>
								</div>
                                
                                  
                                <!--end Thông tin người thân-->

                            <!--Hình thức thanh toán khoản vay-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Payment_Debt_Method_Infor')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                             
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Ngân hàng
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" value="<?= $contractInfor->vpbank_van->bank_name ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Số tài khoản
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="type_relative_1" value="<?= $contractInfor->vpbank_van->van ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Chủ tài khoản
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="type_relative_1" value="<?= $contractInfor->vpbank_van->master_account_name ?>" required class="form-control">
                                    </div>
                                </div>
                                <!--end Hình thức thanh toán khoản vay-->

                            </div>
                            <div class="col-xs-12 col-md-6">
                                <!-- Thông tin khoản vay-->
                                <div class="x_title">
                                    <strong><i class="fa fa-money" aria-hidden="true"></i> <?= $this->lang->line('Loan_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                
                                <?php if(empty($dataInit['type_finance']) && empty($dataInit['main'])) {?>
                                    <?php 
                                        $data['configuration_formality'] = $configuration_formality;
                                        $data['mainPropertyData'] = $mainPropertyData;
                                        $this->load->view("page/property/template/loan_infor_no_init", $data)
                                    ?>
                                <?php }?>
                                
                                <!--Init from định giá tài sản-->
                                <?php if(!empty($dataInit['type_finance']) && !empty($dataInit['main'])) {?>
                                    <?php
                                        $data['configuration_formality'] = $configuration_formality;
                                        $data['mainPropertyData'] = $mainPropertyData;
                                        $data['dataInit']= $dataInit;
                                        $this->load->view("page/property/template/loan_infor_have_init.php", $data);
                                    ?>
                                <?php }?>
                               <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Số tiền vay<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="money" required class="form-control number"
                                               value="<?= $contractInfor->loan_infor->amount_money ? number_format($contractInfor->loan_infor->amount_money) : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Số tiền giải ngân<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="money_gn" required class="form-control number"
                                               value="<?= $contractInfor->loan_infor->amount_loan ? number_format($contractInfor->loan_infor->amount_loan) : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo hiểm khoản vay
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
                                        <label><input disabled name='insurrance' checked=""
                                                      value="1" <?= $contractInfor->loan_infor->insurrance_contract == 1 ? "checked" : "" ?>
                                                      type="radio">&nbsp;<?= $this->lang->line('have') ?></label>
                                        <label><input disabled
                                                      name='insurrance' <?= $contractInfor->loan_infor->insurrance_contract == 2 ? "checked" : "" ?>
                                                      value="2" type="radio">&nbsp;Không</label>
                                    </div>
                                </div>
                                <?php
                                $amount_insurrance = 0;
                                $type_amount_insurrance = '';
                                $number_day_loan = $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : 0;
                                $amount_money = isset($contractInfor->loan_infor->amount_money) ? $contractInfor->loan_infor->amount_money : 0;
                                if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "1") {
                                    $amount_insurrance = isset($contractInfor->loan_infor->amount_GIC) ? $contractInfor->loan_infor->amount_GIC : 0;
                                    $type_amount_insurrance = "GIC";
                                } else if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "2") {
                                    $amount_insurrance = isset($contractInfor->loan_infor->amount_MIC) ? $contractInfor->loan_infor->amount_MIC : 0;
                                    $type_amount_insurrance = "MIC";
                                }
                               
                                ?>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Loại bảo hiểm khoản vay<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="fee_gic" required class="form-control number"
                                               value="<?= $type_amount_insurrance ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Phí bảo hiểm khoản vay<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="fee_gic" required class="form-control number"
                                               value="<?= $amount_insurrance ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Phí bảo hiểm xe<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="fee_gic" required class="form-control number"
                                               value="<?= (isset($contractInfor->loan_infor->amount_GIC_easy)) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo hiểm phúc lộc
                                        thọ<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
                                        <input disabled type="text" id="code_GIC_plt" required class="form-control"
                                               value="<?= !empty($contractInfor->loan_infor->code_GIC_plt) ? get_code_plt($contractInfor->loan_infor->code_GIC_plt) : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Phí bảo hiểm phúc
                                        lộc thọ<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
                                        <input disabled type="text" id="amount_GIC_plt" required class="form-control"
                                               value="<?= !empty($contractInfor->loan_infor->amount_GIC_plt) ? $contractInfor->loan_infor->amount_GIC_plt : "0" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo hiểm VBI<span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select class="form-control" name="code_vbi2" disabled>
                                                    <option value=""></option>
                                                    <?php foreach (lead_VBI() as $key => $item) { ?>
                                                        <option <?php echo $contractInfor->loan_infor->code_VBI_1 == $item ? 'selected' : '' ?>
                                                                value="<?= $key ?>"><?= $item ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control" name="code_vbi2" disabled>
                                                    <option value=""></option>
                                                    <?php foreach (lead_VBI() as $key => $item) { ?>
                                                        <option <?php echo $contractInfor->loan_infor->code_VBI_2 == $item ? 'selected' : '' ?>
                                                                value="<?= $key ?>"><?= $item ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Phí bảo hiểm VBI
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">

                                        <input type="text" id="fee_vbi" class="form-control number" value="<?= (isset($contractInfor->loan_infor->amount_VBI)) ? number_format($contractInfor->loan_infor->amount_VBI) : 0 ?>" disabled>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">PTI Gói BHTN</label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
                                        <?php 
                                        $ptiBhtnGoi =  isset($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi: '';
                                        $ptiBhtnPhi =  isset($contractInfor->loan_infor->pti_bhtn->phi) ? number_format($contractInfor->loan_infor->pti_bhtn->phi): '';
                                        $ptiBhtnPrice =  isset($contractInfor->loan_infor->pti_bhtn->price) ? number_format($contractInfor->loan_infor->pti_bhtn->price): '';
                                        if ($ptiBhtnGoi && $ptiBhtnPhi && $ptiBhtnPrice) {
                                        ?>
                                        <input type="text" id="pti_bhtn_goi" class="form-control number" 
                                        value="<?= $ptiBhtnGoi . '-' . $ptiBhtnPrice; ?>" disabled>
                                        <?php } else { ?>
                                            <input type="text" id="pti_bhtn_goi" class="form-control number" value="" disabled>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">PTI Phí BHTN</label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
                                        <?php 
                                        $ptiBhtnGoi =  isset($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi: '';
                                        $ptiBhtnGoi =  isset($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi: '';
                                        $ptiBhtnPhi =  isset($contractInfor->loan_infor->pti_bhtn->phi) ? number_format($contractInfor->loan_infor->pti_bhtn->phi): '';
                                        $ptiBhtnPrice =  isset($contractInfor->loan_infor->pti_bhtn->price) ? number_format($contractInfor->loan_infor->pti_bhtn->price): '';
                                        if ($ptiBhtnGoi && $ptiBhtnPhi && $ptiBhtnPrice) {
                                        ?>
                                        <input type="text" id="pti_bhtn_fee" class="form-control number" 
                                        value="<?= $ptiBhtnPhi; ?>" disabled>
                                        <?php } else { ?>
                                            <input type="text" id="pti_bhtn_fee" class="form-control number" value="0" disabled>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('formality2')?>  <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select disabled class="form-control" id="type_interest">
                                            <option value="1" <?= $contractInfor->loan_infor->type_interest == 1 ? "selected='selected'" : "" ?>><?= $this->lang->line('Outstanding_descending')?></option>
                                            <option value="2" <?= $contractInfor->loan_infor->type_interest == 2 ? "selected='selected'" : "" ?>><?= $this->lang->line('Monthly_interest_principal_maturity')?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <?= $this->lang->line('Number_loan_days')?><span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input disabled type="text" id="number_day_loan" value="<?= $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : "" ?>" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <?= $this->lang->line('Interest_payment_period')?> <span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input disabled type="text" id="period_pay_interest" value="<?= $contractInfor->loan_infor->period_pay_interest ? $contractInfor->loan_infor->period_pay_interest : "" ?>" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo hiểm <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                                            <label><input disabled name='insurrance' checked="" value="1" <?= $contractInfor->loan_infor->insurrance_contract == 1 ? "checked" : "" ?>  type="radio">&nbsp;<?= $this->lang->line('have')?></label>
                                            <label><input disabled name='insurrance' <?= $contractInfor->loan_infor->insurrance_contract == 2 ? "checked" : "" ?> value="2" type="radio">&nbsp;Không</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Mục đích vay <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                                            <input disabled type="text" id="loan_purpose" required class="form-control" value="<?= !empty($contractInfor->loan_infor->loan_purpose) ? $contractInfor->loan_infor->loan_purpose : "" ?>">
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('note')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <textarea disabled type="text" id="note" required value="<?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?>" class="form-control"><?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?></textarea>
                                    </div>
                                </div>
                                <!--End Thông tin khoản vay-->
                                 <!--Thông tin tài sản-->
                                <div class="x_title">
                                    <strong><i class="fa fa-motorcycle" aria-hidden="true"></i>  <?= $this->lang->line('Property_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class='properties'>
                                    <?php if(!empty($contractInfor->property_infor)) { foreach($contractInfor->property_infor as $item) {  ?>
                                        <div class="form-group"></div>
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $item->name?><span class="text-danger"> *</span></label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input disabled type="text" name="property_infor" required value="<?= $item->value?>" class="form-control property-infor" data-slug="<?= $item->slug?>" data-name="<?= $item->name?>" placeholder="<?= $item->name?>">
                                        </div>
                                    <?php }}?>
                                </div>
                                    <!--thông tin giai ngan-->
                                    <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin giải ngân</strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Hình thức<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                         <select disabled class="form-control" id="type_payout">
                                            <option value="2" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'selected';?> >Tài khoản ngân hàng</option>
                                            <option value="3" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'selected';?>>Thẻ atm</option>
                                       
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Ngân Hàng<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select disabled class="form-control" id="selectize_bank_vimo">
                                            <option value="">Chọn ngân hàng</option>
                                            <?php 
                                            if(!empty($bankVimoData)){
                                                foreach($bankVimoData as $key => $bank){
                                            ?>
                                                <option  value="<?= !empty($bank->bank_id) ? $bank->bank_id : "";?>" <?php if($contractInfor->receiver_infor->bank_id == $bank->bank_id) echo 'selected';?> ><?= !empty($bank->name) ? $bank->name : "";?> ( <?= !empty($bank->short_name) ? $bank->short_name : "";?> )</option>
                                            <?php }}?>
                                        </select>

                                        <div id="results" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                   Chi nhánh<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" required id="bank_branch" class="form-control identify-autocomplete" value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
                                        <div id="resultsIdentify" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Số tài khoản<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" required id="bank_account" class="form-control phone-autocomplete" value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
                                        <div id="resultsPhone" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Chủ tài khoản<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" required id="bank_account_holder" class="form-control identify-autocomplete"  value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
                                        <div id="resultsIdentify" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Số thẻ atm <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="atm_card_number" type='text' class="form-control" value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?>>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Tên chủ thẻ atm<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" required id="atm_card_holder" class="form-control" value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?>>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Nội dung <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" required id="description_bank" class="form-control" value="<?= !empty($contractInfor->receiver_infor->description) ? $contractInfor->receiver_infor->description : "" ?>">
                                    </div>
                                </div> -->
                                <!--end thông tin giai ngan-->
                                  <!--thông tin giai ngan-->
                                  <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin thẩm định</strong>
                                    <div class="clearfix"></div>
                                </div>
                               
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Thẩm định hồ sơ<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <textarea disabled type="text" id="expertise_file" required="" class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_file) ? $contractInfor->expertise_infor->expertise_file : "" ?></textarea>
                                        <div id="resultsPhone" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Thẩm định thực địa<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <textarea  disabled type="text" id="expertise_field" required="" class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_field) ? $contractInfor->expertise_infor->expertise_field : "" ?></textarea>
                                        <div id="resultsIdentify" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                
                           
                                <!--end thông tin giai ngan-->
                                   <!--thông tin phong giao dich-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin phòng giao dịch</strong>
                                    <div class="clearfix"></div>
                                </div>
                               
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Phòng giao dịch<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                    <select disabled class="form-control" id="stores">
                                    
                                        <option><?= !empty($contractInfor->store->name) ? $contractInfor->store->name : ""?></option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                  $ck_tt=0;
                                  $current_day = strtotime(date('m/d/Y'));
                                  $datetime = !empty($contractInfor->expire_date) ? intval($contractInfor->expire_date): $current_day;
                                  $time = intval(($current_day - $datetime) / (24*60*60));
                                    if($contractInfor->status ==24 || $time >= 0 )
                                    {
                                      $ck_tt=1;
                                    }
                              ?>
                                <input type="hidden" id="ck_tt"  value="<?=$ck_tt?>">
                                <input type="hidden" id="status_ct"  value="<?= !empty($contractInfor->status) ? $contractInfor->status : ""?>">
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Người tạo<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text"  class="form-control" value="<?= !empty($contractInfor->created_by) ? $contractInfor->created_by : "" ?>" >
                                    </div>
                                </div>
                                <!--end thông tin phong giao dich-->
                            </div>
                           <!--End Thông tin tài sản-->

                          </div>
                                </div>
                                <!--end thông tin phong giao dich-->
        </div>     </div></div>     
                              
<script type="text/javascript">
    $('#type_loan').prop('disabled', true);
    $('#type_property').prop('disabled', true);
    $('#selectize_property_by_main').prop('disabled', true);
</script>
