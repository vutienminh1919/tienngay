<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/home/css/qlhd_hopdong.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"
		integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@1.8.3/dist/css/lightgallery.min.css">
<script src="https://cdn.jsdelivr.net/npm/lightgallery@1.8.3/dist/js/lightgallery-all.min.js"></script>


<!-- -------------- -->
<div class="right_col sum" role="main">
	<div class="container-contract">
		<h2>Chi tiết hợp đồng vay : <?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : '' ?>
			- <?= !empty($contractInfor->code_contract_disbursement) ? $contractInfor->code_contract_disbursement : '' ?>
			- <?= !empty($contractInfor->status) ? contract_status($contractInfor->status) : '' ?></h2>
		<div class="contract-top">
			<?php
			if (
				in_array($contractInfor->status, array(15, 10))
				&& in_array("5def401b68a3ff1204003adb", $userRoles->role_access_rights)
			) { ?>
				<div class="btn-content btn-contents">
					<div class=" ">
						<button type="button" class="btn btn-primary">Giải ngân hợp đồng</button>
					</div>
					<div class="btn-icon1" style="display: none;">
						<a target="_blank"
						   href="<?php echo base_url("pawn/disbursement/") ?><?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
						   class="btn btn-primary"> Giải ngân</a>
						<?php if ($contractInfor->loan_infor->amount_money <= 300000000) { ?>

							<a target="_blank"
							   href="<?php echo base_url("pawn/disbursement_nl/") ?><?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="btn btn-warning"> Giải ngân ngân
								lượng</a>

						<?php } ?>
						<?php if ($contractInfor->loan_infor->amount_money > 300000000) { ?>
							<a target="_blank"
							   href="<?php echo base_url("pawn/disbursement_nl_max/") ?><?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="btn btn-warning"> Giải ngân ngân
								lượng > 300tr</a>

						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="btn-content">
				<a href="javascript:void(0)" onclick="showModal()" class="btn btn-primary">Lịch sử</a>
			</div>
			<?php
			// buttom kế toán ko duyệt hợp đồng
			if (
				in_array($contractInfor->status, array(15, 10))
				&& in_array("5def401b68a3ff1204003adb", $userRoles->role_access_rights)
			) { ?>
				<div class="btn-content">
					<a href="javascript:void(0)" class="btn btn-danger ketoan_tu_choi" onclick="ketoan_tu_choi(this)"
					   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>">Không
						duyệt</a>
				</div>
			<?php } ?>
			<?php
			// buttom hủy hợp đồng
			if (
				in_array($contractInfor->status, array(15, 10))
				&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)
			) { ?>
				<div class="btn-content">
					<a href="javascript:void(0)" onclick="huy_hop_dong(this)" class="btn btn-btn-secondary huy_hop_dong"
					   style="background-color:#949494;color: white;"
					   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>">Hủy
						hợp đồng
					</a>
				</div>
			<?php } ?>
			<div class="btn-content">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#contract_involve">Hợp
					đồng liên quan
				</button>
			</div>
			<div class="btn-content">
				<a class="btn btn-primary" href="<?php echo base_url("pawn/contract") ?>">Quay lại
				</a>
			</div>
			<!--access_right: Sửa mã hợp đồng vay-->
			<?php if (in_array("61f0fd8b96c0440a710d0424", $userRoles->role_access_rights)) : ?>
				<a href="javascript:void(0)" onclick="showModalEditCodeContractDisbursement()" class="btn btn-info ">Sửa mã hợp đồng</a>
			<?php endif; ?>
		</div>

		<div class="body-sum">
			<div class="contract-body">
				<div class="profileDetails">
					<div class="profileDetails-top">
						<h2>Chi tiết hồ sơ</h2>
						<div class="clickbtn btnst"><img src="<?php echo base_url(); ?>assets/imgs/icon/clickbtn.jpg"
														 alt=""></div>
						<div class="clickbtn1 btnst"><img src="<?php echo base_url(); ?>assets/imgs/icon/clickbtn.jpg"
														  alt=""></div>
						<div class="btn_pc">
							<div class="clickbtn2 btnst"><img src="<?php echo base_url(); ?>assets/imgs/icon/clickbtn2.jpg"
															  alt=""></div>
							<div class="clickbtn3 btnst" style="display: none"><img
									src="<?php echo base_url(); ?>assets/imgs/icon/clickbtn3.jpg"
									alt=""></div>
							<div class="clickmenu btnst"><img src="<?php echo base_url(); ?>assets/imgs/icon/menu.jpg"
															  alt="">

							<div class="menuclicktab">
								<div class="tabs">
									<div class="tab-item active">
										Thông tin khách hàng
									</div>
									<div class="tab-item">
										Thông tin việc làm
									</div>
									<div class="tab-item">
										Thông tin người thân
									</div>
									<div class="tab-item">
										Số tài khoản thu hộ
									</div>
									<div class="tab-item">
										Thông tin khoản vay
									</div>
									<div class="tab-item">
										Thông tin tài sản
									</div>
									<div class="tab-item">
										Thông tin giải ngân
									</div>
									<div class="tab-item">
										Thông tin thẩm định
									</div>
									<div class="tab-item">
										Thông tin phòng giao dịch
									</div>
									<div class="tab-item">
										Kỳ thanh toán (Dự kiến)
									</div>
									<div class="line"></div>
								</div>

							</div>
							</div>
						</div>

					</div>
					<div class="profileDetails-body">

						<div>
							<!-- Tab items -->


							<!-- Tab content -->
							<div class="tab-content">
								<div class="tab-pane active">
									<div class="content">
										<div class="customerInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin khách hàng
												</h5>
											</div>
											<div class="form-input-text">
												<p>Email</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_email : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Tên khách hàng</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_name : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số CMND/CCCD hiện tại </p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Ngày cấp</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->date_range ? date('d/m/Y', strtotime($contractInfor->customer_infor->date_range)) : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Nơi cấp</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->issued_by ? $contractInfor->customer_infor->issued_by : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số CMND/CCCD cũ</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->customer_identify_old ? $contractInfor->customer_infor->customer_identify_old : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số hộ chiếu</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->passport_number ? $contractInfor->customer_infor->passport_number : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Nơi cấp hộ chiếu</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->passport_address ? $contractInfor->customer_infor->passport_address : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Ngày cấp hộ chiếu</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->passport_date ? date('d/m/Y', strtotime($contractInfor->customer_infor->passport_date)) : "" ?>"
													   readonly>
											</div>
											<div class="form-input-radio">
												<p>Giới tính</p>
												<div class="input-radio">
													<div class="input-radio-icon">
														<input type="radio"
															   name="sex" <?= $contractInfor->customer_infor->customer_gender == 1 ? "checked" : "" ?>
															   disabled>
														<label for="">Nam</label>
													</div>
													<div class="input-radio-icon">
														<input type="radio"
															   name="sex" <?= $contractInfor->customer_infor->customer_gender == 2 ? "checked" : "" ?>
															   disabled>
														<label for="">Nữ</label>
													</div>
												</div>
											</div>
											<div class="form-input-text">
												<p>Ngày sinh</p>
												<input type="text"
													   value="<?= $contractInfor->customer_infor->customer_BOD ? date('d/m/Y', strtotime($contractInfor->customer_infor->customer_BOD)) : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số điện thoại</p>
												<div class="form-input-phone">
													<input type="text"
														   value="<?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number) : "" ?>"
														   readonly>
												</div>

											</div>
											<?php
											$customer_resources = !empty($contractInfor->customer_infor->customer_resources) ? $contractInfor->customer_infor->customer_resources : "";
											$resources = "";
											if ($customer_resources == '1') {
												$resources = "Digital";
											}
											if ($customer_resources == '2') {
												$resources = "TLS Tự kiếm";
											}
											if ($customer_resources == '3') {
												$resources = "Tổng đài";
											}
											if ($customer_resources == '4') {
												$resources = "Giới thiệu";
											}
											if ($customer_resources == '5') {
												$resources = "Đối tác";
											}
											if ($customer_resources == '6') {
												$resources = "Fanpage";
											}
											if ($customer_resources == '7') {
												$resources = "Nguồn khác";
											}
											if ($customer_resources == '8') {
												$resources = "KH vãng lai";
											}
											if ($customer_resources == '9') {
												$resources = "KH tự kiếm";
											}
											if ($customer_resources == '10') {
												$resources = "Cộng tác viên";
											}
											if ($customer_resources == '11') {
												$resources = "KH giới thiệu KH";
											}
											if ($customer_resources == '12') {
												$resources = "Nguồn App Mobile";
											}
											if ($customer_resources == 'VM') {
												$resources = "Nguồn vay mượn";
											}
											if ($customer_resources == 'hoiso') {
												$resources = "Nguồn hội sở";
											}
											if ($customer_resources == 'tukiem') {
												$resources = "Nguồn tự kiếm";
											}
											if ($customer_resources == 'vanglai') {
												$resources = "Nguồn vãng lai";
											}
											if ($customer_resources == 'VPS') {
												$resources = "VPS";
											}
											if ($customer_resources == 'MB') {
												$resources = "MB";
											}
											if ($customer_resources == '14') {
												$resources = "Tool FB";
											}
											if ($customer_resources == '15') {
												$resources = "Tiktok";
											}
											if ($customer_resources == '16') {
												$resources = "Remarketing";
											}
											if ($customer_resources == 'Homedy') {
												$resources = "Homedy";
											}
											if ($customer_resources == 'Merchant') {
												$resources = "Merchant";
											}
											if ($customer_resources == '17') {
												$resources = "Nguồn ngoài";
											}
											?>
											<div class="form-input-text">
												<p>Nguồn khách hàng </p>
												<input type="text" value="<?php echo $resources ?>" readonly>
											</div>
											<?php
											if (!empty($list_ctv)) {
												foreach ($list_ctv as $key => $value) {
													if ($value->ctv_code == $contractInfor->customer_infor->list_ctv) {
														$name_ctv = $value->ctv_name;
													}
												}
											}
											?>
											<div class="form-input-text">
												<p>Cộng tác viên</p>
												<input type="text"
													   value="<?= !empty($contractInfor->customer_infor->list_ctv) ? $contractInfor->customer_infor->list_ctv . " - " . $name_ctv : "" ?>"
													   readonly>
											</div>
											<div class="form-input-radio">
												<p>Tình trạng hôn nhân</p>
												<div class="input-radio">
													<div class="input-radio-icon">
														<input type="radio"
															   name="state" <?= $contractInfor->customer_infor->marriage == 1 ? "checked" : "" ?>
															   disabled>
														<label for="">Đã kết hôn</label>
													</div>
													<div class="input-radio-icon">
														<input type="radio"
															   name="state" <?= $contractInfor->customer_infor->marriage == 2 ? "checked" : "" ?>
															   disabled>
														<label for="">Chưa kết hôn</label>
													</div>
													<div class="input-radio-icon">
														<input type="radio"
															   name="state" <?= $contractInfor->customer_infor->marriage == 3 ? "checked" : "" ?>
															   disabled>
														<label for="">Đã ly hôn</label>
													</div>
												</div>
											</div>
											<div class="form-input-radio">
												<p>Blacklist</p>
												<div class="input-radio">
													<div class="input-radio-icon">
														<input type="radio"
															   name="blacklist" <?= empty($contractInfor->customer_infor->is_blacklist) || $contractInfor->customer_infor->is_blacklist == 0 ? "checked" : "" ?>
															   disabled>
														<label for="">Không</label>
													</div>
													<div class="input-radio-icon">
														<input type="radio"
															   name="blacklist" <?= $contractInfor->customer_infor->is_blacklist == 1 ? "checked" : "" ?>
															   disabled>
														<label for="">Có</label>
													</div>
												</div>
											</div>

											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Địa
													chỉ đang ở</h5>
											</div>
											<div class="form-input-text">
												<p>Tỉnh/Thành phố</p>
												<select class="form-control" disabled>
													<option value=""><?= $this->lang->line('Province_City2') ?></option>
													<?php
													if (!empty($provinceData)) {
														foreach ($provinceData as $key => $province) {
															?>
															<option <?= $contractInfor->current_address->province == $province->code ? "selected" : "" ?>
																value="<?= !empty($province->code) ? $province->code : ""; ?>"><?= !empty($province->name) ? $province->name : ""; ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Quận/Huyện</p>
												<select class="form-control" disabled>
													<option value=""><?= $this->lang->line('District1') ?></option>
													<?php
													if (!empty($districtData)) {
														foreach ($districtData as $key => $district) {
															?>
															<option <?= $contractInfor->current_address->district == $district->code ? "selected" : "" ?>
																value="<?= !empty($district->code) ? $district->code : ""; ?>"><?= !empty($district->name) ? $district->name : ""; ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Phường/Xã</p>
												<select disabled class="form-control">
													<?php
													if (!empty($wardData)) {
														foreach ($wardData as $key => $ward) {
															?>
															<option <?= $contractInfor->current_address->ward == $ward->code ? "selected" : "" ?>
																value="<?= !empty($ward->code) ? $ward->code : ""; ?>"><?= !empty($ward->name) ? $ward->name : ""; ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Thôn/Xóm/Tổ</p>
												<input type="text"
													   value="<?= $contractInfor->current_address->current_stay ? $contractInfor->current_address->current_stay : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Hình thức cư trú</p>
												<input type="text"
													   value="<?= $contractInfor->current_address->form_residence ? $contractInfor->current_address->form_residence : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Thời gian sinh sống</p>
												<input type="text"
													   value="<?= $contractInfor->current_address->time_life ? $contractInfor->current_address->time_life : "" ?>"
													   readonly>
											</div>
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Địa
													chỉ hộ khẩu</h5>
											</div>
											<div class="form-input-text">
												<p>Tỉnh/Thành phố</p>
												<select disabled class="form-control" id="selectize_province_household">
													<option value=""><?= $this->lang->line('Province_City2') ?></option>
													<?php
													if (!empty($provinceData_)) {
														foreach ($provinceData_ as $key => $province) {
															?>
															<option <?= $contractInfor->houseHold_address->province == $province->code ? "selected" : "" ?>
																value="<?= !empty($province->code) ? $province->code : ""; ?>"><?= !empty($province->name) ? $province->name : ""; ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Quận/Huyện</p>
												<select disabled class="form-control" id="selectize_district_household">
													<option value=""><?= $this->lang->line('District1') ?> </option>
													<?php
													if (!empty($districtData_)) {
														foreach ($districtData_ as $key => $district) {
															?>
															<option <?= $contractInfor->houseHold_address->district == $district->code ? "selected" : "" ?>
																value="<?= !empty($district->code) ? $district->code : ""; ?>"><?= !empty($district->name) ? $district->name : ""; ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Phường/Xã</p>
												<select disabled class="form-control" id="selectize_ward_household">
													<option value=""><?= $this->lang->line('Wards1') ?></option>
													<?php
													if (!empty($wardData_)) {
														foreach ($wardData_ as $key => $ward) {
															?>
															<option <?= $contractInfor->houseHold_address->ward == $ward->code ? "selected" : "" ?>
																value="<?= !empty($ward->code) ? $ward->code : ""; ?>"><?= !empty($ward->name) ? $ward->name : ""; ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Thôn/Xóm/Tổ</p>
												<input type="text"
													   value="<?= $contractInfor->houseHold_address->address_household ? $contractInfor->houseHold_address->address_household : "" ?>"
													   readonly>
											</div>

										</div>

									</div>
								</div>

								<div class="tab-pane">
									<div class="content">
										<div class="jobInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin việc làm
												</h5>
											</div>
											<div class="form-input-text">
												<p>Tên công ty</p>
												<input type="text"
													   value="<?= $contractInfor->job_infor->name_company ? $contractInfor->job_infor->name_company : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Địa chỉ công ty</p>
												<input type="text"
													   value="<?= $contractInfor->job_infor->address_company ? $contractInfor->job_infor->address_company : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số điện thoại công ty</p>
												<input type="text"
													   value="<?= $contractInfor->job_infor->phone_number_company ? $contractInfor->job_infor->phone_number_company : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Vị trí/ Chức vụ</p>
												<input type="text"
													   value="<?= $contractInfor->job_infor->job_position ? $contractInfor->job_infor->job_position : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Thời gian làm việc</p>
												<input type="text"
													   value="<?= $contractInfor->job_infor->work_year ? $contractInfor->job_infor->work_year : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Thu nhập</p>
												<input type="text"
													   value="<?= $contractInfor->job_infor->salary ? number_format($contractInfor->job_infor->salary) : "" ?>"
													   readonly>
											</div>
											<?php
											$receive = !empty($contractInfor->job_infor->receive_salary_via) ? $contractInfor->job_infor->receive_salary_via : "";
											if (!empty($receive) && $receive == 1) {
												$receive_salary_via = 'Tiền mặt';
											} else if ($receive == 2) {
												$receive_salary_via = 'Chuyển khoản';
											} else {
												$receive_salary_via = '';
											}

											?>
											<div class="form-input-text">
												<p>Hình thức nhận lương</p>
												<input type="text"
													   value="<?= !empty($receive_salary_via) ? $receive_salary_via : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Nghề nghiệp</p>
												<input type="text"
													   value="<?= $contractInfor->job_infor->job ? $contractInfor->job_infor->job : "" ?>"
													   readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="relativeInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin người thân
												</h5>
											</div>
											<div class="form-input-text">
												<p> Tên người tham chiếu 1</p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->fullname_relative_1 ? $contractInfor->relative_infor->fullname_relative_1 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Mối quan hệ </p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->type_relative_1 ? $contractInfor->relative_infor->type_relative_1 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số điện thoại người thân</p>
												<div class="form-input-phone">
													<input type="text"
														   value="<?= $contractInfor->relative_infor->phone_number_relative_1 ? hide_phone($contractInfor->relative_infor->phone_number_relative_1) : "" ?>"
														   readonly>
													<!--												<div class="icon-phone">-->
													<!--													<img src="-->
													<?php //echo base_url();
													?>
													<!--assets/imgs/icon/phone.png" alt="">-->
													<!--												</div>-->
													<!--												<div class="icon-time">-->
													<!--													<img src="-->
													<?php //echo base_url();
													?>
													<!--assets/imgs/icon/time.png" alt="">-->
													<!--												</div>-->
												</div>
											</div>
											<div class="form-input-radio">
												<p>Bảo mật khoản vay tham chiếu 1</p>
												<div class="input-radio">
													<div class="input-radio-icon">
														<input disabled name='loan_security_one'
															   value="1" <?= $contractInfor->relative_infor->loan_security_1 == 1 ? "checked" : "" ?>
															   type="radio">&nbsp;
														<label>Công khai</label>
													</div>
													<div class="input-radio-icon">
														<input disabled name='loan_security_one'
															   value="2" <?= $contractInfor->relative_infor->loan_security_1 == 2 ? "checked" : "" ?>
															   type="radio">
														<label>Bảo mật</label>
													</div>
												</div>
											</div>
											<div class="form-input-text">
												<p>Địa chỉ cư trú </p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->hoursehold_relative_1 ? $contractInfor->relative_infor->hoursehold_relative_1 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Phản hồi </p>
												<textarea readonly type="text"
														  class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_1) ? $contractInfor->relative_infor->confirm_relativeInfor_1 : "" ?></textarea>
											</div>
											<div class="form-input-text">
												<p> Tên người tham chiếu 2</p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->fullname_relative_2 ? $contractInfor->relative_infor->fullname_relative_2 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Mối quan hệ </p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->type_relative_2 ? $contractInfor->relative_infor->type_relative_2 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số điện thoại người thân</p>
												<div class="form-input-phone">
													<input type="text"
														   value="<?= $contractInfor->relative_infor->phone_number_relative_2 ? hide_phone($contractInfor->relative_infor->phone_number_relative_2) : "" ?>"
														   readonly>
												</div>
											</div>
											<div class="form-input-radio">
												<p>Bảo mật khoản vay tham chiếu 2</p>
												<div class="input-radio">
													<div class="input-radio-icon">
														<input disabled name='loan_security_two'
															   value="1" <?= $contractInfor->relative_infor->loan_security_2 == 1 ? "checked" : "" ?>
															   type="radio">&nbsp;
														<label>Công khai</label>
													</div>
													<div class="input-radio-icon">
														<input disabled name='loan_security_two'
															   value="2" <?= $contractInfor->relative_infor->loan_security_2 == 2 ? "checked" : "" ?>
															   type="radio">
														<label>Bảo mật</label>
													</div>
												</div>
											</div>
											<div class="form-input-text">
												<p>Địa chỉ cư trú </p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->hoursehold_relative_2 ? $contractInfor->relative_infor->hoursehold_relative_2 : "" ?>"
													   readonly>
											</div>


											<div class="form-input-text">
												<p>Phản hồi </p>
												<textarea readonly type="text" id="confirm_relativeInfor2" required=""
														  class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_2) ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?></textarea>
											</div>
											<div class="form-input-text">
												<p> Tên người tham chiếu 3</p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->fullname_relative_3 ? $contractInfor->relative_infor->fullname_relative_3 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số điện thoại người thân</p>
												<div class="form-input-phone">
													<input type="text"
														   value="<?= $contractInfor->relative_infor->phone_relative_3 ? hide_phone($contractInfor->relative_infor->phone_relative_3) : "" ?>"
														   readonly>

												</div>
											</div>
											<div class="form-input-radio">
												<p>Bảo mật khoản vay tham chiếu 3</p>
												<div class="input-radio">
													<div class="input-radio-icon">
														<input disabled name='loan_security_three'
															   value="1" <?= $contractInfor->relative_infor->loan_security_3 == 1 ? "checked" : "" ?>
															   type="radio">&nbsp;
														<label>Công khai</label>
													</div>
													<div class="input-radio-icon">
														<input disabled name='loan_security_three'
															   value="2" <?= $contractInfor->relative_infor->loan_security_3 == 2 ? "checked" : "" ?>
															   type="radio">
														<label>Bảo mật</label>
													</div>
												</div>
											</div>
											<div class="form-input-text">
												<p>Địa chỉ cư trú </p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->address_relative_3 ? $contractInfor->relative_infor->address_relative_3 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Mục đích tham chiếu </p>
												<input type="text"
													   value="<?= $contractInfor->relative_infor->type_relative_3 ? $contractInfor->relative_infor->type_relative_3 : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Phản hồi </p>
												<textarea readonly type="text" id="confirm_relativeInfor3" required=""
														  class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor3) ? $contractInfor->relative_infor->confirm_relativeInfor3 : "" ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="collectionAccountNumber shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Số
													tài khoản thu hộ
												</h5>
											</div>
											<div class="form-input-text">
												<p> Ngân Hàng</p>
												<input type="text" value="<?= $contractInfor->vpbank_van->bank_name ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số tài khoản</p>
												<input type="text" value="<?= $contractInfor->vpbank_van->van ?>" readonly>
											</div>
											<div class="form-input-text">
												<p>Chủ tài khoản</p>
												<input type="text"
													   value="<?= $contractInfor->vpbank_van->master_account_name ?>"
													   readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="loanInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin khoản vay
												</h5>
											</div>
											<div class="form-input-text">
												<p>Hình thức vay</p>
												<select class="form-control formality" id="type_loan"
														onchange="percent_formality(this)" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
													<?php
													if ($configuration_formality) {
														foreach ($configuration_formality as $key => $cf) {
															?>
															<option data-code="<?= !empty($cf->code) ? $cf->code : "" ?>"
																	data-id="<?= !empty(getId($cf->_id)) ? getId($cf->_id) : "" ?>" <?= $dataInit['type_finance'] == getId($cf->_id) ? "selected" : "" ?>><?= !empty($cf->name) ? $cf->name : "" ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Loại tài sản</p>
												<select class="form-control" id="type_property"
														onchange="get_property_by_main_contract(this);" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
													<option></option>
													<?php
													if (!empty($mainPropertyData)) {
														foreach ($mainPropertyData as $key => $property_main) {
															if ($dataInit['main'] == getId($property_main->_id))
																$code_pro = !empty($property_main->code) ? $property_main->code : "";
															?>
															<option
																data-code="<?= !empty($property_main->code) ? $property_main->code : "" ?>"
																data-id="<?= !empty(getId($property_main->_id)) ? getId($property_main->_id) : "" ?>" <?= $dataInit['main'] == getId($property_main->_id) ? "selected" : "" ?>
																value="<?= !empty($property_main->_id->{'$oid'}) ? $property_main->_id->{'$oid'} : "" ?>"><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Sản phẩm vay</p>
												<select class="form-control"
														id="loan_product" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
													<option value="">-- Chọn sản phẩm vay --</option>
													<option id="loan_product_1"
															value="1" <?= $dataInit['loan_product'] == 1 ? "selected" : "" ?>>
														Vay nhanh xe máy
													</option>
													<option id="loan_product_2"
															value="2" <?= $dataInit['loan_product'] == 2 ? "selected" : "" ?>>
														Vay theo đăng ký - cà vẹt xe máy chính chủ
													</option>
													<option id="loan_product_3"
															value="3" <?= $dataInit['loan_product'] == 3 ? "selected" : "" ?>>
														Vay theo đăng ký - cà vẹt xe máy không chính chủ
													</option>
													<option id="loan_product_4"
															value="4" <?= $dataInit['loan_product'] == 4 ? "selected" : "" ?>>
														Cầm cố xe máy
													</option>
													<option id="loan_product_5"
															value="5" <?= $dataInit['loan_product'] == 5 ? "selected" : "" ?>>
														Cầm cố ô tô
													</option>
													<option id="loan_product_6"
															value="6" <?= $dataInit['loan_product'] == 6 ? "selected" : "" ?>>
														Vay nhanh ô tô
													</option>
													<option id="loan_product_7"
															value="7" <?= $dataInit['loan_product'] == 7 ? "selected" : "" ?>>
														Vay theo đăng ký - cà vẹt ô tô
													</option>

													<option id="loan_product_9"
															value="9" <?= $dataInit['loan_product'] == 9 ? "selected" : "" ?>>
														Vay tín chấp CBNV tập đoàn
													</option>
													<option id="loan_product_15"
															value="15" <?= $dataInit['loan_product'] == 15 ? "selected" : "" ?>>
														Vay tín chấp CBNV Phúc Bình
													</option>
													<option id="loan_product_10"
															value="10" <?= $dataInit['loan_product'] == 10 ? "selected" : "" ?>>
														Vay theo xe CBNV VFC
													</option>
													<option id="loan_product_11"
															value="11" <?= $dataInit['loan_product'] == 11 ? "selected" : "" ?>>
														Vay theo xe CBNV tập đoàn
													</option>
													<option id="loan_product_12"
															value="12" <?= $dataInit['loan_product'] == 12 ? "selected" : "" ?>>
														Vay theo xe CBNV Phúc Bình
													</option>
													<option id="loan_product_13"
															value="13" <?= $dataInit['loan_product'] == 13 ? "selected" : "" ?>>
														Quyền sử dụng đất
													</option>
													<option id="loan_product_14"
															value="14" <?= $dataInit['loan_product'] == 14 ? "selected" : "" ?>>
														Bổ sung vốn kinh doanh Online
													</option>
													<option id="loan_product_16"
															value="16" <?= $dataInit['loan_product'] == 16 ? "selected" : "" ?>>
														Sổ đỏ
													</option>
													<option id="loan_product_17"
															value="17" <?= $dataInit['loan_product'] == 17 ? "selected" : "" ?>>
														Sổ hồng, hợp đồng mua bán căn hộ
													</option>
													<option id="loan_product_18"
															value="18" <?= $dataInit['loan_product'] == 18 ? "selected" : "" ?>>
														Ứng tiền siêu tốc cho tài xế công nghệ
													</option>
													<option id="loan_product_19"
															value="19" <?= $dataInit['loan_product'] == 19 ? "selected" : "" ?>>
														Sản phẩm vay nhanh gán định vị
													</option>
												</select>
											</div>


											<div class="form-input-text">
												<p>Mã seri thiết bị</p>
												<input value="<?= !empty($contractInfor->loan_infor->device_asset_location->code) ? $contractInfor->loan_infor->device_asset_location->code : ""?>" disabled>
											</div>

											<div class="form-input-text">
												<p>Tên tài sản</p>
												<select class="form-control"
														id="selectize_property_by_main" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
													<option
														value="<?= $dataInit['sub'] ?>"><?= $dataInit['subName'] ?></option>

												</select>
											</div>
											<div class="form-input-checkbox">
												<p>Khấu hao tài sản</p>
												<div class="input-checkbox">
													<?php if ($code_pro == "XM") { ?>
														<?php foreach ($dataInit['minus'] as $item) { ?>
															<label><input <?php echo !empty($detail) && $detail == 1 ? 'readonly' : '' ?>
																	data-name="<?= $item['name'] ?>"
																	data-slug="<?= $item['slug'] ?>"
																	onchange="appraise_property(this)" <?= $item['checked'] == 1 ? "checked" : "" ?>
																	name="price_depreciation" type="checkbox"
																	value="<?= $item['price'] ?>"><?= $item['name'] ?>
															</label>
														<?php } ?>
													<?php } ?>
													<?php if ($code_pro == "OTO") { ?>
														<?php foreach ($dataInit['minus'] as $item) { ?>
															<label><input <?php echo !empty($detail) && $detail == 1 ? 'readonly' : '' ?>
																	data-name="<?= $item['name'] ?>"
																	data-slug="<?= $item['slug'] ?>"
																	onchange="appraise_property(this)" <?= $item['checked'] == 1 ? "checked" : "" ?>
																	name="price_depreciation" type="checkbox"
																	value="<?= $item['price'] ?>"><?= $item['name'] ?>
															</label>
														<?php } ?>
													<?php } ?>
												</div>
											</div>
											<div class="form-input-text">
												<p>Giá trị tài sản</p>
												<?php $rootPrice = !empty($dataInit['rootPrice']) ? $dataInit['rootPrice'] : 0;
												?>
												<input <?php echo !empty($detail) && $detail == 1 ? 'readonly' : '' ?>
													type="text" name='price_property' id='price_property'
													class="form-control " placeholder=""
													value="<?= !empty($rootPrice) ? number_format($rootPrice, 0, '.', ',') : 0; ?>"
													disabled>
												<input type="hidden" name='percent_type_loan' id="percent_type_loan"
													   value="<?= $dataInit['percent'] ?>" class="form-control "
													   placeholder="" readonly>
												<input type="hidden" name='price_goc' class="form-control "
													   value="<?= $dataInit['price_goc'] ?>" placeholder="" readonly>
											</div>
											<div class="form-input-text">
												<p>Số tiền có thể vay tối đa </p>
												<?php $editPrice = !empty($dataInit['editPrice']) ? number_format($dataInit['editPrice'], 0, '.', ',') : '0'; ?>
												<input <?php echo !empty($detail) && $detail == 1 ? 'readonly' : '' ?>
													type="text" name='amount_money' id='amount_money' class="form-control"
													placeholder="" value="<?= !empty($editPrice) ? $editPrice : 0; ?>"
													readonly>
											</div>
											<div class="form-input-text">
												<p>Số tiền vay</p>
												<input type="text"
													   value="<?= $contractInfor->loan_infor->amount_money ? number_format($contractInfor->loan_infor->amount_money) : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số tiền giải ngân </p>
												<input type="text"
													   value="<?= $contractInfor->loan_infor->amount_loan ? number_format($contractInfor->loan_infor->amount_loan) : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Mục đích vay</p>
												<input type="text"
													   value="<?= !empty($contractInfor->loan_infor->loan_purpose) ? $contractInfor->loan_infor->loan_purpose : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Thời gian vay</p>
												<input type="text"
													   value="<?= $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Chu kì đóng lãi</p>
												<input type="text"
													   value="<?= $contractInfor->loan_infor->period_pay_interest ? $contractInfor->loan_infor->period_pay_interest : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Hình thức trả lãi</p>
												<select disabled class="form-control" id="type_interest">
													<option
														value="1" <?= $contractInfor->loan_infor->type_interest == 1 ? "selected='selected'" : "" ?>><?= $this->lang->line('Outstanding_descending') ?></option>
													<option
														value="2" <?= $contractInfor->loan_infor->type_interest == 2 ? "selected='selected'" : "" ?>><?= $this->lang->line('Monthly_interest_principal_maturity') ?></option>
												</select>
											</div>
											<div class="form-input-text">
												<p>Gói phí</p>
												<select class="form-control" name="fee_id" disabled>

													<?php
													foreach ($fee_data as $key => $item) { ?>
														<option <?= $contractInfor->fee_id == $item->_id->{'$oid'} ? "selected" : "" ?>><?= $item->title ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-input-radio">
												<p>Bảo hiểm khoản vay</p>
												<div class="input-radio">
													<div class="input-radio-icon">
														<input
															type="radio" <?= $contractInfor->loan_infor->insurrance_contract == 1 ? "checked" : "" ?>
															disabled>
														<label for="">Có</label>
													</div>
													<div class="input-radio-icon">
														<input type="radio"
															   name='insurrance' <?= $contractInfor->loan_infor->insurrance_contract == 2 ? "checked" : "" ?>
															   disabled>
														<label for="">Không</label>
													</div>
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
											if ($type_amount_insurrance == "GIC")
												if (!checkBH($amount_money, $amount_insurrance, "GIC_KV", $number_day_loan, $contractInfor->created_at)) {
													$message = "Hợp đồng sai số tiền bảo hiểm khoản vay GIC.";
													echo "<script type='text/javascript'>alert('$message');</script>";
												}
											if ($type_amount_insurrance == "MIC")
												if (!checkBH($amount_money, $amount_insurrance, "MIC_KV", $number_day_loan, $contractInfor->created_at)) {
													$message = "Hợp đồng sai số tiền bảo hiểm khoản vay MIC.";
													echo "<script type='text/javascript'>alert('$message');</script>";
												}
											if (!checkBH($amount_money, $amount_insurrance, "GIC_EASY", $number_day_loan, $contractInfor->created_at)) {
												$message = "Hợp đồng sai số tiền bảo hiểm xe máy GIC EASY.";
												echo "<script type='text/javascript'>alert('$message');</script>";
											}
											?>
											<div class="form-input-text">
												<p>Loại bảo hiểm khoản vay</p>
												<input type="text" value="<?= $type_amount_insurrance ?>" readonly>
											</div>
											<div class="form-input-text">
												<p>Phí bảo hiểm khoản vay</p>
												<input type="text" value="<?= $amount_insurrance ?>" readonly>
											</div>
											<div class="form-input-text">
												<p>Phí bảo hiểm xe</p>
												<input type="text"
													   value="<?= (isset($contractInfor->loan_infor->amount_GIC_easy)) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Bảo hiểm phúc lộc thọ</p>
												<input type="text"
													   value="<?= !empty($contractInfor->loan_infor->code_GIC_plt) ? get_code_plt($contractInfor->loan_infor->code_GIC_plt) : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Phí bảo hiểm phúc lộc thọ</p>
												<input type="text"
													   value="<?= !empty($contractInfor->loan_infor->amount_GIC_plt) ? $contractInfor->loan_infor->amount_GIC_plt : "0" ?>"
													   readonly>
											</div>
											<div class="form-input-text bvi">
												<p>Bảo hiểm VBI</p>
												<select class="form-control" name="code_vbi2" disabled>
													<option value=""></option>
													<?php foreach (lead_VBI() as $key => $item) { ?>
														<option <?php echo $contractInfor->loan_infor->code_VBI_1 == $item ? 'selected' : '' ?>
															value="<?= $key ?>"><?= $item ?></option>
													<?php } ?>
												</select>
												<select class="form-control" name="code_vbi2" disabled>
													<option value=""></option>
													<?php foreach (lead_VBI() as $key => $item) { ?>
														<option <?php echo $contractInfor->loan_infor->code_VBI_2 == $item ? 'selected' : '' ?>
															value="<?= $key ?>"><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-input-text">
												<p>Phí bảo hiểm VBI</p>
												<input type="text"
													   value="<?= (isset($contractInfor->loan_infor->amount_VBI)) ? number_format($contractInfor->loan_infor->amount_VBI) : 0 ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Phí bảo hiểm TNDS</p>
												<input type="text"
													   value="<?= (isset($contractInfor->loan_infor->bao_hiem_tnds->price_tnds)) ? number_format($contractInfor->loan_infor->bao_hiem_tnds->price_tnds) : 0 ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Phí bảo hiểm PTI Vững Tâm An</p>
												<input type="text"
													   value="<?= (isset($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta)) ? number_format($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta) : 0 ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>PTI Gói BHTN</p>
												<input type="text"
													   value="<?= !empty($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>PTI Phí BHTN</p>
												<input type="text"
													   value="<?= !empty($contractInfor->loan_infor->pti_bhtn->phi) ? number_format($contractInfor->loan_infor->pti_bhtn->phi) : "0" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Mã coupon</p>
												<input type="text"
													   value="<?= !empty($contractInfor->loan_infor->code_coupon) ? $contractInfor->loan_infor->code_coupon : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Mã bảo hiểm khoản vay</p>
												<input type="text"
													   value="<?= !empty($contractInfor->code_coupon_bhkv) ? $contractInfor->code_coupon_bhkv : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số tiền bảo hiểm khoản vay</p>
												<input type="text"
													   value="<?= !empty($contractInfor->tien_giam_tru_bhkv) ? number_format($contractInfor->tien_giam_tru_bhkv) : 0 ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Ghi chú</p>
												<textarea readonly type="text" id="note" required
														  value="<?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?>"
														  class="form-control"><?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="propertyInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin tài sản</h5>
											</div>
											<?php if (!empty($contractInfor->property_infor)) {
												foreach ($contractInfor->property_infor as $item) { ?>
													<div class="form-group">
														<label
															class="control-label col-lg-6 col-md-3 col-sm-3 col-xs-12"><?= $item->name ?>
														</label>
														<div class="col-lg-11 col-md-6 col-sm-6 col-xs-12">
															<input readonly type="text" name="property_infor" required
																   value="<?= $item->value ?>" class="form-control "
																   data-slug="<?= $item->slug ?>"
																   data-name="<?= $item->name ?>"
																   placeholder="<?= $item->name ?>">
														</div>
													</div>
												<?php }
											} ?>

											<?php if (!empty($asset)) : ?>
												<div class="form-group">
													<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
														HD có tài sản đang vay
													</label>
													<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
														<?php foreach ($asset as $as) : ?>
															<?php if ($contractInfor->code_contract == $as->code_contract) : ?>
																<?php continue; ?>
															<?php endif; ?>
															<a class="btn btn-success"
															   href="<?php echo base_url("pawn/detail?id=") . $as->id ?>"><?php echo $as->code_contract ?></a>
														<?php endforeach; ?>
													</div>
												</div>
											<?php endif; ?>
											<?php if ($contractInfor->loan_infor->type_property->code == 'OTO') { ?>
												<div class="form-group">
													<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Gắn
														định
														vị
													</label>
													<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
														<label><input disabled name='gan_dinh_vi' checked=""
																	  value="1" <?= $contractInfor->loan_infor->gan_dinh_vi == 1 ? "checked" : "" ?>
																	  type="radio">&nbsp;<?= $this->lang->line('have') ?>
														</label>
														<label><input disabled
																	  name='gan_dinh_vi' <?= $contractInfor->loan_infor->gan_dinh_vi == 2 ? "checked" : "" ?>
																	  value="2" type="radio">&nbsp;Không</label>
													</div>
												</div>
											<?php } ?>
											<?php if ($contractInfor->loan_infor->type_property->code == 'OTO' && $contractInfor->loan_infor->type_loan->code == 'CC') { ?>
												<div class="form-group">
													<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Ô tô
														ngân
														hàng
														<span class="text-danger">*</span>
													</label>
													<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
														<label><input disabled name='o_to_ngan_hang' checked=""
																	  value="1" <?= $contractInfor->loan_infor->o_to_ngan_hang == 1 ? "checked" : "" ?>
																	  type="radio">&nbsp;<?= $this->lang->line('have') ?>
														</label>
														<label><input disabled
																	  name='o_to_ngan_hang' <?= $contractInfor->loan_infor->o_to_ngan_hang == 2 ? "checked" : "" ?>
																	  value="2" type="radio">&nbsp;Không</label>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="disbursementInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin giải ngân
												</h5>
											</div>
											<div class="form-input-text">
												<p>Hình thức</p>
												<select disabled class="form-control" id="type_payout">
													<option
														value="2" <?php if ($contractInfor->receiver_infor->type_payout == "2") echo 'selected'; ?>>
														Tài khoản ngân hàng
													</option>
													<option
														value="3" <?php if ($contractInfor->receiver_infor->type_payout == "3") echo 'selected'; ?>>
														Thẻ atm
													</option>
												</select>
											</div>
											<div class="form-input-text">
												<p>Số tài khoản</p>
												<input type="text"
													   value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Ngân Hàng</p>
												<input type="text"
													   value="<?= !empty($contractInfor->receiver_infor->bank_name) ? $contractInfor->receiver_infor->bank_name : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Chủ tài khoản</p>
												<input type="text"
													   value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Chi nhánh</p>
												<input type="text"
													   value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Số thẻ atm</p>
												<input type="text"
													   value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Tên chủ thẻ atm</p>
												<input type="text"
													   value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>"
													   readonly>
											</div>

										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="appraisalInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin thẩm định
												</h5>
											</div>
											<div class="form-input-text">
												<p>Thẩm định hồ sơ</p>
												<textarea readonly type="text" id="expertise_file" required=""
														  class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_file) ? $contractInfor->expertise_infor->expertise_file : "" ?></textarea>
											</div>
											<div class="form-input-text">
												<p>Thẩm định thực địa</p>
												<textarea readonly type="text" id="expertise_field" required=""
														  class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_field) ? $contractInfor->expertise_infor->expertise_field : "" ?></textarea>
											</div>
											<div class="form-input-text">
												<p>Nơi cất giữ xe</p>
												<textarea readonly type="text" id="expertise_field" required=""
														  class="form-control"><?= !empty($contractInfor->expertise_infor->car_storage) ? $contractInfor->expertise_infor->car_storage : "" ?></textarea>
											</div>

											<div class="form-input-text">
												<p>Ngoại lệ hồ sơ:</p>

												<div
													id="exception1" <?php if (empty($contractInfor->expertise_infor->exception1_value[0])) : ?> style="display: none" <?php endif; ?>>
													<select disabled id="lead_exception_E1" class="form-control"
															name="lead_exception_E1[]" multiple="multiple"
															data-placeholder="Các lý do ngoại lệ E1">
														<?php
														$value1 = (isset($contractInfor->expertise_infor->exception1_value[0]) && is_array($contractInfor->expertise_infor->exception1_value[0])) ? $contractInfor->expertise_infor->exception1_value[0] : array();
														?>
														<option
															value="1" <?= (is_array($value1) && in_array("1", $value1)) ? 'selected' : 'hidden' ?>>
															E1.1: Ngoại lệ về tuổi vay
														</option>
														<option
															value="2" <?= (is_array($value1) && in_array("2", $value1)) ? 'selected' : 'hidden' ?>>
															E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số
															không
															đủ điều kiện
														</option>
													</select>
												</div>
												<div
													id="exception2" <?php if (empty($contractInfor->expertise_infor->exception2_value[0])) : ?> style="display: none" <?php endif; ?>>
													<select disabled id="lead_exception_E2" class="form-control"
															name="lead_exception_E2[]" multiple="multiple"
															data-placeholder="Các lý do ngoại lệ E2">
														<?php
														$value2 = (isset($contractInfor->expertise_infor->exception2_value[0]) && is_array($contractInfor->expertise_infor->exception2_value[0])) ? $contractInfor->expertise_infor->exception2_value[0] : array();
														?>
														<option
															value="3" <?= (is_array($value2) && in_array("3", $value2)) ? 'selected' : 'hidden' ?>>
															E2.1: Khách hàng KT3 tạm trú dưới 6 tháng
														</option>
														<option
															value="4" <?= (is_array($value2) && in_array("4", $value2)) ? 'selected' : 'hidden' ?>>
															E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác
															minh qua chủ nhà trọ
														</option>
													</select>
												</div>
												<div
													id="exception3" <?php if (empty($contractInfor->expertise_infor->exception3_value[0])) : ?> style="display: none" <?php endif; ?>>
													<select disabled id="lead_exception_E3" class="form-control"
															name="lead_exception_E3[]" multiple="multiple"
															data-placeholder="Các lý do ngoại lệ E3">
														<?php
														$value3 = (isset($contractInfor->expertise_infor->exception3_value[0]) && is_array($contractInfor->expertise_infor->exception3_value[0])) ? $contractInfor->expertise_infor->exception3_value[0] : array();
														?>
														<option
															value="5" <?= (is_array($value3) && in_array("5", $value3)) ? 'selected' : 'hidden' ?>>
															E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu
															nhập
														</option>

													</select>
												</div>
												<div
													id="exception4" <?php if (empty($contractInfor->expertise_infor->exception4_value[0])) : ?> style="display: none" <?php endif; ?>>
													<select disabled id="lead_exception_E4" class="form-control"
															name="lead_exception_E4[]" multiple="multiple"
															data-placeholder="Các lý do ngoại lệ E4">
														<?php
														$value4 = (isset($contractInfor->expertise_infor->exception4_value[0]) && is_array($contractInfor->expertise_infor->exception4_value[0])) ? $contractInfor->expertise_infor->exception4_value[0] : array();
														?>
														<option
															value="6" <?= (is_array($value4) && in_array("6", $value4)) ? 'selected' : 'hidden' ?>>
															E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành
															của
															công ty (đất, giấy tờ khác...)
														</option>
														<option
															value="7" <?= (is_array($value4) && in_array("7", $value4)) ? 'selected' : 'hidden' ?>>
															E4.2: Ngoại lệ về lãi suất sản phẩm
														</option>

													</select>
												</div>
												<div
													id="exception5" <?php if (empty($contractInfor->expertise_infor->exception5_value[0])) : ?> style="display: none" <?php endif; ?>>
													<select disabled id="lead_exception_E5" class="form-control"
															name="lead_exception_E5[]" multiple="multiple"
															data-placeholder="Các lý do ngoại lệ E5">
														<?php
														$value5 = (isset($contractInfor->expertise_infor->exception5_value[0]) && is_array($contractInfor->expertise_infor->exception5_value[0])) ? $contractInfor->expertise_infor->exception5_value[0] : array();
														?>
														<option
															value="8" <?= (is_array($value5) && in_array("8", $value5)) ? 'selected' : 'hidden' ?>>
															E5.1: Ngoại lệ về điều kiện đối với người tham chiếu
														</option>
														<option
															value="9" <?= (is_array($value5) && in_array("9", $value5)) ? 'selected' : 'hidden' ?>>
															E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ
															thống
															phonet
														</option>

													</select>
												</div>
												<div
													id="exception6" <?php if (empty($contractInfor->expertise_infor->exception6_value[0])) : ?> style="display: none" <?php endif; ?>>
													<select disabled id="lead_exception_E6" class="form-control"
															name="lead_exception_E6[]" multiple="multiple"
															data-placeholder="Các lý do ngoại lệ E6">
														<?php
														$value6 = (isset($contractInfor->expertise_infor->exception6_value[0]) && is_array($contractInfor->expertise_infor->exception6_value[0])) ? $contractInfor->expertise_infor->exception6_value[0] : array();
														?>
														<option
															value="10" <?= (is_array($value6) && in_array("10", $value6)) ? 'selected' : 'hidden' ?>>
															E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân
															hàng
															khác
														</option>
													</select>
												</div>
												<div
													id="exception7" <?php if (empty($contractInfor->expertise_infor->exception7_value[0])) : ?> style="display: none" <?php endif; ?>>
													<select disabled id="lead_exception_E7" class="form-control"
															name="lead_exception_E7[]" multiple="multiple"
															data-placeholder="Các lý do ngoại lệ E7">
														<?php
														$value7 = (isset($contractInfor->expertise_infor->exception7_value[0]) && is_array($contractInfor->expertise_infor->exception7_value[0])) ? $contractInfor->expertise_infor->exception7_value[0] : array();
														?>
														<option
															value="11" <?= (is_array($value7) && in_array("11", $value7)) ? 'selected' : "hidden" ?>>
															E7.1: Khách hàng vay lại có lịch sử trả tiền tốt
														</option>
														<option
															value="12" <?= (is_array($value7) && in_array("12", $value7)) ? 'selected' : "hidden" ?>>
															E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp
														</option>
														<option
															value="13" <?= (is_array($value7) && in_array("13", $value7)) ? 'selected' : 'hidden' ?>>
															E7.3: KH làm việc tại các công ty là đối tác chiến lược
														</option>
														<option
															value="14" <?= (is_array($value7) && in_array("14", $value7)) ? 'selected' : 'hidden' ?>>
															E7.4: Giá trị định giá tài sản cao
														</option>
													</select>
												</div>
											</div>


											<div class="form-input-text">
												<p>Thông tin quan hệ tín dụng</p>
											</div>
											<div class="form-table ">
												<div class="table-responsive">
													<table class="table">
														<thead>
														<tr>
															<th>Tên tổ chức vay</th>
															<th>Gốc còn lại</th>
															<th>Đã tất toán</th>
															<th>Tiền phải trả hàng kỳ</th>
															<th>Quá hạn</th>
														</tr>
														</thead>
														<tbody>
														<?php if (empty($company_storage)) : ?>
															<tr>
																<td></td>
															</tr>
														<?php else : ?>
															<?php foreach ($company_storage as $value) : ?>
																<tr>
																	<td><?= !empty($value->company_name != "khac") ? $value->company_name : $value->company_name_other ?></td>
																	<td><?= !empty($value->company_debt) ? $value->company_debt : "" ?></td>
																	<td><?= !empty($value->company_finalization) ? $value->company_finalization : "" ?></td>
																	<td><?= !empty($value->company_borrowing) ? $value->company_borrowing : "" ?></td>
																	<td><?= !empty($value->company_out_of_date) ? $value->company_out_of_date : "" ?></td>
																</tr>

															<?php endforeach; ?>
														<?php endif; ?>
														</tbody>
													</table>
												</div>
											</div>


										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="transactionOfficeInformation shared">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thông
													tin phòng giao
													dịch</h5>
											</div>
											<div class="form-input-text">
												<p>Phòng giao dịch</p>
												<select disabled class="form-control" id="stores">
													<option><?= !empty($contractInfor->store->name) ? $contractInfor->store->name : "" ?></option>
												</select>
											</div>
											<div class="form-input-text">
												<p>Người tạo</p>
												<input type="text"
													   value="<?= !empty($contractInfor->created_by) ? $contractInfor->created_by : "" ?>"
													   readonly>
											</div>
											<div class="form-input-text">
												<p>Người tiếp nhận quản lý hợp đồng</p>
												<input type="text"
													   value="<?= !empty($contractInfor->follow_contract) ? $contractInfor->follow_contract : "" ?>"
													   readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane">
									<div class="content">
										<div class="transactionOfficeInformation shared table_kttdk">
											<div class="form-text">
												<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Kỳ
													thanh toán (Dự kiến)</h5>
											</div>

											<div class="table-responsive ">
												<table class="table table-striped ">
													<thead>
													<tr>
														<th>#</th>
														<th>Kỳ trả</th>
														<th>Ngày kỳ trả</th>
														<th>Tổng số tiền<br> phải trả hàng kì</th>
														<th>Tổng lãi, phí</th>
														<th>Tiền lãi</th>
														<th>Phí thẩm định <br>và lưu trữ tài sản</th>
														<th>Phí tư vấn quản lý</th>
													</tr>
													</thead>
													<tbody name="list_lead">
													<?php
													if (!empty($calucatorData)) {
														echo $calucatorData;
														?>
													<?php } ?>
													</tbody>
												</table>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="license">
					<div class="license-top">
						<h2>Chứng từ</h2>
						<div class="clickbtn1">
							<img src="<?php echo base_url(); ?>assets/imgs/icon/clickbtn.png" alt="">
						</div>
						<div class="clickmenu1 btnst"><img src="<?php echo base_url(); ?>assets/imgs/icon/menu1.jpg" alt="">
							<div class="menuclicktab1">
								<div class="tabs1">
									<div class="tab-item1 active">
										Hồ sơ nhân thân
									</div>
									<div class="tab-item1">
										Hồ sơ chứng minh thu nhập
									</div>
									<div class="tab-item1">
										Hồ sơ tài sản
									</div>
									<div class="tab-item1">
										Hồ sơ thẩm định thực địa
									</div>
									<div class="tab-item1">
										Hồ sơ giải ngân
									</div>
									<div class="tab-item1">
										Thỏa thuận
									</div>
									<div class="tab-item1">
										Hồ sơ gia hạn
									</div>
									<div class="tab-item1">
										Thực nghiệm hiện trường
									</div>
									<div class="tab-item1">
										Ảnh gán định vị
									</div>
									<?php if (!empty($type_contract) && $type_contract == 1) : ?>
										<div class="tab-item1">
											Thỏa thuận hợp đồng điện tử
										</div>
									<?php endif; ?>
									<div class="line1"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="license-body" id="appendModal">
						<div>
							<!-- Tab content -->
							<div class="tab-content1">
								<div class="tab-pane1 active">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Hồ sơ
											nhân thân </h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_identify = 0;
											foreach ((array)$result->identify as $key => $value) {
												$key_identify++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3" target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
											<?php } ?>
											<!-- test slide------- -->

										</div>
									</div>

								</div>
								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Hồ sơ
											chứng
											minh thu nhập</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_household = 0;
											foreach ((array)$result->household as $key => $value) {
												$key_household++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Hồ sơ tài
											sản</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_driver_license = 0;
											foreach ((array)$result->driver_license as $key => $value) {
												$key_driver_license++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Hồ sơ
											thẩm định thực địa</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_vehicle = 0;
											foreach ((array)$result->vehicle as $key => $value) {
												$key_vehicle++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>


												<?php } ?>
												<!--Pdf-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'application/pdf')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
														<img class="img-thumbnail"
															 src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>


												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Hồ sơ
											giải ngân</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_expertise = 0;
											foreach ((array)$result->expertise as $key => $value) {
												$key_expertise++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>


												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>

								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thỏa
											thuận</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_agree = 0;
											foreach ((array)$result->agree as $key => $value) {
												$key_agree++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>


												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>

								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Hồ sơ gia
											hạn</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_extension = 0;
											foreach ((array)$result->extension as $key => $value) {
												$key_extension++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>


												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>


								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thực
											nghiệm hiện trường</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_experiment = 0;
											foreach ((array)$result->experiment as $key => $value) {
												$key_experiment++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3" target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>

												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>

								<div class="tab-pane1 ">
									<div class="form-text">
										<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Ảnh gán định vị</h5>
									</div>
									<div class="container-fluid">
										<div class="row mt-4 list-cro" id="">
											<?php
											$key_locate = 0;
											foreach ((array)$result->locate as $key => $value) {
												$key_locate++;
												if (empty($value)) continue; ?>
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
														<img class="img-thumbnail" src="<?= $value->path ?>">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>
												<?php } ?>
												<!--Video-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>

													<a href="<?= $value->path ?>"
													   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3" target="_blank">
														<img class="img-thumbnail"
															 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
														<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													</a>

												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>

								<?php if (!empty($type_contract) && $type_contract == 1) : ?>
									<div class="tab-pane1 ">
										<div class="form-text">
											<h5><img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="">Thỏa
												thuận hợp đồng điện tử</h5>
										</div>
										<div class="container-fluid">
											<div class="row mt-4 list-cro" id="">
												<?php
												$key_digital = 0;
												foreach ((array)$result->digital as $key => $value) {
													$key_digital++;
													if (empty($value)) continue; ?>
													<!--//Image-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
														<a href="<?= $value->path ?>"
														   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 magnifyitem">
															<img class="img-thumbnail" src="<?= $value->path ?>">
															<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														</a>
													<?php } ?>
													<!--Video-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>
														<a href="<?= $value->path ?>"
														   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3" target="_blank">
															<img class="img-thumbnail"
																 src="http://www.realestatemarketingblog.org/wp-content/uploads/2012/09/viral-real-estate-video.png">
															<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														</a>
													<?php } ?>
													<!--Pdf-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'application/pdf')) { ?>

														<a href="<?= $value->path ?>"
														   class="items12 col-ms-6 col-xs-4 col-md-4 mb-3 " target="_blank">
															<img class="img-thumbnail"
																 src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png">
															<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														</a>
													<?php } ?>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php endif; ?>

							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-xs-12 pt-xpannel">
				<div class="x_panel">
					<div class="x_title">
						<h2>Kỳ thanh toán (Dự kiến)</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="table-responsive ">
							<table class="table table-striped ">
								<thead>
								<tr>
									<th>#</th>
									<th>Kỳ trả</th>
									<th>Ngày kỳ trả</th>
									<th>Tổng số tiền<br> phải trả hàng kì</th>
									<th>Tổng lãi, phí</th>
									<th>Tiền lãi</th>
									<th>Phí thẩm định <br>và lưu trữ tài sản</th>
									<th>Phí tư vấn quản lý</th>


								</tr>
								</thead>
								<tbody name="list_lead">
								<?php

								if (!empty($calucatorData)) {
									echo $calucatorData;
									?>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 xp_botom">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#tab_content1" role="tab" id="tab001"
																  data-toggle="tab" aria-expanded="false">Hoạt động</a>
						</li>

						<li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab002" data-toggle="tab"
															aria-expanded="false">Gia hạn liên quan</a>
						</li>

						<li role="presentation" class=""><a href="#tab_content3" role="tab" id="tab003" data-toggle="tab"
															aria-expanded="false">Cơ cấu liên quan</a>
						</li>
						<li role="presentation" class=""><a href="#tab_content4" role="tab" id="tab004" data-toggle="tab"
															aria-expanded="false">Lịch sử quản lý hợp đồng</a>
						</li>

					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab001">
							<?php $this->load->view('page/pawn/tab_detail/tab_hoat_dong'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab002">
							<?php $this->load->view('page/pawn/tab_detail/tab_gia_han'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="tab003">
							<?php $this->load->view('page/pawn/tab_detail/tab_co_cau'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="tab004">
							<?php $this->load->view('page/pawn/tab_detail/tab_lich_su_qlhd'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>




	</div>

</div>


<!-- Modal -->
<div id="contract_involve" class="modal fade" role="dialog">
	<div class="modal-dialog " id="diloglg1">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Hợp đồng liên quan</h4>
			</div>
			<div class="modal-body table-responsive">

				<table class="table table-bordered">
					<thead>
					<tr>
						<th>Mã Hợp Đồng</th>
						<th>Mã Phiếu ghi</th>
						<th>Số Tiền Vay</th>
						<th>Thời Hạn</th>
						<th>Phòng Giao Dịch</th>
						<th>Trạng Thái</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if (!empty($contract_involve_phone)) {
						?>
						<tr>
							<th colspan="5">
								Số điện
								thoại: <?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number) : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_phone as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_identify)) {
						?>
						<tr>
							<th colspan="5">
								Số
								CMND: <?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_identify as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_identify_old)) {
						?>
						<tr>
							<th colspan="5">
								Số
								CCCD: <?= $contractInfor->customer_infor->customer_identify_old ? $contractInfor->customer_infor->customer_identify_old : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_identify_old as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_relative_1)) {
						?>
						<tr>
							<th colspan="5">
								Số tham chiếu
								1: <?= $contractInfor->relative_infor->phone_number_relative_1 ? hide_phone($contractInfor->relative_infor->phone_number_relative_1) : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_relative_1 as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>
					<?php
					if (!empty($contract_involve_relative_2)) {
						?>
						<tr>
							<th colspan="5">
								Số tham chiếu
								2: <?= $contractInfor->relative_infor->phone_number_relative_2 ? hide_phone($contractInfor->relative_infor->phone_number_relative_2) : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_relative_2 as $key => $value) {
							$status = contract_status($value->status);

							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>


					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="ContractHistoryModal" tabindex="-1" role="dialog" aria-labelledby="ContractHistoryModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
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
							<th><?php echo $this->lang->line('action') ?></th>
							<th><?php echo $this->lang->line('time') ?></th>
							<th><?php echo $this->lang->line('change_by') ?></th>
							<th><?php echo $this->lang->line('status') ?></th>
							<th><?php echo $this->lang->line('note') ?></th>
						</tr>
						</thead>
						<tbody>
						<?php
						if (!empty($logs)) {
							foreach ($logs as $key => $log) {
								?>
								<tr>
									<td><?php echo $key + 1 ?></td>
									<td><?php echo !empty($log->action) ? $log->action : '' ?></td>
									<td><?php echo !empty($log->created_at) ? date('d/m/Y H:i:s', intval($log->created_at) + 7 * 60 * 60) : "" ?></td>
									<td><?php echo !empty($log->created_by) ? ($log->created_by) : '' ?></td>
									<td><?php
										$status = '';
										$id_status = '';
										if (!empty($log->new->status)) {
											$id_status = $log->new->status;
										} elseif (!empty($log->old->status)) {
											$id_status = $log->old->status;
										}
										if (!empty($id_status)) {
											echo contract_status($id_status);
										}
										?>
									</td>
									<td><?php echo !empty($log->new->note) ? $log->new->note : '' ?></td>
								</tr>
							<?php }
						}

						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" id="approve1">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve"></h5>
				<hr>
				<div class="form-group code_contract_approve" style="display:none">
					<label>Mã hợp đồng:</label>
					<input type="text" class="form-control " name="code_contract_disbursement_approve" value="">
				</div>
				<div class="form-group so_tien_vay_asm_de_xuat" style="display: none">
					<label>Số tiền vay: <span class="text-danger">*</span></label>
					<input type="text" id="so_tien_vay_asm_de_xuat" placeholder="Số tiền được vay ASM đề xuất"
						   class="form-control" name="so_tien_vay_asm_de_xuat">
				</div>
				<div class="form-group ki_han_vay_asm_de_xuat" style="display: none">
					<label>Kì hạn vay: <span class="text-danger">*</span></label>
					<input type="number" id="ki_han_vay_asm_de_xuat" placeholder="Kì hạn vay ASM đề xuất"
						   class="form-control" name="ki_han_vay_asm_de_xuat">
				</div>

				<?php if (in_array('ke-toan', $groupRoles)) : ?>
					<div class="form-group error_code_contract_kt" style="display:none">
						<label>Mã lỗi kế toán:</label>
						<select class="form-control " name="error_code[]" style="width: 75%" id="error_code"
								multiple="multiple" data-placeholder="Choose option">
							<?php foreach (return_kt() as $key => $value) { ?>
								<option value="<?= $value ?>"><?= $key ?></option>
							<?php } ?>
						</select>
					</div>
				<?php else : ?>
					<div class="form-group error_code_contract" style="display:none">
						<label>Trường hợp vi phạm:</label>
						<select class="form-control " name="error_code[]" style="width: 75%" id="error_code"
								multiple="multiple" data-placeholder="Choose option">
							<?php foreach (lead_return() as $key => $value) { ?>
								<option value="<?= $key ?>"><?= $key . ' - ' . $value ?></option>
							<?php } ?>
						</select>
					</div>
				<?php endif; ?>

				<input id="error_code1" style="display: none">


				<div class="form-group img_return_file">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ảnh hồ sơ bổ sung/trả
						về<span class="red"></span></label>
					<div class="col-md-9 col-sm-6 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_img_file">

							</div>
							<label for="uploadinput">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput" type="file" name="file" data-contain="uploads_img_file"
								   data-title="Hồ sơ trả về" multiple data-type="img_file" class="focus">
						</div>
					</div>
				</div>

				<div class="form-group">

					<label class="cancel-B" style="display: none">Lý do từ chối,hủy:</label>
					<div class="row cancel-B" style="display: none">
						<div class="col-md-6">
							<select class="form-control" id="change_cancel" data-placeholder="Các lý do từ chối, hủy">
								<option value="">-- Các lý do từ chối, hủy --</option>
								<option value="C1">C1: Lý do về hồ sơ nhân thân</option>
								<option value="C2">C2: Lý do về thông tin nơi ở</option>
								<option value="C3">C3: Lý do về thông tin thu nhập</option>
								<option value="C4">C4: Lý do về thông tin tài sản</option>
								<option value="C5">C5: Lý do về thông tin tham chiếu</option>
								<option value="C6">C6: Lý do về thông tin lịch sử tín dụng</option>
								<option value="C7">C7: Lý do khác</option>
							</select>
						</div>
						<div class="col-md-6">
							<div style="display: none" id="cancel1">
								<select id="lead_cancel_C1" class="form-control" name="lead_cancel_C1[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C1">
									<?php foreach (lead_cancel_C1() as $key => $item) { ?>
										<option
											value="<?= $key ?>" <?= ($lead_cancel_C1 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel2">
								<select id="lead_cancel_C2" class="form-control" name="lead_cancel_C2[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C2">
									<?php foreach (lead_cancel_C2() as $key => $item) { ?>
										<option
											value="<?= $key ?>" <?= ($lead_cancel_C2 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel3">
								<select id="lead_cancel_C3" class="form-control" name="lead_cancel_C3[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C3">
									<?php foreach (lead_cancel_C3() as $key => $item) { ?>
										<option
											value="<?= $key ?>" <?= ($lead_cancel_C3 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel4">
								<select id="lead_cancel_C4" class="form-control" name="lead_cancel_C4[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C4">
									<?php foreach (lead_cancel_C4() as $key => $item) { ?>
										<option
											value="<?= $key ?>" <?= ($lead_cancel_C4 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel5">
								<select id="lead_cancel_C5" class="form-control" name="lead_cancel_C5[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C5">
									<?php foreach (lead_cancel_C5() as $key => $item) { ?>
										<option
											value="<?= $key ?>" <?= ($lead_cancel_C5 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel6">
								<select id="lead_cancel_C6" class="form-control" name="lead_cancel_C6[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C6">
									<?php foreach (lead_cancel_C6() as $key => $item) { ?>
										<option
											value="<?= $key ?>" <?= ($lead_cancel_C6 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel7">
								<select id="lead_cancel_C7" class="form-control" name="lead_cancel_C7[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C7">
									<?php foreach (lead_cancel_C7() as $key => $item) { ?>
										<option
											value="<?= $key ?>" <?= ($lead_cancel_C7 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<input id="lead_cancel1_C1" style="display: none">
					<input id="lead_cancel1_C2" style="display: none">
					<input id="lead_cancel1_C3" style="display: none">
					<input id="lead_cancel1_C4" style="display: none">
					<input id="lead_cancel1_C5" style="display: none">
					<input id="lead_cancel1_C6" style="display: none">
					<input id="lead_cancel1_C7" style="display: none">
					<input id="exception1_value_detail" style="display: none">
					<input id="exception2_value_detail" style="display: none">
					<input id="exception3_value_detail" style="display: none">
					<input id="exception4_value_detail" style="display: none">
					<input id="exception5_value_detail" style="display: none">
					<input id="exception6_value_detail" style="display: none">
					<input id="exception7_value_detail" style="display: none">
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve">
					<input type="hidden" class="form-control code_contract_disbursement_type" value="0">

					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger approve_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<!--Modal Tool sửa mã hợp đồng (code_contract_disbursement đồng bộ mã HĐ bảng temporary_plan_contract-->
<div class="modal fade" id="edit_code_contract_disbursement" tabindex="-1" role="dialog" aria-labelledby="edit_code_contract_disbursement"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Sửa mã hợp đồng với mã phiếu ghi: <?= $contractInfor->code_contract ? $contractInfor->code_contract : ''?></h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<label class="control-label col-md-3 col-xs-12">Mã hợp đồng cũ</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="old_code_contract_disbursement"
									   value="<?= $contractInfor->code_contract_disbursement ? $contractInfor->code_contract_disbursement : ''?>"
									   disabled>
								<input type="hidden"
									   id="code_contract_d_edit"
									   class="form-control"
									   name="code_contract_d_edit"
									   value="<?= $contractInfor->code_contract ? $contractInfor->code_contract : ''?>"
									   disabled>
								<input type="hidden"
									   id="contract_id_d_edit"
									   class="form-control"
									   name="contract_id_d_edit"
									   value="<?= $contractInfor->_id->{'$oid'} ? $contractInfor->_id->{'$oid'} : ''?>"
									   disabled>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-3 col-xs-12">Mã hợp đồng mới
								<span class="text-danger">*</span>
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<input type="text"
									   class="form-control new_code_contract_disbursement"
									   name="new_code_contract_disbursement"
									   id="new_code_contract_disbursement">
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-3 col-xs-12"><span></span>
								Ghi chú:</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_edit_code_contract_disbursement" name="note_edit_code_contract_disbursement"
										  rows="3"></textarea>
								<input type="hidden" class="form-control contract_id">
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-8 col-xs-12"></div>
					<div class="col-md-4 col-xs-12">
						<button type="button" class="btn btn-danger close-hs" data-dismiss="modal"
								aria-label="Close">Đóng</button>
						<button type="button" class="btn btn-info " id="confirm_edit">Xác nhận</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
	function showModal() {
		$('#ContractHistoryModal').modal('show');
	}
	function showModalEditCodeContractDisbursement() {
		$('#edit_code_contract_disbursement').modal('show');
	}
</script>
<script>
	$(function () {
		$(function () {
			$('.btn-contents').click(function () {
				$('.btn-icon1').slideToggle();
			});
			$('.clickmenu').click(function () {
				$('.menuclicktab').slideToggle();
			});
			$('.clickmenu1').click(function () {
				$('.menuclicktab1').slideToggle();
			});

		});
		$('.clickbtn').click(function () {
			$('.license').hide();
			$('.clickbtn1').show();
			$('.clickbtn').hide();
			$(".shared").css("padding-bottom", "30px");
		});
		$('.clickbtn1').click(function () {
			$('.license').show();
			$('.clickbtn').show();
			$('.clickbtn1').hide();
			$(".shared").css("padding-bottom", "300px");
		});
		$(".shared").css("padding-bottom", "300px");
		$(".clickbtn2").click(function () {
			$(".license").toggle();
			$(".profileDetails").css({"width": "100%"});
			$(".clickbtn2").hide();
			$(".clickbtn3").show();
		});
		$(".clickbtn3").click(function () {
			$(".license").toggle();
			$(".profileDetails").css({"width": "48%"});
			$(".clickbtn2").show();
			$(".clickbtn3").hide();
		});

	});
</script>


<script>
	//adding custom item to fancybox menu to rotate image
	$(document).on('onInit.fb', function (e, instance) {
		if ($('.fancybox-toolbar').find('#rotate_button').length === 0) {
			$('.fancybox-toolbar').prepend('<button id="rotate_button" class="fancybox-button" title="Rotate Image"><i class="fa fa-repeat"></i></button>');
		}
		var click = 1;
		$('.fancybox__button--close').on('click', '#rotate_button', function () {
			var n = 90 * ++click;
			$('.fancybox-image-wrap img').css('webkitTransform', 'rotate(-' + n + 'deg)');
			$('.fancybox-image-wrap img').css('mozTransform', 'rotate(-' + n + 'deg)');
		});
	});
</script>


<script>
	const $a = document.querySelector.bind(document);
	const $$b = document.querySelectorAll.bind(document);

	const tabs = $$b(".tab-item");
	const panes = $$b(".tab-pane");

	const tabActive = $a(".tab-item.active");
	const line = $a(".tabs .line");

	tabs.forEach((tab, index) => {
		const pane = panes[index];

		tab.onclick = function () {
			$a(".tab-item.active").classList.remove("active");
			$a(".tab-pane.active").classList.remove("active");

			line.style.left = this.offsetLeft + "px";
			line.style.width = this.offsetWidth + "px";

			this.classList.add("active");
			pane.classList.add("active");
		};
	});
</script>
<script>
	const $$$ = document.querySelector.bind(document);
	const $$$$$$ = document.querySelectorAll.bind(document);

	const tabs1 = $$$$$$(".tab-item1");
	const panes1 = $$$$$$(".tab-pane1");

	const tabActive1 = $$$(".tab-item1.active");
	const line1 = $$$(".tabs1 .line1");

	tabs1.forEach((tab1, index) => {
		const pane1 = panes1[index];

		tab1.onclick = function () {
			$$$(".tab-item1.active").classList.remove("active");
			$$$(".tab-pane1.active").classList.remove("active");

			line1.style.left = this.offsetLeft + "px";
			line1.style.width = this.offsetWidth + "px";

			this.classList.add("active");
			pane1.classList.add("active");
		};
	});
</script>

<?php $this->load->view('page/pawn/modal_contract', isset($this->data) ? $this->data : NULL); ?>
<script src="<?php echo base_url(); ?>assets/js/pawn/contract.js?rev=<?php echo time(); ?>"></script>
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>

<style>
	.img-thumbnail {
		width: 300px;
		height: auto;
		margin-right: 2em;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.12),
		0 2px 2px rgba(0, 0, 0, 0.12),
		0 4px 4px rgba(0, 0, 0, 0.12),
		0 8px 8px rgba(0, 0, 0, 0.12),
		0 16px 16px rgba(0, 0, 0, 0.12);
	}

	.items12 {
		width: 30%;
		height: 200px;
		margin-bottom: 1%;
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 5%;
	}

	.items12 img {
		width: 100%;
		height: 85%;
		object-fit: cover;
		padding-bottom: 5px;

	}
</style>

<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>
<script>
	$('#error_code').change(function () {

		let error_code = JSON.parse($('#error_code1').val());

		let text = "";

		for (let i = 0; i < error_code[0].length; i++){
			text += error_code[0][i] + '. ';
		}

		$("textarea.approve_note").val(text);

	});
</script>
