<div class="row">
	<div class="col-md-6">
		<div class="x_panel">
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Loan_form') ?> <span
							class="text-danger">*</span>
				</label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<select class="form-control formality" id="type_loan" onchange="percent_formality(this)">
						<!-- <option value=''> </option> -->
						<?php
						function get_select_type($id_c, $id_l)
						{
							if ($id_l == "") {
								return "";
							} elseif ($id_c == "") {
								return "";
							} else {
								if ($id_c == 'CC' && in_array($id_l, array('1', '2'))) {
									return "selected";
								} else if ($id_c == 'DKX' && in_array($id_l, array('3', '4'))) {
									return "selected";
								} else {
									return "";
								}
							}
						}

						function get_select_type_access($id_c, $id_l)
						{
							if ($id_l == "") {
								return "";
							} elseif ($id_c == "") {
								return "";
							} else {
								if ($id_c == 'OTO' && in_array($id_l, array('1', '3'))) {
									return "selected";
								} else if ($id_c == 'XM' && in_array($id_l, array('2', '4'))) {
									return "selected";
								} else {
									return "";
								}
							}
						}

						if ($configuration_formality) {
							foreach ($configuration_formality as $cf) {
								if ($cf->status != "active") {
									continue;
								}
								?>
								<option <?= get_select_type($cf->code, $type_finance); ?>
										data-id="<?= !empty(getId($cf->_id)) ? getId($cf->_id) : "" ?>"
										data-code="<?= !empty($cf->code) ? $cf->code : "" ?>"><?= !empty($cf->name) ? $cf->name : "" ?></option>
							<?php }
						} ?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Property_type') ?> <span
							class="text-danger">*</span>
				</label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<select class="form-control" id="type_property" onchange="get_property_by_main_contract(this);">
						<option value="">Chọn loại tài sản</option>
						<?php
						if (!empty($main_PropertyData)) {
							foreach ($main_PropertyData as $property_main) {
								if (!empty($property_main->_id->{'$oid'}) && $property_main->_id->{'$oid'} == "5f213c10d6612b465f4cb7b6") {
			                		continue;
			                	}
								?>
								<option <?= get_select_type_access($property_main->code, $type_finance); ?>
										data-code="<?= !empty($property_main->code) ? $property_main->code : "" ?>"
										value="<?= !empty($property_main->_id->{'$oid'}) ? $property_main->_id->{'$oid'} : "" ?>"><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
							<?php }
						} ?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Sản phẩm vay <span class="text-danger">*</span>
				</label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<select class="form-control" id="loan_product">
						<option value="">-- Chọn sản phẩm vay --</option>
						<option style="display: none" id="loan_product_1" value="1">Vay nhanh xe máy</option>
						<option style="display: none" id="loan_product_2" value="2">Vay theo đăng ký - cà vẹt xe máy
							chính
							chủ
						</option>
						<option style="display: none" id="loan_product_3" value="3">Vay theo đăng ký - cà vẹt xe máy
							không
							chính
							chủ
						</option>
						<!-- <option style="display: none" id="loan_product_4" value="4">Cầm cố xe máy</option>
						<option style="display: none" id="loan_product_5" value="5">Cầm cố ô tô</option> -->
						<option style="display: none" id="loan_product_6" value="6">Vay nhanh ô tô</option>
						<option style="display: none" id="loan_product_7" value="7">Vay theo đăng ký - cà vẹt ô tô
						</option>

						<!-- <option style="display: none" id="loan_product_9" value="9">Vay tín chấp CBNV tập đoàn</option>
						<option style="display: none" id="loan_product_15" value="15">Vay tín chấp CBNV Phúc Bình
						</option> -->
						<option style="display: none" id="loan_product_10" value="10">Vay theo xe CBNV VFC</option>
						<option style="display: none" id="loan_product_11" value="11">Vay theo xe CBNV tập đoàn</option>
						<option style="display: none" id="loan_product_12" value="12">Vay theo xe CBNV Phúc Bình
						</option>
						<option style="display: none" id="loan_product_13" value="13">Quyền sử dụng đất</option>
						<option style="display: none" id="loan_product_14" value="14">Bổ sung vốn kinh doanh Online
						</option>
						<option style="display: none" id="loan_product_16" value="16">Sổ đỏ</option>
						<option style="display: none" id="loan_product_17" value="17">Sổ hồng, hợp đồng mua bán căn hộ
						</option>
						<option style="display: none" id="loan_product_18" value="18">Ứng tiền siêu tốc cho tài xế công
							nghệ
						</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('asset_name') ?><span
							class="text-danger">*</span></label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<select class="form-control" id="selectize_property_by_main">
						<option></option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('asset_depreciation') ?>
					<span class="text-danger">*</span></label>
				<div class="col-md-9 col-sm-6 col-xs-12 depreciation_by_property" style="min-height: 34px">

				</div>
			</div>

			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Asset_value') ?> <span
							class="text-danger">*</span></label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<div class="input-group-sm">
						<input type="text" name='price_property' id="price_property" class="form-control "
							   placeholder=""
							   disabled>
						<input type="hidden" name='price_goc' id="price_goc" value="0" class="form-control "
							   placeholder=""
							   disabled>
						<input type="hidden" name='percent_type_loan' id="percent_type_loan" value="0"
							   class="form-control "
							   placeholder="" disabled>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Số tiền được vay <span
							class="text-danger">*</span>
				</label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<div class="input-group-sm">
						<input type="text" name='amount_money' id="amount_money" class="form-control" placeholder=""
							   disabled>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="x_panel">
			<div class="theloading" style="display:none">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Số tiền vay
				</label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<input type="text" id="money"
						   value="<?= isset($_GET['money_lead']) ? $_GET['money_lead'] : "" ?>"
						   class="form-control " placeholder="Nhập số tiền vay" required name="money">
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Hình thức trả lãi
				</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<select class="form-control district_shop" name="hinh_thuc_tra_lai">
						<?php $hinh_thuc_tra_lai = isset($_GET['hinh_thuc_tra_lai']) ? $_GET['hinh_thuc_tra_lai'] : ''; ?>

						<option value="">Chọn hình thức trả lãi</option>
						<?php foreach (type_repay() as $t => $v) { ?>
							<option <?php echo $hinh_thuc_tra_lai == $t ? 'selected' : '' ?>
									value="<?= $t ?>"><?= $v ?></option>
						<?php } ?>
					</select>

				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Kỳ hạn vay
				</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<select class="form-control" id="number_day_loan" name="ki_han_vay">
						<option value="">-- Chọn kỳ hạn vay --</option>
						<option value="1">
							1 tháng
						</option>
						<option value="3">
							3 tháng
						</option>
						<option value="6">
							6 tháng
						</option>
						<option value="9">
							9 tháng
						</option>
						<option value="12">
							12 tháng
						</option>
						<option value="18">
							18 tháng
						</option>
						<option value="24">
							24 tháng
						</option>
					</select>

				</div>
			</div>

			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Hình thức phí
				</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<select class="form-control district_shop" name="hinh_thuc_phi">
						<option value="">Chọn hình thức phí</option>
						<option class="u49_input_option" selected="" value="bpc">Biểu phí chuẩn</option>
						<option class="u49_input_option" value="coupon">Áp dụng Cupon</option>
						<option class="u49_input_option" value="other">Khác</option>
					</select>
				</div>
			</div>

			<div style="display:none" id="form_coupon">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Chương trình ưu đãi <span class="text-danger">*</span>
					</label>
					<div class="col-md-9 col-sm-12 col-12">
						<select class="form-control" id="code_coupon">
							<option value="">-- Chọn Chương trình ưu đãi --</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Vùng
					</label>
					<div class="col-md-9 col-sm-6 col-xs-12">
						<select class="form-control district_shop" name="code_area" id="code_area">
							<option value="">Chọn khu vực</option>

							<?php
							if (!empty($areaData)) {

								foreach ($areaData as $area) {

									?>
									<option value="<?= !empty($area->code) ? $area->code : ""; ?>" <?php if (!empty($coupon->code_area) && in_array($area->code, $coupon->code_area)) {
										echo 'selected';
									} else {
										echo '';
									} ?>><?= !empty($area->title) ? $area->title : ""; ?></option>
								<?php }
							} ?>
						</select>

					</div>
				</div>
				<div class="form-group row">

					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Phòng giao dịch<span class="text-danger">*</span>
					</label>
					<div class="col-md-9 col-sm-6 col-xs-12">
						<select class="form-control" id="stores"
								data-id="<?= $contractInfor->store->id; ?>">
							<?php

							foreach ($stores as $store) {

								?>
								<option data-address="<?= !empty($store->address) ? $store->address : "" ?>"
										data-code-address="<?= !empty($store->code_address_store) ? $store->code_address_store : "" ?>"
										value="<?= !empty($store->_id->{'$oid'}) ? $store->_id->{'$oid'} : "" ?>"><?= !empty($store->name) ? $store->name : "" ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div style="display:none" id="form_other">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Lãi suất vay
					</label>
					<div class="col-md-9 col-sm-6 col-xs-12">
						<input type="number" name="loan_interest"
							   value="<?= isset($_GET['loan_interest']) ? $_GET['loan_interest'] : "" ?>"
							   class="form-control " placeholder="Nhập % lãi suất vay"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Phí tư vấn quản lý
					</label>
					<div class="col-md-9 col-sm-6 col-xs-12">
						<input type="number"
							   value="<?= isset($_GET['management_consulting_fee']) ? $_GET['management_consulting_fee'] : "" ?>"
							   name="management_consulting_fee" class="form-control "
							   placeholder="Nhập % phí tư vấn quản lý ">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Phí thẩm định và lưu trữ tài sản
					</label>
					<div class="col-md-9 col-sm-6 col-xs-12">
						<input type="number" name="renewal_fee"
							   value="<?= isset($_GET['renewal_fee']) ? $_GET['renewal_fee'] : "" ?>"
							   class="form-control" placeholder="Nhập % phí thẩm định">
					</div>
				</div>

			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Ngày giải ngân
				</label>
				<div class="col-md-9 col-sm-6 col-xs-12">
					<input type="date" name="date" class="form-control" value="<?= date("Y-m-d"); ?>">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
					<a class="btn btn-danger  clear_calculator">
						Làm lại
					</a>
					<a class="btn btn-success  calculator_loan">
						<i class="fa fa-save"></i>
						Tính lãi phí
					</a>

				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 row" style="justify-content: center">
				<div class="table-responsive table-calculator" style="display: none">
					<table id="tb_caculator" class="table table-striped datatable-buttons">
						<thead>
						<tr>
							<th>Kỳ trả</th>
							<th>Ngày trả</th>
							<th>Số ngày</th>
							<th>Tiền lãi</th>
							<th>Tiền phí</th>
							<th>Gốc và lãi</th>
							<th>Tiền gốc kỳ</th>
							<th>Tiền trả kỳ</th>
						</tr>
						</thead>
						<tbody>
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
<script src="<?php echo base_url(); ?>assets/js/pawn/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/accountant/caculator.js"></script>
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script>
	$(document).ready(function () {
		$(".calculator_loan").on("click", function () {
			var type_loan = $("#type_loan :selected").data("code");
			var type_property = $("#type_property :selected").data("code");
			var amount_money = $("#money").val() !== undefined ? getFloat($("#money").val()) : 0;
			var ky_han = $("#number_day_loan :selected").val();
			var hinh_thuc_tra_lai = $("select[name='hinh_thuc_tra_lai'] :selected").val();
			var hinh_thuc_phi = $("select[name='hinh_thuc_phi'] :selected").val();
			var ngay_giai_ngan = $("input[name='date']").val();
			var coupon = $("#code_coupon").val();
			var ngay_tat_toan = $("input[name='ngay_tat_toan']").val();
			var management_consulting_fee = $("input[name='management_consulting_fee']").val() !== undefined ? $("input[name='management_consulting_fee']").val() : 0;
			var renewal_fee = $("input[name='renewal_fee']").val() !== undefined ? $("input[name='renewal_fee']").val() : 0;
			var loan_interest = $("input[name='loan_interest']").val() !== undefined ? $("input[name='loan_interest']").val() : 0;
			var loan_product = $("#loan_product").val();
			var formData = {
				type_loan: type_loan,
				type_property: type_property,
				amount_money: amount_money,
				ky_han: ky_han,
				hinh_thuc_tra_lai: hinh_thuc_tra_lai,
				hinh_thuc_phi: hinh_thuc_phi,
				ngay_giai_ngan: ngay_giai_ngan,
				coupon: coupon,
				management_consulting_fee: management_consulting_fee,
				renewal_fee: renewal_fee,
				loan_interest: loan_interest,
				ngay_tat_toan: ngay_tat_toan,
				loan_product: loan_product,

			};


			$.ajax({
				url: _url.base_url + "accountant/process_caculator_monthly_fee",
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					if (data.code == 200) {
						$(".theloading").hide();
						$('#tb_caculator tbody').empty();
						$('#tb_caculator tbody').append(data.data);
						$('.table-calculator').show()
					} else {
						$(".theloading").hide();
						$('.table-calculator').hide()
						console.log('error')
					}
				},
				error: function (error) {
					$(".theloading").hide();
					$('.table-calculator').hide()
					console.log('error')
				}
			})
		});
		$('.clear_calculator').click(function () {
			$("input[name='money']").val('');
			$("select[name='hinh_thuc_tra_lai']").val('');
			$("select[name='ki_han_vay']").val('');
			$("select[name='hinh_thuc_phi']").val('');
			$("#form_coupon").css("display", "none");
			$("#form_other").css("display", "none");
			$('#tb_caculator tbody').empty();
			$('.table-calculator').hide()
		})

		$('.tool_dinh_gia').click(function () {
			$('#loan_product').val('')
			var selectClass = $('#selectize_property_by_main').selectize();
			var selectizeClass = selectClass[0].selectize;
			selectizeClass.clear();
			selectizeClass.clearOptions();
			selectizeClass.load(function (callback) {
				callback('');
			});
			$("#depreciation_by_property").css("display", "none");
			$('.properties').children().remove();
			$("input[name='money']").val('');
			$("select[name='hinh_thuc_tra_lai']").val('');
			$("select[name='ki_han_vay']").val('');
			$("select[name='hinh_thuc_phi']").val('');
			$("#form_coupon").css("display", "none");
			$("#form_other").css("display", "none");
			$('#tb_caculator tbody').empty();
			$('.table-calculator').hide()
		})
	})
</script>
<style>
	.theloading {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		align-items: center;
		justify-content: center;
		background: #c3b8b8a6;
		z-index: 9999;
		display: flex;
	}
</style>
