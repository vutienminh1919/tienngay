<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang xử lý...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Thêm mới bảo hiểm GIC Easy
						<br>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url('gic_easy') ?>">Danh sách bảo hiểm GIC Easy</a>
							/ <a href="#">Bán mới</a></small>
					</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Tên khách hàng <span class="text-danger">*</span>
								</label>
								<input type="text" name="ten_kh" class="form-control "
									   placeholder="Nhập tên khách hàng" required>
							</div>
						</div>
						
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Số điện thoại <span class="text-danger">*</span>
								</label>
								<input type="number" name="phone" class="form-control "
									   placeholder="Nhập số điện thoại" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Ngày sinh <span class="text-danger">*</span>
								</label>
								<input type="date" name="ngay_sinh" class="form-control" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
			            <label class="control-label ">
			                <?= $this->lang->line('Sex')?><span class="text-danger">*</span>
			            </label>
			           
			                <div class="radio-inline text-primary">
			                    <label><input name='gender'  value="1" checked type="radio">&nbsp;<?= $this->lang->line('male')?></label>
			                </div>
			                <div class="radio-inline text-danger">
			                    <label><input name='gender'  value="2" type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
					                </div>
					          
					        </div>
					    </div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Chứng minh thư <span class="text-danger">*</span>
								</label>
								<input type="number" name="cmt" class="form-control "
									   placeholder="Nhập CMT/CCCD" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Email <span class="text-danger">*</span>
								</label>
								<input type="email" name="mail" class="form-control "
									   placeholder="Nhập email khách hàng" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
						  <div class="form-group ">
			            <label class="control-label">
			                <?= $this->lang->line('Province_City1')?> <span class="text-danger">*</span>
			            </label>
			           
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
		        <div class="col-xs-12 col-md-6">
		        <div class="form-group">
		            <label class="control-label ">
		                <?= $this->lang->line('District')?> <span class="text-danger">*</span>
		            </label>
		           
		                <select class="form-control" id="selectize_district_current_address">
		                    <option value=""><?= $this->lang->line('District1')?></option>
		                    <?php
		                    if(!empty($districtData_ns)){
		                      
		                        foreach($districtData_ns as $key => $district){
		                            ?>
		                            <option value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
		                        <?php }}?>
		                </select>
		           
		        </div>
		    </div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Địa chỉ <span class="text-danger">*</span>
								</label>
								<input type="text" name="address" class="form-control "
									   placeholder="Nhập địa chỉ" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Phòng giao dịch <span class="text-danger">*</span>
								</label>
								<select name="store" class="form-control">
									<?php foreach ($stores as $store) {
										if (in_array($store->_id->{'$oid'}, $storeDataCentral)) continue;?>
										<option value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Thời hạn hiệu lực
									<span class="text-danger">*</span>
								</label>
								<select disabled name="thoi_han_hieu_luc" class="form-control text-danger" id="thoi_han_hieu_luc">
									<option value="1">1 năm</option>
									
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group col-md-6">
								<label class="control-label">
									Ngày hiệu lực <span class="text-danger">*</span>
								</label>
								<input name="" class="form-control text-danger"
									   placeholder="" disabled
									   value="<?php echo date('d/m/Y') ?>">
							</div>
							<div class="form-group  col-md-6">
								<label class="control-label">
									Ngày kết thúc <span class="text-danger">*</span>
								</label>
								<input name="" class="form-control text-danger" id="endDateMic"
									   placeholder="" disabled
									   value="<?php echo date('d/m/Y', strtotime("+1 year")) ?>">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Gói bảo hiểm
									<span class="text-danger">*</span>
								</label>
								<select name="gic_easy" class="form-control text-danger">
								<?php 
									foreach (gic_easy() as $key => $item) { ?>
										<option  value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group row">
								<label class="control-label">
									Giá <span class="text-danger">*</span>
								</label>
								<div class="col-lg-12  col-sm-12 col-xs-12">
									<div class="input-group">
										<span class="input-group-addon">Giá tiền</span>
										<input name="price" id="fee_gic_easy" class="form-control text-danger"
											   placeholder="" disabled
											   value="348,000">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row" >
						
							<div class="col-xs-12 col-md-6">
							<div class="form-group ">
							<label class="control-label">
								Nhãn hiệu
								<span class="text-danger">*</span>							</label>
							
								<input type="text"  id="nhan-hieu" required="" class="form-control property-infor" data-slug="nhan-hieu" data-name="Nhãn hiệu" placeholder="Nhãn hiệu">
							</div>
						</div>
							<div class="col-xs-12 col-md-6">
							<div class="form-group ">
							<label class="control-label">
								Model	
								<span class="text-danger">*</span>
							</label>
							
								<input type="text"  id="model" required="" class="form-control property-infor" data-slug="model" data-name="Model" placeholder="Model">
							</div>
						</div>
							<div class="col-xs-12 col-md-6">
							<div class="form-group ">
							<label class="control-label">
								Biển số xe	
							<span class="text-danger">*</span>
						    </label>
							
								<input type="text"  id="bien-so-xe" required="" class="form-control property-infor" data-slug="bien-so-xe" data-name="Biển số xe" placeholder="Biển số xe">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
							<label class="control-label">
								Số khung
								<span class="text-danger">*</span>
							</label>
							
								<input type="text"  id="so-khung" required="" class="form-control property-infor" data-slug="so-khung" data-name="Số khung" placeholder="Số khung">
							
						</div>
					</div>
							<div class="col-xs-12 col-md-6">
							<div class="form-group ">
							<label class="control-label">
								Số máy
							<span class="text-danger">*</span>
							</label>
						
								<input type="text"  id="so-may" required=""  class="form-control property-infor" data-slug="so-may" data-name="Số máy" placeholder="Số máy">
									
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
							<div class="form-group ">
							<label class="control-label">
								Họ tên chủ xe
							<span class="text-danger">*</span>
							</label>
							
								<input type="text"  id="ho-ten-chu-xe" required=""  class="form-control property-infor" data-slug="ho-ten-chu-xe" data-name="Họ tên chủ xe" placeholder="Họ tên chủ xe">
							
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
							<div class="form-group ">
							<label class="control-label">
								Địa chỉ đăng ký	
							<span class="text-danger">*</span>
							</label>
						
								<input type="text"  id="dia-chi-dang-ky" required=""  class="form-control property-infor" data-slug="dia-chi-dang-ky" data-name="Địa chỉ đăng ký" placeholder="Địa chỉ đăng ký">
						
								</div>
							</div>
						
		
						
					</div>
					<div class="col-md-12 col-xs-12">
						<div class="" style="text-align: center">
							<button class="btn btn-success add_gic_easy_btnSave">
								Bán mới
							</button>
							<a href="<?php echo base_url('gic_easy') ?>" class="btn btn-info ">
								<?php echo $this->lang->line('back') ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/gic_easy/form_add.js"></script>
 <script src="<?php echo base_url();?>assets/js/numeral.min.js"></script>
