<div class="form-group" >
	<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Loan_form') ?> <span
				class="text-danger">*</span>
	</label>
	<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
		<select class="form-control formality" id="type_loan"
				onchange="percent_formality(this)" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?> >
			<!-- <option value=''> </option> -->
			<?php

			if ($configuration_formality) {
				foreach ($configuration_formality as $key => $cf) {
					if (!(!empty($detail) && $detail == 1) && $cf->status != "active") {
						continue;
					}
					?>
					<option data-code="<?= !empty($cf->code) ? $cf->code : "" ?>"
							data-id="<?= !empty(getId($cf->_id)) ? getId($cf->_id) : "" ?>" <?= $dataInit['type_finance'] == getId($cf->_id) ? "selected" : "" ?> ><?= !empty($cf->name) ? $cf->name : "" ?></option>
				<?php }
			} ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('Property_type') ?><span
				class="text-danger">*</span>
	</label>
	<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
		<select class="form-control" id="type_property"
				onchange="get_property_by_main_contract(this);" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
			<option></option>
			<?php
			if (!empty($mainPropertyData)) {
				foreach ($mainPropertyData as $key => $property_main) {
					if (!(!empty($detail) && $detail == 1) && !empty($property_main->_id->{'$oid'}) && $property_main->_id->{'$oid'} == "5f213c10d6612b465f4cb7b6") {
                    	continue;
                    }
					if ($dataInit['main'] == getId($property_main->_id))
						$code_pro = !empty($property_main->code) ? $property_main->code : "";
					?>
					<option data-code="<?= !empty($property_main->code) ? $property_main->code : "" ?>"
							data-id="<?= !empty(getId($property_main->_id)) ? getId($property_main->_id) : "" ?>" <?= $dataInit['main'] == getId($property_main->_id) ? "selected" : "" ?>
							value="<?= !empty($property_main->_id->{'$oid'}) ? $property_main->_id->{'$oid'} : "" ?>"><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
				<?php }
			} ?>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Sản phẩm vay <span class="text-danger">*</span>
	</label>
	<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
		<select class="form-control" id="loan_product" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
			<option value="">-- Chọn sản phẩm vay --</option>
			<option  id="loan_product_1" value="1" <?= $dataInit['loan_product'] == 1 ? "selected" : "" ?> >Vay nhanh xe máy</option>
			<option  id="loan_product_2" value="2" <?= $dataInit['loan_product'] == 2 ? "selected" : "" ?> >Vay theo đăng ký - cà vẹt xe máy chính chủ</option>
			<option  id="loan_product_3" value="3" <?= $dataInit['loan_product'] == 3 ? "selected" : "" ?> >Vay theo đăng ký - cà vẹt xe máy không chính chủ</option>
			<?php if (!empty($detail) && $detail == 1) {?>
			<option  id="loan_product_4" value="4" <?= $dataInit['loan_product'] == 4 ? "selected" : "" ?> >Cầm cố xe máy</option>
			<option  id="loan_product_5" value="5" <?= $dataInit['loan_product'] == 5 ? "selected" : "" ?> >Cầm cố ô tô</option>
			<?php } ?>
			<option  id="loan_product_6" value="6" <?= $dataInit['loan_product'] == 6 ? "selected" : "" ?> >Vay nhanh ô tô</option>
			<option  id="loan_product_7" value="7" <?= $dataInit['loan_product'] == 7 ? "selected" : "" ?> >Vay theo đăng ký - cà vẹt ô tô</option>
			<?php if (!empty($detail) && $detail == 1) {?>
			<option  id="loan_product_9" value="9" <?= $dataInit['loan_product'] == 9 ? "selected" : "" ?> >Vay tín chấp CBNV tập đoàn</option>
			<option  id="loan_product_15" value="15" <?= $dataInit['loan_product'] == 15 ? "selected" : "" ?> >Vay tín chấp CBNV Phúc Bình</option>
			<?php } ?>
			<option  id="loan_product_10" value="10" <?= $dataInit['loan_product'] == 10 ? "selected" : "" ?> >Vay theo xe CBNV VFC</option>
			<option  id="loan_product_11" value="11" <?= $dataInit['loan_product'] == 11 ? "selected" : "" ?> >Vay theo xe CBNV tập đoàn</option>
			<option  id="loan_product_12" value="12" <?= $dataInit['loan_product'] == 12 ? "selected" : "" ?> >Vay theo xe CBNV Phúc Bình</option>
			<option  id="loan_product_13" value="13" <?= $dataInit['loan_product'] == 13 ? "selected" : "" ?> >Quyền sử dụng đất</option>
			<option  id="loan_product_14" value="14" <?= $dataInit['loan_product'] == 14 ? "selected" : "" ?> >Bổ sung vốn kinh doanh Online</option>
			<option  id="loan_product_16" value="16" <?= $dataInit['loan_product'] == 16 ? "selected" : "" ?>>Sổ đỏ</option>
			<option  id="loan_product_17" value="17" <?= $dataInit['loan_product'] == 17 ? "selected" : "" ?>>Sổ hồng, hợp đồng mua bán căn hộ</option>
			<option  id="loan_product_18" value="18" <?= $dataInit['loan_product'] == 18 ? "selected" : "" ?>>Ứng tiền siêu tốc cho tài xế công nghệ</option>
			<option  id="loan_product_19" value="19" <?= $dataInit['loan_product'] == 19 ? "selected" : "" ?>>Sản phẩm vay nhanh gán định vị</option>
		</select>
	</div>
</div>

<div class="form-group" id="show_hide_linkShop" <?= (!empty($dataInit['loan_product']) && $dataInit['loan_product'] == 14) ? "" : 'style="display: none"' ?> >
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Link Shop <span class="text-danger">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12" >
		<input type="text" name='link_shop' id="link_shop" class="form-control" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?> value="<?= !empty($contractInfor->loan_infor->link_shop) ? $contractInfor->loan_infor->link_shop : "" ?>" placeholder="" >
	</div>
</div>

<div class="form-group" id="">

	<?php if (!empty($detail) && $detail == 1): ?>
		<label class="control-label col-md-3 col-sm-3 col-xs-12">Mã Seri Định Vị
		</label>
		<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
			<select class="form-control" id="selectize_positioningDevices" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
				<option><?= !empty($contractInfor->loan_infor->device_asset_location->code) ? $contractInfor->loan_infor->device_asset_location->code : ""?></option>
			</select>
		</div>
	<?php else: ?>
		<label class="control-label col-md-3 col-sm-3 col-xs-12">Mã Seri Định Vị
		</label>
		<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
			<select class="form-control" id="selectize_positioningDevices" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
				<option value=""></option>
				<?php foreach ($listSeri as $key => $value): ?>
					<option value="<?= $key ?>" <?= (!empty($contractInfor->loan_infor->device_asset_location->device_asset_location_id) && $contractInfor->loan_infor->device_asset_location->device_asset_location_id == $key) ? "selected" : ""  ?> ><?= $value ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	<?php endif; ?>

</div>
<div class="form-group">
	<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('asset_name') ?> <span
				class="text-danger">*</span>
	</label>
	<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
		<select class="form-control"
				id="selectize_property_by_main" <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>>
			<option value="<?= $dataInit['sub'] ?>"><?= $dataInit['subName'] ?></option>

		</select>
	</div>
</div>
<div class="form-group">
	<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('asset_depreciation') ?>
		<span class="text-danger">*</span>
	</label>
	<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 depreciation_by_property">
		<?php if ($code_pro == "XM") { ?>
			<?php foreach ($dataInit['minus'] as $item) { ?>
				<label><input <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>
							data-name="<?= $item['name'] ?>"
							data-slug="<?= $item['slug'] ?>"
							onchange="appraise_property(this)" <?= $item['checked'] == 1 ? "checked" : "" ?>
							name="price_depreciation" type="checkbox" value="<?= $item['price'] ?>"><?= $item['name'] ?>
				</label>
			<?php } ?>
		<?php } ?>
		<?php if ($code_pro == "OTO") { ?>
			<?php foreach ($dataInit['minus'] as $item) { ?>
				<label><input <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?>
							data-name="<?= $item['name'] ?>"
							data-slug="<?= $item['slug'] ?>"
							onchange="appraise_property(this)" <?= $item['checked'] == 1 ? "checked" : "" ?>
							name="price_depreciation" type="checkbox" value="<?= $item['price'] ?>"><?= $item['name'] ?>
				</label>
			<?php } ?>
		<?php } ?>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Asset_value') ?> <span
				class="text-danger">*</span>
	</label>
	<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
		<div class="input-group input-group-sm">
			<?php $rootPrice = !empty($dataInit['rootPrice']) ? $dataInit['rootPrice'] : 0;
			?>
			<input <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?> type="text" name='price_property'
																				   id='price_property'
																				   class="form-control " placeholder=""
																				   value="<?= !empty($rootPrice) ? number_format($rootPrice, 0, '.', ',') : 0; ?>"
																				   disabled>
			<input type="hidden" name='percent_type_loan' id="percent_type_loan" value="<?= $dataInit['percent'] ?>"
				   class="form-control " placeholder="" disabled>
			<input type="hidden" name='price_goc' class="form-control " value="<?= $dataInit['price_goc'] ?>"
				   placeholder="" disabled>
			<span class="input-group-addon"> VNĐ</span>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Số tiền tối đa có thể vay <span
				class="text-danger">*</span>
	</label>
	<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
		<div class="input-group input-group-sm">
			<?php $editPrice = !empty($dataInit['editPrice']) ? number_format($dataInit['editPrice'], 0, '.', ',') : '0'; ?>
			<input <?php echo !empty($detail) && $detail == 1 ? 'disabled' : '' ?> type="text" name='amount_money'
																				   id='amount_money'
																				   class="form-control" placeholder=""
																				   value="<?= !empty($editPrice) ? $editPrice : 0; ?>"
																				   disabled>
			<span class="input-group-addon"> VNĐ</span>
		</div>
	</div>
</div>


<script>
	var isLoading = false;
	var isUploaded = false;
	if ($('#imgInpDevice_show').attr('src') != "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png") {
		isUploaded = true;
	}
	var imageId;
	$('#imgInpDevice_show').on('click', function () {
		isUploaded = false;
		$('#imgInpDevice').trigger('click');
		imageId = $(this).attr('id');
	});
	$('#imgInpDevice').on('change', function () {
		var files = $(this)[0].files[0];
		var formData = new FormData();
		formData.append('file', files);
		isUploaded = false;
		$.ajax({
			dataType: 'json',
			enctype: 'multipart/form-data',
			url: _url.base_url + 'ajax/upload_img',
			type: 'POST',
			data: formData,
			processData: false, // tell jQuery not to process the data
			contentType: false, // tell jQuery not to set contentType
			beforeSend: function () {
				$(".loading").show();
			},
			success: function (data) {
				if (data.code == 200 && data.path !== "") {
					if (data.path != null && data.path != "") {
						$("#imgInpDevice_show").attr("src", data.path);
						$(".loading").hide();
						isUploaded = true;
					}
					// Set image for user avatar on the header

				} else {

					$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
				}
			}
		});
	});
</script>
