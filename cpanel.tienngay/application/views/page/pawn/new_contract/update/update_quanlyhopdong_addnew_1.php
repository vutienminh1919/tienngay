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
								<img id="imgImg_mattruoc" class="w-100" style="max-width: 350px; max-height: 250px;" src="<?= $contractInfor->customer_infor->img_id_front ? $contractInfor->customer_infor->img_id_front : "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" ?>" alt="">
								<p>Mặt trước CMT</p>
								<input value="<?= $contractInfor->customer_infor->img_id_back ? $contractInfor->customer_infor->img_id_back : "" ?>" type="file" id="input_cmt_search" data-preview="imgInp001" style="visibility: hidden;">
							</div>
						</div>
						<div class="col-xs-12 col-md-4 text-left">
							<img id="imgImg_matsau" class="w-100" style="max-width: 350px; max-height: 250px;" src="<?= $contractInfor->customer_infor->img_id_back ? $contractInfor->customer_infor->img_id_back : "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" ?>" alt="">
							<p>Mặt sau CMT</p>
							<input value="<?= $contractInfor->customer_infor->img_id_back ? $contractInfor->customer_infor->img_id_back : "" ?>" type='file' id="imgInp_Face" data-preview="imgInp002" style="visibility: hidden;">
						</div>
						<div class="col-xs-12 col-md-4 text-left">
							<img id="imgImg_chandung" class="w-100" style="max-width: 350px; max-height: 250px;" src="<?= $contractInfor->customer_infor->img_portrait ? $contractInfor->customer_infor->img_portrait : "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" ?>" alt="">
							<p>Ảnh chân dung</p>
							<input value="<?= $contractInfor->customer_infor->img_portrait ? $contractInfor->customer_infor->img_portrait : "" ?>" type='file' id="imgInp_Identify" data-preview="imgInp002" style="visibility: hidden;"  />
						</div>
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
						<h1 class="text-center text-primary face_identify_results" ></h1>
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
								<div >Đang xử lý...</div>
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
		</div>

	</div>

</div>

<div class="x_panel">

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
			<input type="hidden" hidden id="isBlacklist" value="<?= (!empty($contractInfor->customer_infor->is_blacklist)) ? $contractInfor->customer_infor->is_blacklist : "" ?>">
			<div class="col-xs-12">
				<p>
					<strong>Loại khách hàng:</strong>
					&nbsp;
					<label class="radio-inline pt-0"><input type="radio" name="status_customer" value="1" <?= !empty($contractInfor->customer_infor->status_customer) && $contractInfor->customer_infor->status_customer == 1 ? "checked" : "" ?>>Khách hàng mới</label>
					<label class="radio-inline pt-0"><input type="radio" name="status_customer" value="2" <?= !empty($contractInfor->customer_infor->status_customer) &&  $contractInfor->customer_infor->status_customer == 2 ? "checked" : "" ?>>Khách hàng cũ</label>

					&nbsp;

				</p>
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
						<th scope="col" style="text-align: center">Tình trạng hôn nhân</th>
					</tr>
					</thead>
					<tbody>
					<tr>

						<!--						<td>-->
						<!--							<input type="text" value=""-->
						<!--								   style="width:100%;border:0" placeholder="...">-->
						<!--						</td>-->
						<td class="error_messages">
							<input type="text" name="customer_name" id="customer_name" value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_name : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="email" name="customer_email" id="customer_email" value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_email : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<div class="radio-inline text-primary">
								<label><input name='customer_gender' id="has_gender" value="1" <?= $contractInfor->customer_infor->customer_gender == 1 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('male')?></label>
							</div>
							<div class="radio-inline text-danger">
								<label><input name='customer_gender' id="no_gender" value="2" <?= $contractInfor->customer_infor->customer_gender == 2 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
							</div>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="date" name="customer_BOD" id="customer_BOD" value="<?= $contractInfor->customer_infor->customer_BOD ? $contractInfor->customer_infor->customer_BOD : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="customer_identify" id="customer_identify" value="<?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="date" name="date_range" id="date_range" value="<?= $contractInfor->customer_infor->date_range ? $contractInfor->customer_infor->date_range : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="issued_by" id="issued_by" value="<?= $contractInfor->customer_infor->issued_by ? $contractInfor->customer_infor->issued_by : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<?php if(!empty($contractInfor->customer_infor->id_lead)){ ?>
								<input style="width:100%;border:0" placeholder="" type="text" name="customer_phone_number" value="<?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number) : "" ?>" >
								<input type="hidden" id="customer_phone_number"  value="<?= $contractInfor->customer_infor->customer_phone_number ? encrypt($contractInfor->customer_infor->customer_phone_number) : "" ?>"  >

							<?php }else{ ?>

								<input type="text" name="customer_phone_number" id="customer_phone_number" value="<?= $contractInfor->customer_infor->customer_phone_number ? $contractInfor->customer_infor->customer_phone_number : "" ?>"
									   style="width:100%;border:0" placeholder="">
							<?php } ?>
							<input type="hidden" id="id_lead" class="form-control" value="<?= (isset($contractInfor->customer_infor->id_lead))  ? $contractInfor->customer_infor->id_lead : '' ?>">
							<p class="messages"></p>
						</td>


						<td class="error_messages">
							<select style="width:100%;border:0" class="form-control"
									id="customer_resources" >
								<option value="1" <?= $contractInfor->customer_infor->customer_resources == "1" ? "selected" : "" ?> >Digital</option>
								<option value="2" <?= $contractInfor->customer_infor->customer_resources == "2" ? "selected" : "" ?> >TLS Tự kiếm</option>
								<option value="3" <?= $contractInfor->customer_infor->customer_resources == "3" ? "selected" : "" ?> >Tổng đài</option>
								<option value="4" <?= $contractInfor->customer_infor->customer_resources == "4" ? "selected" : "" ?> >Giới thiệu</option>
								<option value="5" <?= $contractInfor->customer_infor->customer_resources == "5" ? "selected" : "" ?> >Đối tác</option>
								<option value="6" <?= $contractInfor->customer_infor->customer_resources == "6" ? "selected" : "" ?> >Fanpage</option>
								<option value="7" <?= $contractInfor->customer_infor->customer_resources == "7" ? "selected" : "" ?> >Nguồn khác</option>
								<option value="12" <?= $contractInfor->customer_infor->customer_resources == "12" ? "selected" : "" ?> >Nguồn App Mobile
								</option>
								<option value="8" <?= $contractInfor->customer_infor->customer_resources == "8" ? "selected" : "" ?> >KH vãng lai</option>
								<option value="9" <?= $contractInfor->customer_infor->customer_resources == "9" ? "selected" : "" ?> >KH tự kiếm</option>
								<option value="10" <?= $contractInfor->customer_infor->customer_resources == "10" ? "selected" : "" ?> >Cộng tác viên
								</option>
								<option value="11" <?= $contractInfor->customer_infor->customer_resources == "11" ? "selected" : "" ?> >KH giới thiệu KH
								</option>
								<option value="VM" <?= $contractInfor->customer_infor->customer_resources == "VM" ? "selected" : "" ?> >Nguồn vay mượn
								</option>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages list_ctv_hide" style="display: none">
							<select class="form-control" name="list_ctv" id="list_ctv" style="width:100%;border:0">
								<option value="">-- Chọn cộng tác viên --</option>
								<?php !empty($list_ctv) ? $list_ctv : ''; ?>
								<?php !empty($contractInfor->customer_infor->list_ctv) ? $contractInfor->customer_infor->list_ctv : ''; ?>
								<?php foreach ($list_ctv as $key => $item): ?>
									<option value="<?php echo $item->ctv_code ?>" <?php if ($item->ctv_code == $contractInfor->customer_infor->list_ctv): ?>
										selected <?php endif; ?>><?php echo $item->ctv_code. " - " .$item->ctv_name ?>
									</option>
								<?php endforeach; ?>
							</select>

							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select style="width:100%;border:0" class="form-control" id="marriage">
								<option value="1" <?= $contractInfor->customer_infor->marriage == "1" ? "selected" : "" ?> >Đã kết hôn</option>
								<option value="2" <?= $contractInfor->customer_infor->marriage == "2" ? "selected" : "" ?> >Chưa kết hôn</option>
								<option value="3" <?= $contractInfor->customer_infor->marriage == "3" ? "selected" : "" ?> >Ly hôn</option>
							</select>
							<p class="messages"></p>
						</td>

					</tr>

					</tbody>
				</table>
			</div>


			<div class="col-xs-12">
				<p>
					<strong>Thông tin nơi ở:</strong>
				</p>
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
								if(!empty($provinceData)){
									foreach($provinceData as $key => $province){
										?>
										<option <?= $contractInfor->current_address->province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
									<?php }}?>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" name="selectize_district_current_address"
									id="selectize_district_current_address" style="width:100%;border:0">
								<option value=""><?= $this->lang->line('District1') ?></option>
								<?php
								if(!empty($districtData)){
									foreach($districtData as $key => $district){
										?>
										<option <?= $contractInfor->current_address->district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
									<?php }}?>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" id="selectize_ward_current_address" >
								<option value=""> <?= $this->lang->line('Wards1') ?></option>
								<?php
								if(!empty($wardData)){
									foreach($wardData as $key => $ward){
										?>
										<option <?= $contractInfor->current_address->ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
									<?php }}?>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="current_stay_current_address" id="current_stay_current_address"
								   value="<?= $contractInfor->current_address->current_stay ? $contractInfor->current_address->current_stay : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" id="form_residence_current_address" style="width:100%;border:0">
								<option <?= $contractInfor->current_address->form_residence == 'Tạm trú' ? "selected" : "" ?> value="Tạm trú"> Tạm trú</option>
								<option <?= $contractInfor->current_address->form_residence == 'Thường trú' ? "selected" : "" ?>  value="Thường trú"> Thường trú</option>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="time_life_current_address" id="time_life_current_address" value="<?= $contractInfor->current_address->time_life ? $contractInfor->current_address->time_life : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>

					</tr>
					<tr>
						<th>Địa chỉ hộ khẩu:</th>
						<td class="error_messages">
							<select class="form-control" id="selectize_province_household">
								<option value=""><?= $this->lang->line('Province_City2') ?></option>
								<?php
								if(!empty($provinceData_)){
									foreach($provinceData_ as $key => $province){
										?>
										<option <?= $contractInfor->houseHold_address->province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
									<?php }}?>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" id="selectize_district_household">
								<option value=""><?= $this->lang->line('District1') ?></option>
								<?php
								if(!empty($districtData_)){
									foreach($districtData_ as $key => $district){
										?>
										<option <?= $contractInfor->houseHold_address->district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
									<?php }}?>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" id="selectize_ward_household">
								<option value=""><?= $this->lang->line('Wards1') ?></option>
								<?php
								if(!empty($wardData_)){
									foreach($wardData_ as $key => $ward){
										?>
										<option <?= $contractInfor->houseHold_address->ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
									<?php }}?>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="address_household" id="address_household" value="<?= $contractInfor->houseHold_address->address_household ? $contractInfor->houseHold_address->address_household : "" ?>"
								   style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
					</tr>


					</tbody>
				</table>
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
	$('#customer_resources').change(function (event){
		event.preventDefault();
		console.log("xxx")
		var check_ctv_resources = $('#customer_resources').val();
		if (check_ctv_resources == 10){
			$('.list_ctv_hide').show();
		}
		if (check_ctv_resources != 10){
			$('.list_ctv_hide').hide();
			$('#list_ctv').val("");
		}

	});

	var check_ctv_resources_update = $('#customer_resources').val();
	if (check_ctv_resources_update == 10){
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
						if (data.check_phone.data.source == 10){
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
