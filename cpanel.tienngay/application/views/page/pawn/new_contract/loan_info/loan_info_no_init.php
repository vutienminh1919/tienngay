<div>
	<table class="table table-bordered">
		<thead>
		<tr>
			<th scope="col" style="text-align: center">Hình thức vay <span class="text-danger">*</span></th>
			<th scope="col" style="text-align: center">Loại tài sản <span class="text-danger">*</span></th>
			<th scope="col" style="text-align: center">Sản phẩm vay <span class="text-danger">*</span></th>
			<th scope="col" style="text-align: center">Tài sản vay <span class="text-danger">*</span></th>
			<th scope="col" style="text-align: center">Khấu hao tài sản</th>
			<th scope="col" style="text-align: center">Định giá trài sản</th>
			<th scope="col" style="text-align: center">Số tiền được vay</th>

		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="error_messages">
				<select class="form-control formality" id="type_loan" onchange="percent_formality(this)"
						style="width:100%;border:0">
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
						foreach ($configuration_formality as $key => $cf) {
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
				<p class="messages"></p>
			</td>
			<td class="error_messages">
				<select class="form-control" id="type_property" onchange="get_property_by_main_contract(this);"
						style="width:100%;border:0">
					<option></option>
					<?php
					if (!empty($mainPropertyData)) {
						foreach ($mainPropertyData as $key => $property_main) {
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
				<p class="messages"></p>
			</td>
			<td class="error_messages">
				<select class="form-control" id="loan_product" style="width:100%;border:0">
					<option value="">-- Chọn sản phẩm vay --</option>
					<option style="display: none" id="loan_product_1"
							value="1" <?= $dataInit['loan_product'] == 1 ? "selected" : "" ?>>Vay nhanh xe máy
					</option>
					<option style="display: none" id="loan_product_2"
							value="2" <?= $dataInit['loan_product'] == 2 ? "selected" : "" ?>>Vay theo đăng ký - cà vẹt
						xe máy
					</option>
					<option style="display: none" id="loan_product_3"
							value="3" <?= $dataInit['loan_product'] == 3 ? "selected" : "" ?>>Vay theo đăng ký - cà vẹt
						xe máy không chính chủ
					</option>
					<!-- <option style="display: none" id="loan_product_4"
							value="4" <?= $dataInit['loan_product'] == 4 ? "selected" : "" ?>>Cầm cố xe máy
					</option>
					<option style="display: none" id="loan_product_5"
							value="5" <?= $dataInit['loan_product'] == 5 ? "selected" : "" ?>>Cầm cố ô tô
					</option> -->
					<option style="display: none" id="loan_product_6"
							value="6" <?= $dataInit['loan_product'] == 6 ? "selected" : "" ?>>Vay nhanh ô tô
					</option>
					<option style="display: none" id="loan_product_7"
							value="7" <?= $dataInit['loan_product'] == 7 ? "selected" : "" ?>>Vay theo đăng ký - cà vẹt
						ô tô
					</option>
					<!-- <option style="display: none" id="loan_product_8"
							value="8" <?= $dataInit['loan_product'] == 8 ? "selected" : "" ?>>Vay tín chấp CBNV VFC
					</option>
					<option style="display: none" id="loan_product_9"
							value="9" <?= $dataInit['loan_product'] == 9 ? "selected" : "" ?>>Vay tín chấp CBNV tập đoàn
					</option>
					<option style="display: none" id="loan_product_15"
							value="15" <?= $dataInit['loan_product'] == 15 ? "selected" : "" ?>>Vay tín chấp CBNV Phúc
						Bình
					</option> -->
					<option style="display: none" id="loan_product_10"
							value="10" <?= $dataInit['loan_product'] == 10 ? "selected" : "" ?>>Vay theo xe CBNV VFC
					</option>
					<option style="display: none" id="loan_product_11"
							value="11" <?= $dataInit['loan_product'] == 11 ? "selected" : "" ?>>Vay theo xe CBNV tập
						đoàn
					</option>
					<option style="display: none" id="loan_product_12"
							value="12" <?= $dataInit['loan_product'] == 12 ? "selected" : "" ?>>Vay theo xe CBNV Phúc
						Bình
					</option>
					<option style="display: none" id="loan_product_13"
							value="13" <?= $dataInit['loan_product'] == 13 ? "selected" : "" ?>>Quyền sử dụng đất
					</option>
					<option style="display: none" id="loan_product_14"
							value="14" <?= $dataInit['loan_product'] == 14 ? "selected" : "" ?>>Bổ sung vốn kinh doanh
						Online
					</option>
					<option style="display: none" id="loan_product_16" value="16" <?= $dataInit['loan_product'] == 16 ? "selected" : "" ?> >Sổ đỏ
					</option>
					<option style="display: none" id="loan_product_17" value="17" <?= $dataInit['loan_product'] == 17 ? "selected" : "" ?> >Sổ hồng,
						hợp đồng mua bán căn hộ
					</option>
				</select>
				<p class="messages"></p>
			</td>
			<td class="error_messages">
				<select class="form-control" id="selectize_property_by_main" style="width:100%;border:0">
					<option></option>
				</select>
				<p class="messages"></p>
			</td>
			<td class="error_messages">
				<div class="depreciation_by_property"></div>
				<p class="messages"></p>
			</td>
			<td class="error_messages">
				<div class="input-group input-group-sm">
					<input type="text" name='price_property' id="price_property" class="form-control" placeholder=""
						   disabled>
					<input type="hidden" name='price_goc' id="price_goc" value="0" class="form-control " placeholder=""
						   disabled>
					<input type="hidden" name='percent_type_loan' id="percent_type_loan" value="0" class="form-control "
						   placeholder="" disabled>
					<span class="input-group-addon"> VNĐ</span>
				</div>
				<p class="messages"></p>
			</td>
			<td class="error_messages">
				<div class="input-group input-group-sm">
					<input type="text" name='amount_money' id="amount_money" class="form-control" placeholder=""
						   disabled>
					<span class="input-group-addon"> VNĐ</span>
				</div>
				<p class="messages"></p>
			</td>
		</tr>

		</tbody>
	</table>
</div>

<script>
	$(document).ready(function () {


		$('#type_property').change(function (event) {
			event.preventDefault();

			var check_type_loan = $('#type_loan').val();
			var check_type_property = $('#type_property').val();
			console.log(check_type_loan);
			console.log(check_type_property);
			if (check_type_property == "606aceb461a5d8511f0c4d33") {
				$('#loan_product').val("");
				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').hide();
				$('#loan_product_15').hide();
				$('#loan_product_16').show();
				$('#loan_product_17').show();
			} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6bfd6612bceec515b76") {
				$('#loan_product').val("");
				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').show();
				$('#loan_product_7').show();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').show();
				$('#loan_product_11').show();
				$('#loan_product_12').show();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6b4d6612b173e0728a4") {
				$('#loan_product').val("");
				$('#loan_product_1').show();
				$('#loan_product_2').show();
				$('#loan_product_3').show();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').show();
				$('#loan_product_11').show();
				$('#loan_product_12').show();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6bfd6612bceec515b76") {
				$('#loan_product').val("");
				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').show();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6b4d6612b173e0728a4") {
				$('#loan_product').val("");
				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').show();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Tín chấp") {
				$('#loan_product').val("");
				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').show();
				$('#loan_product_9').show();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').show();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else {
				$('#loan_product').val("");
				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').hide();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			}

		});

		$('#type_loan').change(function (event) {
			event.preventDefault();


			var check_type_loan = $('#type_loan').val();
			var check_type_property = $('#type_property').val();

			if (check_type_property == "5f213c10d6612b465f4cb7b6") {

				$('#type_property').val('');

			}

			if (check_type_property == "606aceb461a5d8511f0c4d33") {
				$('#loan_product').val("");
				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').hide();
				$('#loan_product_15').hide();
				$('#loan_product_16').show();
				$('#loan_product_17').show();
			} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6bfd6612bceec515b76") {
				$('#loan_product').val("");
				$("#type_property").prop('disabled', false);
				$("#fee_gic_easy_hide").show();
				$("#fee_gic_easy_hide_1").show();

				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').show();
				$('#loan_product_7').show();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').show();
				$('#loan_product_11').show();
				$('#loan_product_12').show();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6b4d6612b173e0728a4") {
				$('#loan_product').val("");
				$("#type_property").prop('disabled', false);
				$("#fee_gic_easy_hide").show();
				$("#fee_gic_easy_hide_1").show();

				$('#loan_product_1').show();
				$('#loan_product_2').show();
				$('#loan_product_3').show();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').show();
				$('#loan_product_11').show();
				$('#loan_product_12').show();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6bfd6612bceec515b76") {
				$('#loan_product').val("");
				$("#type_property").prop('disabled', false);
				$("#fee_gic_easy_hide").show();
				$("#fee_gic_easy_hide_1").show();

				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').show();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6b4d6612b173e0728a4") {
				$('#loan_product').val("");
				$("#type_property").prop('disabled', false);
				$("#fee_gic_easy_hide").show();
				$("#fee_gic_easy_hide_1").show();

				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').show();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else if (check_type_loan == "Tín chấp") {
				$('#loan_product').val("");
				$("#type_property").prop('disabled', false);
				$("#fee_gic_easy_hide").show();
				$("#fee_gic_easy_hide_1").show();

				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').show();
				$('#loan_product_9').show();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').show();
				$('#loan_product_15').show();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			} else {
				$('#loan_product').val("");
				$("#type_property").prop('disabled', false);
				$("#fee_gic_easy_hide").show();
				$("#fee_gic_easy_hide_1").show();

				$('#loan_product_1').hide();
				$('#loan_product_2').hide();
				$('#loan_product_3').hide();
				$('#loan_product_4').hide();
				$('#loan_product_5').hide();
				$('#loan_product_6').hide();
				$('#loan_product_7').hide();
				$('#loan_product_8').hide();
				$('#loan_product_9').hide();
				$('#loan_product_10').hide();
				$('#loan_product_11').hide();
				$('#loan_product_12').hide();
				$('#loan_product_13').hide();
				$('#loan_product_14').hide();
				$('#loan_product_15').hide();
				$('#loan_product_16').hide();
				$('#loan_product_17').hide();
			}

			if (check_type_loan == "Tín chấp") {
				$("#type_property").val("5f213c10d6612b465f4cb7b6");
				// $("#type_property").val("5fd8170905390000c50077e9");


				function get_property_by_main_contract() {
					var id = "5f213c10d6612b465f4cb7b6"
					// var id = "5fd8170905390000c50077e9"
					var code = $("#type_property :selected").data("code")
					if (code == "OTO") {
						$('select[name="gic_easy"]').val("0");
						$('select[name="gic_easy"]').prop('disabled', true);
						$('#fee_gic_easy').val(0);
						$('#phi_tnds').val(0);
					} else {
						$('select[name="gic_easy"]').prop('disabled', false);
					}
					var formData = {
						id: id
					};
					$.ajax({
						url: _url.base_url + '/Ajax/getPopertyByMain',
						type: "POST",
						data: formData,
						dataType: 'json',
						beforeSend: function () {
							$("#loading").show();
						},
						success: function (data) {
							if (data.res) {
								var selectClass = $('#selectize_property_by_main').selectize();
								var selectizeClass = selectClass[0].selectize;
								selectizeClass.clear();
								selectizeClass.clearOptions();
								selectizeClass.load(function (callback) {
									callback(data.data);
								});
								$('.properties').children().remove();
								$('.properties_b').children().remove();
								let html = "";
								let html_b = "";
								let content = data.properties;
								// console.log(content);
								// for (var i = 0; i < content.length; i++) {
								// 	if (content[i].slug == "ngay-cap") {
								// 		html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='date' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
								// 	} else if (content[i].slug == "so-dang-ky") {
								// 		html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='6' type='text' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
								// 	} else {
								// 		html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='text' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
								// 	}
								// }
								$(".properties").append(html);
								$(".properties_b").append(html_b);
								$("input[data-slug='so-dang-ky']").keyup(function (event) {
									// skip for arrow keys
									if (event.which >= 37 && event.which <= 40) return;
									// format number
									$(this).val(function (index, value) {
										return value
												.replace(/\D/g, "");
									});
								});


							} else {
								$('#errorModal').modal('show');
								$('.msg_error').text(data.message);
							}
						},
						error: function (data) {
							console.log(data);
							$("#loading").hide();
						}
					});
					get_coupon();

				};
				get_property_by_main_contract();

				$("#type_property").prop('disabled', true);
				$("#fee_gic_easy_hide").hide();
				$("#fee_gic_easy_hide_1").hide();
				$("#gic_easy").val(0);
				$("#fee_gic_easy").val(0);

				var check_loan_product_1 = $('#loan_product').val();

				if (check_loan_product_1 == 14) {
					var price_property_asset_1 = getFloat($('#price_property').val());
					var result_total_4 = price_property_asset_1 * 0.8;

					$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
				}
			}


		});

		var check_type_loan_update = $('#type_loan').val();
		var check_type_property_update = $('#type_property').val();
		if (check_type_property_update == "606aceb461a5d8511f0c4d33") {
			$('#loan_product').val("");
			$('#loan_product_1').hide();
			$('#loan_product_2').hide();
			$('#loan_product_3').hide();
			$('#loan_product_4').hide();
			$('#loan_product_5').hide();
			$('#loan_product_6').hide();
			$('#loan_product_7').hide();
			$('#loan_product_8').hide();
			$('#loan_product_9').hide();
			$('#loan_product_10').hide();
			$('#loan_product_11').hide();
			$('#loan_product_12').hide();
			$('#loan_product_13').hide();
			$('#loan_product_14').hide();
			$('#loan_product_15').hide();
			$('#loan_product_16').show();
			$('#loan_product_17').show();
		} else if (check_type_loan_update == "Cho vay" && check_type_property_update == "5db7e6bfd6612bceec515b76") {

			$('#loan_product_1').hide();
			$('#loan_product_2').hide();
			$('#loan_product_3').hide();
			$('#loan_product_4').hide();
			$('#loan_product_5').hide();
			$('#loan_product_6').show();
			$('#loan_product_7').show();
			$('#loan_product_8').hide();
			$('#loan_product_9').hide();
			$('#loan_product_10').show();
			$('#loan_product_11').show();
			$('#loan_product_12').show();
			$('#loan_product_13').hide();
			$('#loan_product_14').show();
			$('#loan_product_15').hide();
			$('#loan_product_16').hide();
			$('#loan_product_17').hide();
		} else if (check_type_loan_update == "Cho vay" && check_type_property_update == "5db7e6b4d6612b173e0728a4") {

			$('#loan_product_1').show();
			$('#loan_product_2').show();
			$('#loan_product_3').show();
			$('#loan_product_4').hide();
			$('#loan_product_5').hide();
			$('#loan_product_6').hide();
			$('#loan_product_7').hide();
			$('#loan_product_8').hide();
			$('#loan_product_9').hide();
			$('#loan_product_10').show();
			$('#loan_product_11').show();
			$('#loan_product_12').show();
			$('#loan_product_13').hide();
			$('#loan_product_14').show();
			$('#loan_product_15').hide();
			$('#loan_product_16').hide();
			$('#loan_product_17').hide();
		} else if (check_type_loan_update == "Cầm cố" && check_type_property_update == "5db7e6bfd6612bceec515b76") {

			$('#loan_product_1').hide();
			$('#loan_product_2').hide();
			$('#loan_product_3').hide();
			$('#loan_product_4').hide();
			$('#loan_product_5').show();
			$('#loan_product_6').hide();
			$('#loan_product_7').hide();
			$('#loan_product_8').hide();
			$('#loan_product_9').hide();
			$('#loan_product_10').hide();
			$('#loan_product_11').hide();
			$('#loan_product_12').hide();
			$('#loan_product_13').hide();
			$('#loan_product_14').show();
			$('#loan_product_15').hide();
			$('#loan_product_16').hide();
			$('#loan_product_17').hide();
		} else if (check_type_loan_update == "Cầm cố" && check_type_property_update == "5db7e6b4d6612b173e0728a4") {

			$('#loan_product_1').hide();
			$('#loan_product_2').hide();
			$('#loan_product_3').hide();
			$('#loan_product_4').show();
			$('#loan_product_5').hide();
			$('#loan_product_6').hide();
			$('#loan_product_7').hide();
			$('#loan_product_8').hide();
			$('#loan_product_9').hide();
			$('#loan_product_10').hide();
			$('#loan_product_11').hide();
			$('#loan_product_12').hide();
			$('#loan_product_13').hide();
			$('#loan_product_14').show();
			$('#loan_product_15').hide();
			$('#loan_product_16').hide();
			$('#loan_product_17').hide();
		} else if (check_type_loan_update == "Tín chấp") {

			$('#loan_product_1').hide();
			$('#loan_product_2').hide();
			$('#loan_product_3').hide();
			$('#loan_product_4').hide();
			$('#loan_product_5').hide();
			$('#loan_product_6').hide();
			$('#loan_product_7').hide();
			$('#loan_product_8').show();
			$('#loan_product_9').show();
			$('#loan_product_10').hide();
			$('#loan_product_11').hide();
			$('#loan_product_12').hide();
			$('#loan_product_13').hide();
			$('#loan_product_14').show();
			$('#loan_product_15').show();
			$('#loan_product_16').hide();
			$('#loan_product_17').hide();
		} else {
			$('#loan_product_1').hide();
			$('#loan_product_2').hide();
			$('#loan_product_3').hide();
			$('#loan_product_4').hide();
			$('#loan_product_5').hide();
			$('#loan_product_6').hide();
			$('#loan_product_7').hide();
			$('#loan_product_8').hide();
			$('#loan_product_9').hide();
			$('#loan_product_10').hide();
			$('#loan_product_11').hide();
			$('#loan_product_12').hide();
			$('#loan_product_13').hide();
			$('#loan_product_14').hide();
			$('#loan_product_15').hide();
			$('#loan_product_16').hide();
			$('#loan_product_17').hide();
		}

		$("#type_property option[value=" + '5f213c10d6612b465f4cb7b6' + "]").hide();


		var loan_product_update = $("#loan_product").val();
		if (loan_product_update == 14) {
			$('#kdol_v').show();
		}
	});


	$('#selectize_property_by_main').selectize({
		create: false,
		valueField: 'id',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		},
		onChange: function (value) {
			var formData = {
				id: value,
				code_type_property: $("#type_property :selected").data("code"),
				type_loan: $("#type_loan :selected").data("code"),
			};
			console.log("xxxx")
			$.ajax({
				url: _url.base_url + '/Ajax/getDepreciationByProperty',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$("#loading").show();
				},
				success: function (data) {
					console.log(data)
					if (data.res) {
						$('.depreciation_by_property').children().remove();
						let html = "";
						let content = data.data;
						let code_type_property = $("#type_property :selected").data("code");
						for (var i = 0; i < content.length; i++) {
							if (code_type_property == 'XM') {
								html += "<label><input  onchange='appraise_property_XM(this)' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "'  name='price_depreciation' type='radio' value='" + content[i].price + "' >" + content[i].name + "</label></br>"
							} else if (code_type_property == 'OTO') {
								html += "<label><input  onchange='appraise_property(this)' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "'  name='price_depreciation' type='checkbox' value='" + content[i].price + "' >" + content[i].name + "</label></br>"
							}
						}

						$("input[name='price_property']").val(numeral(data.price_property).format('0,0'));

						$("input[name='price_goc']").val(data.price_property);
						var percent_formality = data.percent;
						$("#percent_type_loan").val(data.percent);
						// var percent_formality = $(".formality").val();
						var price_property = $("input[name='price_property']").val().replace(/,/g, "");
						var price = parseInt(price_property) * parseInt(percent_formality) / 100;
						$("input[name='amount_money']").val(numeral(price).format('0,0'));


						$(".depreciation_by_property").append(html);
					} else {

						$("input[name='price_property']").val(numeral(data.price_property).format('0,0'));
						$("input[name='price_goc']").val(data.price_property);
						// var percent_formality = $(".formality").val();
						var percent_formality = data.percent;
						$("#percent_type_loan").val(data.percent);
						var price_property = $("input[name='price_property']").val().replace(/,/g, "");

						var price = parseInt(price_property) * parseInt(percent_formality) / 100;
						var loan_product_check = $('#loan_product').val();

						if (loan_product_check == 14) {
							console.log(13);
							var price1 = price_property * 0.8;
							$("input[name='amount_money']").val(numeral(price1).format('0,0'));
						} else {
							$("input[name='amount_money']").val(numeral(price).format('0,0'));
							$('.depreciation_by_property').children().remove();
						}

					}

				},
				error: function (data) {
				}
			});
		}


	});

	function get_property_by_main_contract(thiz) {

		var id = $(thiz).val();
		var code = $("#type_property :selected").data("code")
		if (code == "OTO") {
			$('select[name="gic_easy"]').val("0");
			$('select[name="gic_easy"]').prop('disabled', true);
			$('#fee_gic_easy').val(0);
			$('#phi_tnds').val(0);
		} else {
			$('select[name="gic_easy"]').prop('disabled', false);
		}
		var formData = {
			id: id
		};
		if (code != "NĐ") {
			$.ajax({
				url: _url.base_url + '/Ajax/getPopertyByMain',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$("#loading").show();
				},
				success: function (data) {
					if (data.res) {
						var selectClass = $('#selectize_property_by_main').selectize();
						var selectizeClass = selectClass[0].selectize;
						selectizeClass.clear();
						selectizeClass.clearOptions();
						selectizeClass.load(function (callback) {
							callback(data.data);
						});
						$('.properties').children().remove();
						$('.properties_b').children().remove();
						let html = "";
						let html_b = "";
						let content = data.properties;
						console.log(content);
						// for (var i = 0; i < content.length; i++) {
						// 	if (content[i].slug == "ngay-cap") {
						// 		html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='date' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						// 	} else if (content[i].slug == "so-dang-ky") {
						// 		html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='6' type='text' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						// 	} else {
						// 		html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='text' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						// 	}
						// }

						for (var i = 0; i < content.length; i++) {
							html += "<th scope='col' style='text-align: center'>" + content[i].name + "<span class='text-danger'>*</span></th>"
						}

						for (var i = 0; i < content.length; i++) {
							if (content[i].slug == "ngay-cap") {
								html_b += "<td class='error_messages' ><input type='date' name='property_infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' style='width:100%;border:0' placeholder='...' ><p class='messages'></p></td>"
							} else if (content[i].slug == "so-dang-ky") {
								html_b += "<td class='error_messages'><input maxlength='6' type='text' name='property_infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' style='width:100%;border:0' placeholder='...' ><p class='messages'></td>"
							} else {
								html_b += "<td class='error_messages'><input type='text' name='property_infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' style='width:100%;border:0' placeholder='...' ><p class='messages'></td>"
							}
						}


						$(".properties").append(html);
						$(".properties_b").append(html_b);
						$("input[data-slug='so-dang-ky']").keyup(function (event) {
							// skip for arrow keys
							if (event.which >= 37 && event.which <= 40) return;
							// format number
							$(this).val(function (index, value) {
								return value
										.replace(/\D/g, "");
							});
						});


					} else {
						$('#errorModal').modal('show');
						$('.msg_error').text(data.message);
					}
				},
				error: function (data) {
					console.log(data);
					$("#loading").hide();
				}
			});
		} else {
			get_property_main_state();
		}
		get_coupon();

	};

	function percent_formality(thiz) {
		var percent_formality = $(thiz).val();
		// var code = $(thiz).attr('data-code');
		var code = $(thiz).find(":selected").attr('data-code');

		var code_type_property = $("#type_property :selected").data("code");
		var formData = {
			type_loan: code,
			code_type_property: code_type_property
		};
		console.log(formData);
		$.ajax({
			url: _url.base_url + '/Ajax/getPercentFormality',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				console.log(data);
				if (data.res) {

					var price_property = $("input[name='price_property']").val().replace(/,/g, "");
					var price = parseInt(price_property) * parseInt(percent_formality) / 100;
					$("input[name='amount_money']").val(numeral(price).format('0,0'));
					var percent_formality = data.percent;
					$("#percent_type_loan").val(data.percent);
					var price_property = $("input[name='price_property']").val().replace(/,/g, "");
					var price = parseInt(price_property) * parseInt(percent_formality) / 100;
					$("input[name='amount_money']").val(numeral(price).format('0,0'));
				}
			},
			error: function (data) {
			}
		});
		get_coupon();

	}

	function get_coupon() {
		remove_old_data('#code_coupon');
		var type_loan = $('#type_loan  :selected').data('id');
		var type_property = $('#type_property :selected').val();
		var number_day_loan = $('#number_day_loan :selected').val();
		var created_at = $('#created_at').val();
		var formData = {
			type_loan: type_loan,
			type_property: type_property,
			number_day_loan: number_day_loan,
			created_at: created_at,

		};
		$.ajax({
			url: _url.base_url + '/coupon/getCoupon',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (result) {

				if (result.res) {
					// console.log(result.data[0].code);
					check_drop_box_all(result.data, 'code_coupon', 'Chọn coupon');
				} else {

				}
			},
			error: function (data) {
			}
		});
	}

	function remove_old_data(oid) {
		$(oid + ' option').remove();
	}

	function check_drop_box_all(check = null, type, text) {
		$('#' + type).append('<option value=""  selected>-- Chọn coupon --</option>');
		if (check != null && check != 0) {

			for (var key in check) {
				$('#' + type).append('<option value="' + check[key].code + '" >' + check[key].code + '</option>');
			}
		} else {

		}
	}

	var array = [];
	var count = [];
	$('#loan_product').change(function (event) {
		event.preventDefault();
		var check_loan_product = $("#loan_product").val();
		array.push(check_loan_product);
		var price_property_asset = getFloat($('#price_property').val());

		get_property_main_state();
		if (check_loan_product == 14) {
			$('#kdol_v').show();
			var result_total = price_property_asset * 0.8;
			console.log(result_total)
			$("input[name='amount_money']").val(numeral(result_total).format('0,0'));
		}
		if (check_loan_product != 14) {
			$('#kdol_v').hide();
			$('#loan_purpose').val('Tiêu dùng cá nhân');
		}

		if (array.indexOf("14") == 0 && array.length == 2) {
			var percent_type_loan = $("#percent_type_loan").val();
			var price_property = getFloat($("input[name='price_property']").val().replace(/,/g, ""));
			var result_total_1 = parseInt(price_property) * parseInt(percent_type_loan) / 100;

			$("input[name='amount_money']").val(numeral(result_total_1).format('0,0'));
		}

		if (array[1] == 14) {
			count.push(2)
		} else {
			count.push(1);
		}


		if (count[count.length - 2] == 2 && array.length == 1) {

			var percent_type_loan = $("#percent_type_loan").val();
			var price_property = getFloat($("input[name='price_property']").val().replace(/,/g, ""));
			var result_total_2 = parseInt(price_property) * parseInt(percent_type_loan) / 100;

			$("input[name='amount_money']").val(numeral(result_total_2).format('0,0'));
		}

		if (array.length == 2) {
			array.splice(0, 2);
		}

		var check_type_loan_change = $('#type_loan').val();
		var check_type_property_change = $('#type_property').val();
		console.log(check_type_loan_change);
		console.log(check_type_property_change);
		if (check_loan_product == 14 && check_type_loan_change == "Cho vay" && check_type_property_change == "5db7e6b4d6612b173e0728a4") {
			$('#type_interest_motobike').show();
			$('#number_day_loan_motobike').show();
		}

		if (check_loan_product != 14 && check_type_loan_change == "Cho vay" && check_type_property_change == "5db7e6b4d6612b173e0728a4") {
			$('#type_interest_motobike').hide();
			$('#number_day_loan_motobike').hide();
			$('#type_interest').val(1);
		}
	});

	function get_property_main_state() {
		let id = $('#type_property').val();
		let loan = $('#loan_product').val();
		$(".properties").html("");
		$(".properties_b").html("");

		if (loan == 16 || loan == 17) {
			console.log(loan);
			var formData = {
				id: id
			};
			$.ajax({
				url: _url.base_url + '/Ajax/getPopertyByMain',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$("#loading").show();
				},
				success: function (data) {
					if (data.res) {
						console.log("data.data", data.data);
						var dataEstase = data.data.filter(item => {
							if (loan == 16 && item.id == '606aeb668ab0574cd95f5353') {
								return true;
							} else if (loan == 17 && item.id == '606aebb1cee2903a15760523') {
								return true;
							}
							return false;
						})
						console.log("dataEstase", dataEstase);

						var selectClass = $('#selectize_property_by_main').selectize();
						var selectizeClass = selectClass[0].selectize;
						selectizeClass.clear();
						selectizeClass.clearOptions();
						selectizeClass.load(function (callback) {
							callback(dataEstase);
						});
						let html = "";
						let html_b = "";
						let content = data.properties;
						console.log(content);

						for (var i = 0; i < content.length; i++) {
							html += "<th scope='col' style='text-align: center'>" + content[i].name + "<span class='text-danger'>*</span></th>"
						}

						for (var i = 0; i < content.length; i++) {
							if (content[i].slug == 'dien-tich-m2' || content[i].slug == 'thoi-han-su-dung-nam') {
								html_b += "<td class='error_messages'><input type='text' name='property_infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' style='width:100%;border:0' placeholder='...' onkeypress='return isNumber(event)' ><p class='messages'></td>"
							} else if (content[i].slug == "ngay-cap") {
								html_b += "<td class='error_messages' ><input type='date' name='property_infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' style='width:100%;border:0' placeholder='...' ><p class='messages'></p></td>"
							} else if (content[i].slug == "so-dang-ky") {
								html_b += "<td class='error_messages'><input maxlength='6' type='text' name='property_infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' style='width:100%;border:0' placeholder='...' ><p class='messages'></td>"
							} else {
								html_b += "<td class='error_messages'><input type='text' name='property_infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' style='width:100%;border:0' placeholder='...' ><p class='messages'></td>"
							}
						}

						$(".properties").append(html);
						$(".properties_b").append(html_b);
						$("input[data-slug='so-dang-ky']").keyup(function (event) {
							// skip for arrow keys
							if (event.which >= 37 && event.which <= 40) return;
							// format number
							$(this).val(function (index, value) {
								return value
										.replace(/\D/g, "");
							});
						});

					} else {
						$('#errorModal').modal('show');
						$('.msg_error').text(data.message);
					}
				},
				error: function (data) {
					console.log(data);
					$("#loading").hide();
				}
			});
		}
	}

	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

</script>
