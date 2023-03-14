<div class="x_panel" xmlns="http://www.w3.org/1999/html">

	<div class="x_content">

		<div class="form-group row">
			<div class="col-xs-12">
				<div class="x_title">
					<strong><i class="fa fa-user" aria-hidden="true"></i> So khớp CMTND và chân dung</strong>
					<div class="clearfix"></div>
				</div>
				<div class="form-group">
					<p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu</p>
					<div class="row">
						<div class="col-xs-12 col-md-4 text-left">
							<div>
								<img id="imgImg_mattruoc" class="w-100" style="max-width: 350px; max-height: 250px;"
									 src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png"
									 alt="">
								<p>Mặt trước CMT</p>
								<input type="file" id="input_cmt_search" data-preview="imgInp001"
									   style="visibility: hidden;">
							</div>
						</div>
						<div class="col-xs-12 col-md-4 text-left">
							<img id="imgImg_matsau" class="w-100" style="max-width: 350px; max-height: 250px;"
								 src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png"
								 alt="">
							<p>Mặt sau CMT</p>
							<input type='file' id="imgInp_Face" data-preview="imgInp002" style="visibility: hidden;">
						</div>
						<div class="col-xs-12 col-md-4 text-left">
							<img id="imgImg_chandung" class="w-100" style="max-width: 350px; max-height: 250px;"
								 src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png"
								 alt="">
							<p>Ảnh chân dung</p>
							<input type='file' id="imgInp_Identify" data-preview="imgInp002"
								   style="visibility: hidden;"/>
						</div>
					</div>

					<div class="col-xs-12 text-right">
						<button type="button" class="btn btn-github return_Face_Identify">Chọn lại</button>
						<button type="button" class="btn btn-danger identification_Face_search">Blacklist</button>
						<button class="btn btn-info identification_Face_Identify">
							<i class="fa fa-address-book-o"></i>
							<span class="hidden-xs hidden-sm">
								Nhận dạng khách hàng
							</span>
							<span class="hidden-md hidden-lg">
								Nhận dạng
							</span>
						</button>
					</div>


					<div class="clearfix"></div>
					<p></p>
					<div class="row">
						<div class="col-md-12 text-center">

						</div>
					</div>

					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 alert alert-success alert-dismissible text-center">
						</div>
					</div>

					<div class="row">
						<h1 class="text-center text-primary face_identify_results"></h1>
					</div>
					<table class="table table-bordered" style="white-space: normal">
						<tbody id='list_info_Face_search'>

						</tbody>
					</table>

					<div id="cvs_customer_info" class="row" style="display: none;">
						<div class="col-md-12">
							<h4>Thông tin khách hàng</h4>
							<div class="text-center" id="Identify_loading" style="display: none;">
								<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
								<div>Đang xử lý...</div>
							</div>
							<table class="table table-bordered">
								<tbody id='list_info_Identify'>

								</tbody>
							</table>
							<div class="col-md-12 text-center">
								<button type="button" class="btn btn-primary apply_info_Identify">Áp dụng</button>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>

	</div>

</div>

<div class="x_panel" id="show_ttnd" style="display: none">

	<div class="x_content">

		<div class="row">

			<!--			<div class="col-xs-12">-->
			<!--				<h4 class="text-danger text-uppercase">-->
			<!--					Thông tin khách hàng:-->
			<!--					<hr>-->
			<!--				</h4>-->
			<!--				<table class="table table-bordered table-fixed">-->
			<!--					<tbody>-->
			<!---->
			<!--					<tr>-->
			<!--						<th>Họ và tên:</th>-->
			<!--						<td colspan="3">-->
			<!--							<input type="text" value=""-->
			<!--								   style="width:100%;border:0" placeholder="...">-->
			<!--						</td>-->
			<!--					</tr>-->
			<!---->
			<!---->
			<!--					<tr>-->
			<!--						<th>CMT/CCCD/HC:</th>-->
			<!--						<td colspan="3">-->
			<!--							<input type="text" value=""-->
			<!--								   style="width:100%;border:0" placeholder="...">-->
			<!--						</td>-->
			<!--					</tr>-->
			<!---->
			<!--					<tr>-->
			<!--						<th>Ngày sinh:</th>-->
			<!--						<td colspan="3">-->
			<!--							<input type="date" value=""-->
			<!--								   style="width:100%;border:0" placeholder="...">-->
			<!--						</td>-->
			<!--					</tr>-->
			<!---->
			<!--					<tr>-->
			<!--						<th>Quê quán:</th>-->
			<!--						<td colspan="3">-->
			<!--							<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
			<!--						</td>-->
			<!--					</tr>-->
			<!--					</tbody>-->
			<!--				</table>-->
			<!--			</div>-->


			<div class="col-xs-12">
				<h4 class="text-danger text-uppercase">
					Thông tin nhận dạng:
					<hr>
				</h4>
			</div>
			<input type="text" hidden id="idLead_Identify" value="<?php echo $id_lead ?>">
			<input type="text" hidden id="idContract_Identify" value="<?php echo $id_contract ?>">
			<input type="hidden" hidden id="isBlacklist" value="2">
			<div class="col-xs-12">
				<p>
					<strong>Loại khách hàng:</strong>
					&nbsp;
					<label class="radio-inline pt-0"><input type="radio" name="status_customer" value="1" checked>Khách
						hàng mới</label>
					<label class="radio-inline pt-0"><input type="radio" name="status_customer" value="2">Khách hàng cũ</label>

					&nbsp;

				</p>
				<div class="hidden-xs hidden-sm">
				<table class="table table-bordered">
					<thead>
					<tr>
						<!--						<th scope="col">Mã KH</th>-->
						<th scope="col" style="text-align: center">Tên KH <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Email <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Giới tính <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Ngày sinh <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">CMT/CCCD <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Ngày cấp <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Nơi cấp <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">SĐT <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Nguồn KH <span class="text-danger">*</span></th>
						<th scope="col" style="display: none; text-align: center" class="list_ctv_hide">Cộng tác viên <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Tình trạng hôn nhân <span class="text-danger">*</span></th>
					</tr>
					</thead>
					<tbody>
					<tr>

						<!--						<td>-->
						<!--							<input type="text" value=""-->
						<!--								   style="width:100%;border:0" placeholder="...">-->
						<!--						</td>-->
						<td class="error_messages">
							<input type="text" name="customer_name" id="customer_name"
								   value="<?= !empty($lead_info->fullname) ? $lead_info->fullname : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="email" name="customer_email" id="customer_email"
								   value="<?= !empty($lead_info->email) ? $lead_info->email : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<div class="radio-inline text-primary">
								<label><input name='customer_gender' id="has_gender" value="1" checked type="radio">&nbsp;<?= $this->lang->line('male') ?>
								</label>
							</div>
							<div class="radio-inline text-danger">
								<label><input name='customer_gender' id="no_gender" value="2"
											  type="radio">&nbsp;<?= $this->lang->line('Female') ?></label>
							</div>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="date" name="customer_BOD" id="customer_BOD" value=""
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="customer_identify" id="customer_identify"
								   value="<?= !empty($lead_info->identify_lead) ? $lead_info->identify_lead : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="date" name="date_range" id="date_range"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="issued_by" id="issued_by"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<?php
							$id_lead_get = (isset($_GET['id_lead'])) ? $_GET['id_lead'] : '';
							if (isset($lead_info->phone_number)) { ?>
								<input style="width:100%;border:0" placeholder="" type="text"
									   name="customer_phone_number"
									   value="<?= !empty($lead_info->phone_number) ? hide_phone($lead_info->phone_number) : "" ?>">
								<input type="hidden" id="customer_phone_number"
									   value="<?= !empty($lead_info->phone_number) ? encrypt($lead_info->phone_number) : "" ?>">
								<input type="hidden" id="id_lead"
									   value="<?= !empty($lead_info->_id->{'$oid'}) ? $lead_info->_id->{'$oid'} : $id_lead_get ?>">
							<?php } else { ?>
								<input type="hidden" id="id_lead" class="form-control" value="">
								<input type="text" name="customer_phone_number" id="customer_phone_number" value=""
									   style="width:100%;border:0" placeholder="">
							<?php } ?>
							<p class="messages"></p>
						</td>


						<?php if (!empty($lead_info->source)) {
							$check_source = $lead_info->source;
						} else {
							$check_source = 0;
						}
						?>
						<td class="error_messages">
							<select style="width:100%;border:0" class="form-control"
									id="customer_resources" <?= (!empty($check_source) && $check_source != 0) ? "disabled" : "" ?>>
								<option value="1" <?= ($check_source == "1") ? "selected" : "" ?> >Digital</option>
								<option value="2" <?= ($check_source == "2") ? "selected" : "" ?> >TLS Tự kiếm</option>
								<option value="3" <?= ($check_source == "3") ? "selected" : "" ?> >Tổng đài</option>
								<option value="4" <?= ($check_source == "4") ? "selected" : "" ?> >Giới thiệu</option>
								<option value="5" <?= ($check_source == "5") ? "selected" : "" ?> >Đối tác</option>
								<option value="6" <?= ($check_source == "6") ? "selected" : "" ?> >Fanpage</option>
								<option value="7" <?= ($check_source == "7") ? "selected" : "" ?> >Nguồn khác</option>
								<option value="12" <?= ($check_source == "12") ? "selected" : "" ?> >Nguồn App Mobile
								</option>
								<option value="8" <?= ($check_source == "8") ? "selected" : "" ?> >KH vãng lai</option>
								<option value="9" <?= ($check_source == "9") ? "selected" : "" ?> >KH tự kiếm</option>
								<option value="10" <?= $check_source == "10" ? "selected" : "" ?> >Cộng tác viên
								</option>
								<option value="11" <?= ($check_source == "11") ? "selected" : "" ?> >KH giới thiệu KH
								</option>
								<option value="VM" <?= ($check_source == "VM") ? "selected" : "" ?> >Nguồn vay mượn
								</option>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages list_ctv_hide" style="display: none">
							<select class="form-control" name="list_ctv" id="list_ctv" style="width:100%;border:0">
								<option value="">-- Chọn cộng tác viên --</option>
								<?php !empty($list_ctv) ? $list_ctv : ''; ?>
								<?php foreach ($list_ctv as $key => $value): ?>
									<option value="<?php echo $value->ctv_code ?>"><?php echo $value->ctv_code . " - " . $value->ctv_name ?></option>
								<?php endforeach; ?>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select style="width:100%;border:0" class="form-control" id="marriage">
								<option value="1">Đã kết hôn</option>
								<option value="2">Chưa kết hôn</option>
								<option value="3">Ly hôn</option>
							</select>
							<p class="messages"></p>
						</td>

					</tr>

					</tbody>
				</table>
				</div>

				<!--Mobile-->
				<div class="hidden-md hidden-lg">
					<table class="table table-bordered table-fixed">
						<tbody>
							<tr>
								<th>Tên KH <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Email <span class="text-danger">*</span> </th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Giới tính <span class="text-danger">*</span> </th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Ngày sinh <span class="text-danger">*</span> </th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>CMT/CCCD <span class="text-danger">*</span> </th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Ngày cấp <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Nơi cấp <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>SĐT <span class="text-danger">*</span> </th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Nguồn KH <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Tình trạng hôn nhân <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
					</tbody>
					</table>
				</div>
			</div>


			<div class="col-xs-12">
				<p>
					<strong>Thông tin nơi ở:</strong>
				</p>
				<div class="hidden-xs hidden-sm">
					<table class="table table-bordered table-fixed">
						<thead>
						<tr>
							<th scope="col"></th>
							<th scope="col" style="text-align: center">Tỉnh/Thành phố <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Quận/Huyện <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Phường/Xã <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Thôn/Xóm/Tổ <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Hình thức cư trú <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Thời gian sinh sống <span class="text-danger">*</span></th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<th>Địa chỉ đang ở:</th>
							<td class="error_messages">
								<select class="form-control" name="selectize_province_current_address"
										id="selectize_province_current_address" style="width:100%;border:0">
									<option value=""><?= $this->lang->line('Province_City2') ?></option>
									<?php
									if (!empty($provinceData)) {
										$ns_province = !empty($lead_info->ns_province) ? $lead_info->ns_province : '';
										foreach ($provinceData as $key => $province) {
											?>
											<option <?= $ns_province == $province->code ? "selected" : "" ?>
													value="<?= !empty($province->code) ? $province->code : ""; ?>"><?= !empty($province->name) ? $province->name : ""; ?></option>
										<?php }
									} ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" name="selectize_district_current_address"
										id="selectize_district_current_address" style="width:100%;border:0">
									<option value=""><?= $this->lang->line('District1') ?></option>
									<?php
									if (!empty($districtData_ns)) {
										$ns_district = !empty($lead_info->ns_district) ? $lead_info->ns_district : '';
										foreach ($districtData_ns as $key => $district) {
											?>
											<option <?= $ns_district == $district->code ? "selected" : "" ?>
													value="<?= !empty($district->code) ? $district->code : ""; ?>"><?= !empty($district->name) ? $district->name : ""; ?></option>
										<?php }
									} ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="selectize_ward_current_address" name="selectize_ward_current_address">
									<option value=""> <?= $this->lang->line('Wards1') ?></option>
									<?php
									if (!empty($wardData_ns)) {
										$ns_ward = !empty($lead_info->ns_ward) ? $lead_info->ns_ward : '';
										foreach ($wardData_ns as $key => $ward) {
											?>
											<option <?= $ns_ward == $ward->code ? "selected" : "" ?>
													value="<?= !empty($ward->code) ? $ward->code : ""; ?>"><?= !empty($ward->name) ? $ward->name : ""; ?></option>
										<?php }
									} ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="current_stay_current_address" id="current_stay_current_address"
									   value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="form_residence_current_address"
										style="width:100%;border:0">
									<option value="Tạm trú"> Tạm trú</option>
									<option value="Thường trú"> Thường trú</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="time_life_current_address" id="time_life_current_address" value=""
									   style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>

						</tr>
						<tr>
							<th>Địa chỉ hộ khẩu:</th>
							<td class="error_messages">
								<select class="form-control" id="selectize_province_household" name="selectize_province_household">
									<option value=""><?= $this->lang->line('Province_City2') ?></option>
									<?php
									if (!empty($provinceData)) {
										$hk_province = !empty($lead_info->hk_province) ? $lead_info->hk_province : '';
										foreach ($provinceData as $key => $province) {
											?>
											<option <?= $hk_province == $province->code ? "selected" : "" ?>
													value="<?= !empty($province->code) ? $province->code : ""; ?>"><?= !empty($province->name) ? $province->name : ""; ?></option>
										<?php }
									} ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="selectize_district_household" name="selectize_district_household">
									<option value=""><?= $this->lang->line('District1') ?></option>
									<?php
									if (!empty($districtData_hk)) {
										$hk_district = !empty($lead_info->hk_district) ? $lead_info->hk_district : '';
										foreach ($districtData_hk as $key => $district) {
											?>
											<option <?= $hk_district == $district->code ? "selected" : "" ?>
													value="<?= !empty($district->code) ? $district->code : ""; ?>"><?= !empty($district->name) ? $district->name : ""; ?></option>
										<?php }
									} ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="selectize_ward_household" name="selectize_ward_household">
									<option value=""><?= $this->lang->line('Wards1') ?></option>
									<?php
									if (!empty($wardData_hk)) {
										$hk_ward = !empty($lead_info->hk_ward) ? $lead_info->hk_ward : '';
										foreach ($wardData_hk as $key => $ward) {
											?>
											<option <?= $hk_ward == $ward->code ? "selected" : "" ?>
													value="<?= !empty($ward->code) ? $ward->code : ""; ?>"><?= !empty($ward->name) ? $ward->name : ""; ?></option>
										<?php }
									} ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="address_household" id="address_household" value=""
									   style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
						</tr>


						</tbody>
					</table>
				</div>

				<div class="hidden-md hidden-lg">
					<table class="table table-bordered table-fixed">
						<thead>
							<tr>
								<th colspan="2">Địa chỉ đang ở:</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>Tỉnh/Thành phố <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Quận/Huyện <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Phường/Xã <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Thôn/Xóm/Tổ  <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Hình thức cư trú <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>
							<tr>
								<th>Thời gian sinh sống  <span class="text-danger">*</span></th>
								<td> Thuoc tinh </td>
							</tr>

						</tbody>
					</table>

					<table class="table table-bordered table-fixed">
						<thead>
						<tr>
							<th colspan="2">Địa chỉ hộ khẩu:</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<th>Tỉnh/Thành phố <span class="text-danger">*</span></th>
							<td> Thuoc tinh </td>
						</tr>
						<tr>
							<th>Quận/Huyện <span class="text-danger">*</span></th>
							<td> Thuoc tinh </td>
						</tr>
						<tr>
							<th>Phường/Xã <span class="text-danger">*</span></th>
							<td> Thuoc tinh </td>
						</tr>
						<tr>
							<th>Thôn/Xóm/Tổ  <span class="text-danger">*</span></th>
							<td> Thuoc tinh </td>
						</tr>
						<tr>
							<th>Hình thức cư trú <span class="text-danger">*</span></th>
							<td> Thuoc tinh </td>
						</tr>
						<tr>
							<th>Thời gian sinh sống  <span class="text-danger">*</span></th>
							<td> Thuoc tinh </td>
						</tr>

						</tbody>
					</table>
				</div>
			</div>

			<div class="col-xs-12">
				<hr>
				<button id="nextBtnCreate_1" class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
			</div>
		</div>


	</div>

</div>

<style>
	.help-block {
		display: inline-block !important;
		margin: 0px !important;
	}

	.has-error {
		border-color: #a94442 !important;
	}

	.has-success {
		border-color: #26B99A !important;
	}
</style>
<script>
	$('#customer_resources').change(function (event) {
		event.preventDefault();
		console.log("xxx")
		var check_ctv_resources = $('#customer_resources').val();
		if (check_ctv_resources == 10) {
			$('.list_ctv_hide').show();
		}
		if (check_ctv_resources != 10) {
			$('.list_ctv_hide').hide();
			$('#list_ctv').val("");
		}

	});

	var check_ctv_resources_update = $('#customer_resources').val();
	if (check_ctv_resources_update == 10) {
		$('.list_ctv_hide').show();
	}

	$("#customer_phone_number").change(function () {
		var phone_number_source = $("#customer_phone_number").val();

		var formData = new FormData();
		formData.append('phone_number_source', phone_number_source);

		$.ajax({
			url: _url.base_url + 'lead_custom/check_phone_source',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			// beforeSend: function(){$(".theloading").show();},
			success: function (data) {
				$(".theloading").hide();
				if (data.status == 200) {
					if (typeof data.check_phone.data.source != "undefined") {
						$("#customer_resources").val(data.check_phone.data.source);
						$("#customer_resources").prop('disabled', true);
						if (data.check_phone.data.source == 10) {
							$('.list_ctv_hide').show();
						}

					}
					if (typeof data.check_phone.data.source_pgd != "undefined") {
						$("#customer_resources").val(data.check_phone.data.source_pgd);
						$("#customer_resources").prop('disabled', true);
						$('.list_ctv_hide').hide();

					}
				} else {
					$("#customer_resources").val(1);
					$("#customer_resources").prop('disabled', false);
					$('.list_ctv_hide').hide();
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	});
</script>
