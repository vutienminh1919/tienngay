<!-- page content -->
<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3><?= $this->lang->line('detail_loan_contract')?> / <?= $contractInfor->code_contract?>
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('pawn/contract')?>"><?php echo $this->lang->line('Contract_management')?></a> / <a href="#"><?php echo $this->lang->line('detail_loan_contract')?></a>
                    </small>
                    </h3>
					<div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="page-title">
				<div class="text-right">
					<a href="<?php echo base_url('pawn/contract')?>" class="btn btn-info "> Quay lại </a>
					<a href="javascript:void(0)" onclick="showModal()" class="btn btn-info "> Lịch sử </a>



                    <?php
                                                if($contractInfor->status != 0)  {?>
												<a href="<?php echo base_url("pawn/viewImageAccuracy?id=").$contractInfor->_id->{'$oid'}?>" class="btn btn-info ">
													Xem chứng từ
												</a>
                                                <?php }?>
    <!--check accessright  vận hành theo trạng thái  -->   
                                                                                                
                                                <?php 
                                                // check accessright của vận hành theo trạng thái 
                                                    if(in_array('giao-dich-vien', $groupRoles)){
                                                    ?>
                                                    <?php
                                                     // buttom gửi cht duyệt 
                                                        if(in_array($contractInfor->status, array(1,4)) 
                                                                && in_array("5dedd24f68a3ff3100003649",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="gui_cht_duyet(this)" data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ''?>"  class="btn btn-info gui_cht_duyet">
                                                            Gửi duyệt
                                                        </a>
                                                    <?php }?>
                                                    <?php 
                                                    // buttom hủy hợp đồng
                                                        if(in_array($contractInfor->status, array(1,4,6,7)) && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="huy_hop_dong(this)"  data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
                                                    <?php }?>
                                                <?php }?>
 <!--check accessright hàng trưởng theo trạng thái  -->
                                                <?php 
                                                // check accessright của của hàng trưởng theo trạng thái 
                                                    if(in_array('cua-hang-truong', $groupRoles)){
                                                    ?>

                                                    <?php 
                                                      // buttom Của hàng trưởng từ chối hợp đồng
                                                        if(in_array($contractInfor->status, array(2)) 
                                                                && in_array("5dedd2c868a3ff310000364a",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="cht_tu_choi(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info cht_tu_choi"  > Không duyệt </a>
                                                    <?php }?>
                                                    <?php 
                                                     // buttom chuyển lên hội sở
                                                        if(in_array($contractInfor->status, array(2)) 
                                                                && in_array("5dedd2d868a3ff310000364b",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="chuyen_hoi_so(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info chuyen_hoi_so" > Duyệt </a>
                                                    <?php }?>

                                                    <!-- <?php 
                                                    // buttom tạo lại hợp đồng
                                                        if(in_array($contractInfor->status, array(3)) 
                                                               && in_array("5da98b8568a3ff2f10001b06",  $userRoles->role_access_rights))  {?>
                                                        <a href="#" class="btn btn-info "> Tạo lại </a>
                                                    <?php }?> -->
                                                 
                                                    <?php 
                                                   // buttom hủy hợp đồng
                                                        if(in_array($contractInfor->status, array(1,2,4,6,7)) 
                                                                && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)"  onclick="huy_hop_dong(this)"  data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info huy_hop_dong" >Hủy hợp đồng </a>
                                                    <?php }?>
                                                <?php }?>

  <!--check accessright của hội sở theo trạng thái -->
                                                <?php 
                                                // check accessright của hội sở theo trạng thái 
                                                    if(in_array('hoi-so', $groupRoles)){
                                                    ?>
                                                     <?php 
                                                   // buttom hủy hợp đồng
                                                        if(in_array($contractInfor->status, array(5)) 
                                                                && in_array("5e65a5c33894ad25f051b756",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info huy_hop_dong" >HS không duyệt </a>
                                                    <?php }?>
                                                    <?php 
                                                    // buttom duyet hợp đồng
                                                        if(in_array($contractInfor->status, array(5)) 
                                                                && in_array("5dedd2e668a3ff310000364c",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="hsduyet(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info duyet"> Duyệt </a>
                                                    <?php }?>
                                                    <?php 
                                                   // buttom hủy hợp đồng
                                                        if(in_array($contractInfor->status, array(5)) 
                                                                && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info huy_hop_dong" >Hủy hợp đồng </a>
                                                    <?php }?>
                                                  
                                                <?php }?>

  <!--check accessright của kế toán theo trạng thái -->

                                                <?php 
                                             
                                                    if(in_array('ke-toan', $groupRoles)){
                                                    ?>
                                                    <?php 
                                                    // buttom kế toán ko duyệt hợp đồng
                                                        if(in_array($contractInfor->status, array(15)) 
                                                                && in_array("5def401b68a3ff1204003adb",  $userRoles->role_access_rights))  {?>
                                                        <a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"  data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info ketoan_tu_choi" > Không duyệt </a>
                                                    <?php }?>
                                               
                                                    <?php 
                                                   // buttom hủy hợp đồng
                                                        if(in_array($contractInfor->status, array(15)) 
                                                                && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights)) {?>
                                                        <a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
                                                    <?php }?>

                                                <?php }?>
    <!--check accessright  supper admin  và vận hành theo trạng thái  -->       
                                        <!-- gdv -->
                                                <?php 
                                                 //check accessright của  supper admin theo trạng thái 
                                                    if($userSession['is_superadmin'] == 1  || in_array('van-hanh', $groupRoles))  {?>

                                                    <?php
                                                     // buttom gửi cht duyệt 
                                                        if(in_array($contractInfor->status, array(1,4)))  {?>
                                                        <a href="javascript:void(0)" onclick="gui_cht_duyet(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info gui_cht_duyet">
                                                            Gửi duyệt
                                                        </a>
                                                    <?php }?>

                                            <!-- Cht -->
                                                    <?php 
                                                      // buttom Của hàng trưởng từ chối hợp đồng
                                                        if(in_array($contractInfor->status, array(2)))  {?>
                                                        <a href="javascript:void(0)" onclick="cht_tu_choi(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info cht_tu_choi"  > CHT Không duyệt </a>
                                                    <?php }?>
                                                    <?php 
                                                     // buttom chuyển lên hội sở
                                                        if(in_array($contractInfor->status, array(2)))  {?>
                                                        <a href="javascript:void(0)" onclick="chuyen_hoi_so(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info chuyen_hoi_so" > CHT Duyệt </a>
                                                    <?php }?>
                                            <!-- hội sở -->
                                                     <?php 
                                                   // buttom hủy hợp đồng
                                                        if(in_array($contractInfor->status, array(5)))  {?>
                                                        <a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info huy_hop_dong" >HS không duyệt </a>
                                                    <?php }?>
                                                    <?php 
                                                    // buttom duyet hợp đồng
                                                        if(in_array($contractInfor->status, array(5)))  {?>
                                                        <a href="javascript:void(0)" onclick="hsduyet(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info duyet">Hội sở Duyệt </a>
                                                    <?php }?>
                                            <!-- kế toán -->
                                                
                                                    <?php 
                                                    // buttom kế toán ko duyệt hợp đồng
                                                        if(in_array($contractInfor->status, array(15)))  {?>
                                                        <a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"  data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info ketoan_tu_choi" >KT Không duyệt </a>
                                                    <?php }?>

                                                    <?php 
                                                    // buttom kế toán ko duyệt hợp đồng
                                                        if(in_array($contractInfor->status, array(1,2,4,5,6,7,15)))  {?>
                                                         <a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id=<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""?>  class="btn btn-info huy_hop_dong" >Hủy hợp đồng </a>
                                                    <?php }?>
                                                <?php }?>


				</div>
			</div>
		</div>
		<div class="col-12 col-lg-12">
            <div class="x_panel ">
                <div class="x_content ">
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
                              
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('number_cmnd')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" required id="customer_identify" value="<?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>" class="form-control identify-autocomplete">
                                        <div id="resultsIdentify" class="smartsearchresult "></div>
                                    </div>
                                </div>
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
                                        <input disabled type="text" required id="customer_phone_number" value="<?= $contractInfor->customer_infor->customer_phone_number ? $contractInfor->customer_infor->customer_phone_number : "" ?>" class="form-control phone-autocomplete">
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
                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <?= $this->lang->line('Facebook')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" required id="customer_fb" value="<?= $contractInfor->customer_infor->customer_fb ? $contractInfor->customer_infor->customer_fb : "" ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <?= $this->lang->line('Number_household')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" required id="customer_household" value="<?= $contractInfor->customer_infor->customer_household ? $contractInfor->customer_infor->customer_household : "" ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <?= $this->lang->line('Passport')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="customer_passport" value="<?= $contractInfor->customer_infor->customer_passport ? $contractInfor->customer_infor->customer_passport : "" ?>" class="form-control">
                                    </div>
                                </div>
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Insurance_book')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" required id="customer_insurance" value="<?= $contractInfor->customer_infor->customer_insurance ? $contractInfor->customer_infor->customer_insurance : "" ?>" class="form-control">
                                    </div>
                                </div> -->
                                <!--end thông tin cá nhân-->
                                <!-- địa chỉ đang ở-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('The_address')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Province_City1')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="selectize_province_current_address" disabled>
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
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('District')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="selectize_district_current_address" disabled>
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
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Wards')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select disabled class="form-control" id="selectize_ward_current_address">
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
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Residence_form')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <!-- <input type="text" id="form_residence_current_address" value="<?= $contractInfor->current_address->form_residence ? $contractInfor->current_address->form_residence : "" ?>" required class="form-control"> -->

                                        <select disabled class="form-control" id="form_residence_current_address">
                                            <option  <?= $contractInfor->current_address->form_residence == 'Tạm trú' ? "selected" : "" ?>  value="Tạm trú"> Tạm trú</option>
                                            <option <?= $contractInfor->current_address->form_residence == 'Thường trú' ? "selected" : "" ?>  value="Thường trú"> Thường trú</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Time_live')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="time_life_current_address" value="<?= $contractInfor->current_address->time_life ? $contractInfor->current_address->time_life : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('address_is_in')?> <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="current_stay_current_address" value="<?= $contractInfor->current_address->current_stay ? $contractInfor->current_address->current_stay : "" ?>" required class="form-control">
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
                                        <input type="number" id="phone_number_company" value="<?= $contractInfor->job_infor->phone_number_company ? $contractInfor->job_infor->phone_number_company : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Job_position')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="job_position" value="<?= $contractInfor->job_infor->job_position ? $contractInfor->job_infor->job_position : "" ?>" required class="form-control">
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
                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('job')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="name_job" value="<?= $contractInfor->job_infor->name_job ? $contractInfor->job_infor->name_job : "" ?>" required class="form-control">
                                    </div>
                                </div> -->
                                
                                <!-- 
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Tax_code')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="number_tax_company" value="<?= $contractInfor->job_infor->number_tax_company ? $contractInfor->job_infor->number_tax_company : "" ?>" required class="form-control">
                                    </div>
                                </div> -->
                               
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
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Telephone_number_relative')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="phone_number_relative_1" value="<?= $contractInfor->relative_infor->phone_number_relative_1 ? $contractInfor->relative_infor->phone_number_relative_1 : "" ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Residential_address')?><span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input disabled type="text" id="hoursehold_relative_1" value="<?= $contractInfor->relative_infor->hoursehold_relative_1 ? $contractInfor->relative_infor->hoursehold_relative_1 : "" ?>" required class="form-control">
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
                                  
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <?= $this->lang->line('Telephone_number_relative')?><span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input disabled type="text" id="phone_number_relative_2" value="<?= $contractInfor->relative_infor->phone_number_relative_2 ? $contractInfor->relative_infor->phone_number_relative_2 : "" ?>" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <?= $this->lang->line('Residential_address')?><span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input disabled type="text" id="hoursehold_relative_2" value="<?= $contractInfor->relative_infor->hoursehold_relative_2 ? $contractInfor->relative_infor->hoursehold_relative_2 : "" ?>" required class="form-control">
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
                                
                                    <!-- <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Who_you_living_with')?> <span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                                            <label><input name='stay_with' value="1" <?= $contractInfor->customer_infor->stay_with == 1 ? "checked" : "" ?> type="radio">&nbsp; <?= $this->lang->line('Parents')?></label>
                                            <label><input name="stay_with" value="2" <?= $contractInfor->customer_infor->stay_with == 2 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Wife_children')?></label>
                                            <label><input name="stay_with" value="3" <?= $contractInfor->customer_infor->stay_with == 3 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Alone')?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('How_many_grandchildren')?> <span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                                            <label><input name='number_children' value="1" <?= $contractInfor->customer_infor->number_children == 1 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Not_yet1')?></label>
                                            <label><input name='number_children' value="2" <?= $contractInfor->customer_infor->number_children == 2 ? "checked" : "" ?> type="radio">&nbsp;1 <?= $this->lang->line('grandchildren')?></label>
                                            <label><input name='number_children' value="3" <?= $contractInfor->customer_infor->number_children == 3 ? "checked" : "" ?> type="radio">&nbsp;2 <?= $this->lang->line('grandchildren')?></label>
                                            <label><input name='number_children' value="4" <?= $contractInfor->customer_infor->number_children == 4 ? "checked" : "" ?> type="radio"> &nbsp;> 2 <?= $this->lang->line('grandchildren')?></label>
                                        </div>
                                    </div> -->
                                <!--end Thông tin người thân-->

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
                                            <input disabled type="text" id="money" required class="form-control number"  value="<?= $contractInfor->loan_infor->amount_money ? number_format($contractInfor->loan_infor->amount_money) : "" ?>">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Phí bảo hiểm VAT<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input disabled type="text" id="fee_gic" required class="form-control number"  value="<?= (isset($contractInfor->loan_infor->amount_GIC)) ? number_format($contractInfor->loan_infor->amount_GIC) : "" ?>">
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
                </div>
            </div>
        </div>
	

        <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve"></h5>
        <hr>


        <div class="form-group">
    <label>Ghi chú:</label>
    <textarea class="form-control approve_note" rows="5" ></textarea>
    <input type="hidden"   class="form-control status_approve">
    <input type="hidden"   class="form-control contract_id">
  </div>
        </table>
        <p class="text-right">
          <button  class="btn btn-danger approve_submit">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="hsduyet" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve"></h5>
        <hr>
        
        <div class="form-group">
           <label>Số tiền được vay:</label>
            <input type="text"   class="form-control amount_money_max" disabled>
            <label>Số tiền vay:</label>
            <input type="text"   class="form-control amount_money" disabled>
             <label>Phí bảo hiểm (VAT):</label>
            <input type="text"   class="form-control fee_gic" disabled>
            <input type="hidden" id="insurrance_contract" name="insurrance_contract" >
             <label>Số tiền giải ngân:</label>
            <input type="text"   class="form-control amount_loan" disabled>
            <label>Ghi chú:</label>
            <textarea class="form-control approve_note_hs" rows="5" ></textarea>
            <input type="hidden"   class="form-control status_approve">
            <input type="hidden"   class="form-control contract_id">
          <input type="hidden" class="tilekhoanvay"  value="<?=$tilekhoanvay?>">
         </div>
       
        </table>
        <p class="text-right">
          <button  class="btn btn-primary edit_amount_money">Sửa</button>
          <button  class="btn btn-danger approve_submit">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>





<div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Hoạt động</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <ul class="list-unstyled timeline workflow widget">
              <?php if(!empty($logs)){ 
                  foreach($logs as $key => $wl){
                ?>
                <li>
                  <img class="theavatar" src="<?php echo base_url("assets/imgs/avatar_none.png")?>" alt="">
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a><?= !empty($wl->action) ? $wl->action : "";?></a>
                      </h2>
                      <div class="byline">
                        <p><strong><?php echo !empty($wl->created_at) ? date('d/m/Y H:i:s', intval($wl->created_at) + 7*60*60) : "" ?></strong> </p>
                        <p>By: <a><?php echo !empty($wl->created_by) ? $wl->created_by : ''?></a> </p>
                        <!-- <p>To: <a>Smith Jane</a></p> -->

                      </div>
                      <div class="excerpt">
                        <p><?php echo !empty($wl->new->note) ? $wl->new->note : ''?></p>
                        <?php if(!empty($wl->action) && $wl->action =='approve'){ 
                            $old_status = $wl->old->status;
                            $new_status = $wl->new->status;
                          ?>
                        <p>
                        <?=   get_tt_contract($old_status); ?> => <?=  get_tt_contract($new_status); ?>
                        </p>
                        <?php }?>
                        <!-- <ul>
                          <li>Một nội dung nào đó</li>
                          <li><strong>Tiêu đề:</strong> ghi chú một điều gì đó</li>
                          <li>123123</li>
                        </ul> -->
                      </div>
                    </div>
                  </div>
                </li>
              <?php } }?>
            </ul>

        </div>
      </div>
    </div>

    </div>
</div>



<!-- Modal -->

<div class="modal fade" id="ContractHistoryModal" tabindex="-1" role="dialog" aria-labelledby="ContractHistoryModal" aria-hidden="true">
	<div class="modal-dialog" role="document"  style="width: 978px;max-width:95vw;">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Lịch sử Hợp đồng</h5>
				<hr>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped" style="width: 100%">
						<thead>
						<tr>
							<th>#</th>
							<th><?php echo $this->lang->line('action')?></th>
							<th><?php echo $this->lang->line('time')?></th>
							<th><?php echo $this->lang->line('change_by')?></th>
							<th><?php echo $this->lang->line('status')?></th>
							<th><?php echo $this->lang->line('note')?></th>
						</tr>
						</thead>

						<tbody>
						<?php
						if(!empty($logs)){
						foreach($logs as $key => $log){
						?>
							<tr>
								<td><?php echo $key + 1?></td>
								<td><?php echo !empty($log->action) ? $log->action : ''?></td>
								<td><?php echo !empty($log->created_at) ? date('d/m/Y H:i:s', intval($log->created_at) + 7*60*60) : "" ?></td>
								<td><?php echo !empty($log->created_by) ? $log->created_by : ''?></td>
								<td><?php
									$status = '';
									$id_status = '';
									if (!empty($log->new->status)) {
										$id_status = $log->new->status;
									} elseif (!empty($log->old->status)) {
										$id_status = $log->old->status;
									}
									if (!empty($id_status)) {
									echo get_tt_contract($id_status); 
									}
									?>
								</td>
								<td><?php echo !empty($log->new->note) ? $log->new->note : ''?></td>
							</tr>
						<?php } } 
    function get_tt_contract($id)
    {
      switch ($id) {
        case '1':
        return "Mới";
             break;
        case '2':
        return  "Chờ trưởng PGD duyệt";
           break;
        case '3':
        return  "Đã hủy";
           break;
        case '4':
        return  "Trưởng PGD không duyệt";
           break;
        case '5':
        return  "Chờ hội sở duyệt";
           break;
        case '6':
        return "Đã duyệt";
             break;
        case '7':
        return  "Kế toán không duyệt";
         case '8':
        return  "Hội sở không duyệt";
           break;
        case '15':
        return  "Chờ giải ngân";
           break;
        case '16':
        return  "Đã tạo lệnh giải ngân thành công";
           break;
        case '17':
        return  "Đang vay";
           break;
          case '18':
        return "Giải ngân thất bại";
             break;
        case '19':
        return  "Đã tất toán";
           break;
        case '20':
        return  "Đã quá hạn";
           break;
        case '21':
        return  "Chờ hội sở duyệt gia hạn";
           break;
        case '22':
        return  "Chờ kế toán duyệt gia hạn";
           break;
        case '23':
        return  "Đã gia hạn";
           break;
        case '24':
        return  "Chờ kế toán xác nhận";
           break;
    }
  }
  ?>
						</tbody>
					</table>
				</div>

			</div>

		</div>





     



	</div>
</div>
<script src="<?php echo base_url();?>assets/js/pawn/quickloan.js"></script>
<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<!-- <script src="<?php echo base_url();?>assets/js/pawn/index.js"></script> -->
<script type="text/javascript">
   function showModal() {
       $('#ContractHistoryModal').modal('show');
   }
</script>
