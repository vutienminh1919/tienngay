<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Loan_form')?> <span class="text-danger">*</span>
    </label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
        <select class="form-control formality" id="type_loan"  onchange="percent_formality(this)" >
            <!-- <option value=''> </option> -->
            <?php 
             function get_select_type($id_c,$id_l)
            {
                if($id_l=="")
                {return "";}
                elseif ($id_c=="") {
                  return "";
                }else {
                    if($id_c=='CC' && in_array($id_l,array('1','2')))
                    {
                           return "selected";
                    }else if($id_c=='DKX' && in_array($id_l,array('3','4')))
                    {
                         return "selected";
                     }else{
                        return "";
                     }
           }
          }
          function get_select_type_access($id_c,$id_l)
            {
                if($id_l=="")
                {return "";}
                elseif ($id_c=="") {
                  return "";
                }else {
                    if($id_c=='OTO' && in_array($id_l,array('1','3')))
                    {
                           return "selected";
                    }else if($id_c=='XM' && in_array($id_l,array('2','4')))
                    {
                         return "selected";
                     }else{
                        return "";
                     }
           }
          }
                if($configuration_formality){
                    foreach($configuration_formality as $key => $cf){
                    	if ($cf->status != "active") {
							continue;
						}
            ?>
            <option <?= get_select_type($cf->code,$type_finance); ?> data-id="<?= !empty(getId($cf->_id)) ? getId($cf->_id) : ""?>" data-code="<?= !empty($cf->code) ? $cf->code : ""?>" ><?= !empty($cf->name) ? $cf->name : ""?></option>
             <?php }}?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Property_type')?> <span class="text-danger">*</span>
    </label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
        <select class="form-control" id="type_property" onchange="get_property_by_main_contract(this);" >
            <option></option>
            <?php 
                if(!empty($mainPropertyData)){
                    foreach($mainPropertyData as $key => $property_main){
                    	if (!empty($property_main->_id->{'$oid'}) && $property_main->_id->{'$oid'} == "5f213c10d6612b465f4cb7b6") {
                    		continue;
                    	}
                ?>
            <option <?= get_select_type_access($property_main->code,$type_finance); ?> data-code="<?= !empty($property_main->code) ? $property_main->code : "" ?>" value="<?= !empty($property_main->_id->{'$oid'}) ? $property_main->_id->{'$oid'} : "" ?>"><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
            <?php } }?>
        </select>
    </div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Sản phẩm vay <span class="text-danger">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control" id="loan_product">
			<option value="">-- Chọn sản phẩm vay --</option>
			<option style="display: none" id="loan_product_1" value="1" <?= $dataInit['loan_product'] == 1 ? "selected" : "" ?>>Vay nhanh xe máy</option>
			<option style="display: none" id="loan_product_2" value="2" <?= $dataInit['loan_product'] == 2 ? "selected" : "" ?>>Vay theo đăng ký - cà vẹt xe máy chính chủ</option>
			<option style="display: none" id="loan_product_3" value="3" <?= $dataInit['loan_product'] == 3 ? "selected" : "" ?>>Vay theo đăng ký - cà vẹt xe máy không chính chủ</option>
			<!-- <option style="display: none" id="loan_product_4" value="4" <?= $dataInit['loan_product'] == 4 ? "selected" : "" ?>>Cầm cố xe máy</option>
			<option style="display: none" id="loan_product_5" value="5" <?= $dataInit['loan_product'] == 5 ? "selected" : "" ?>>Cầm cố ô tô</option> -->
			<option style="display: none" id="loan_product_6" value="6" <?= $dataInit['loan_product'] == 6 ? "selected" : "" ?>>Vay nhanh ô tô</option>
			<option style="display: none" id="loan_product_7" value="7" <?= $dataInit['loan_product'] == 7 ? "selected" : "" ?>>Vay theo đăng ký - cà vẹt ô tô</option>

			<!-- <option style="display: none" id="loan_product_9" value="9" <?= $dataInit['loan_product'] == 9 ? "selected" : "" ?>>Vay tín chấp CBNV tập đoàn</option>
			<option style="display: none" id="loan_product_15" value="15" <?= $dataInit['loan_product'] == 15 ? "selected" : "" ?>>Vay tín chấp CBNV Phúc Bình</option> -->
			<option style="display: none" id="loan_product_10" value="10" <?= $dataInit['loan_product'] == 10 ? "selected" : "" ?>>Vay theo xe CBNV VFC</option>
			<option style="display: none" id="loan_product_11" value="11" <?= $dataInit['loan_product'] == 11 ? "selected" : "" ?>>Vay theo xe CBNV tập đoàn</option>
			<option style="display: none" id="loan_product_12" value="12" <?= $dataInit['loan_product'] == 12 ? "selected" : "" ?>>Vay theo xe CBNV Phúc Bình</option>
			<option style="display: none" id="loan_product_13" value="13" <?= $dataInit['loan_product'] == 13 ? "selected" : "" ?>>Quyền sử dụng đất</option>
			<option style="display: none" id="loan_product_14" value="14" <?= $dataInit['loan_product'] == 14 ? "selected" : "" ?>>Bổ sung vốn kinh doanh Online</option>
			<option style="display: none" id="loan_product_16" value="16" <?= $dataInit['loan_product'] == 16 ? "selected" : "" ?>>Sổ đỏ</option>
			<option style="display: none" id="loan_product_17" value="17" <?= $dataInit['loan_product'] == 17 ? "selected" : "" ?>>Sổ hồng, hợp đồng mua bán căn hộ</option>
			<option style="display: none" id="loan_product_18" value="18" <?= $dataInit['loan_product'] == 18 ? "selected" : "" ?>>Ứng tiền siêu tốc cho tài xế công nghệ</option>
			<option id="loan_product_19" value="19" <?= $dataInit['loan_product'] == 19 ? "selected" : "" ?>>Sản phẩm vay nhanh gán định vị</option>
		</select>
	</div>
</div>
<div class="form-group" id="show_hide_linkShop" style="display: none">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Link Shop <span class="text-danger">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="text" name='link_shop' id="link_shop" class="form-control "  placeholder="" >
	</div>
</div>
<div class="form-group" id="">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Mã Seri Định Vị
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control" id="selectize_positioningDevices">
			<option value=""></option>
			<?php foreach ($listSeri as $key => $value): ?>
				<option value="<?= $key ?>" ><?= $value ?></option>
			<?php endforeach; ?>
		</select>
	</div>


</div>

<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('asset_name')?><span class="text-danger">*</span></label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
        <select class="form-control" id="selectize_property_by_main" >
            <option></option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('asset_depreciation')?><span class="text-danger">*</span></label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 depreciation_by_property" ></div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Asset_value')?> <span class="text-danger">*</span></label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
        <div class="input-group input-group-sm">
            <input type="text" name='price_property' id="price_property" class="form-control "  placeholder="" disabled>
            <input type="hidden" name='price_goc' id="price_goc" value="0"  class="form-control "  placeholder="" disabled>
            <input type="hidden" name='percent_type_loan' id="percent_type_loan" value="0"  class="form-control "  placeholder="" disabled>
            <span class="input-group-addon"> VNĐ</span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Số tiền tối đa có thể vay <span class="text-danger">*</span>
    </label>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
        <div class="input-group input-group-sm">
            <input type="text" name='amount_money' id="amount_money" class="form-control"  placeholder="" disabled>
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

