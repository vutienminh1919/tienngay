$('#type_loan').change(function() {
	
	if($('#type_loan  :selected').data('code') =='CC')
	{
    $('#number_day_loan option[value=1]').attr('selected','selected');
     $('#number_day_loan').prop('disabled', true);
     $("select[name='hinh_thuc_tra_lai'] option[value=2]").attr('selected','selected');
     $("select[name='hinh_thuc_tra_lai']").prop('disabled', true);
    }else{
    	$('#number_day_loan').prop('disabled', false);
        $("select[name='hinh_thuc_tra_lai']").prop('disabled', false);
    }
	var check_type_loan = $('#type_loan').val();
	var check_type_property = $('#type_property').val();

	if (check_type_property == "5f213c10d6612b465f4cb7b6") {

		$('#type_property').val('');
		typePropertyChangeAction();
	}

	if (check_type_property == "606aceb461a5d8511f0c4d33") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6bfd6612bceec515b76") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6b4d6612b173e0728a4") {
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
		$('#loan_product_18').show();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log("testttt");
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6bfd6612bceec515b76") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6b4d6612b173e0728a4") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Tín chấp") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	}

	if (check_type_loan == "Tín chấp") {
		//5fd8170905390000c50077e9 - Tín chấp local
		//5f213c10d6612b465f4cb7b6 - Tín chấp live
		$("#type_property").val("5f213c10d6612b465f4cb7b6");

		function get_property_by_main_contract() {
			var id = "5f213c10d6612b465f4cb7b6"
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
			console.log(3);
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
						let html = "";
						let content = data.properties;
						// console.log(content);
						for (var i = 0; i < content.length; i++) {
							if (content[i].slug == "ngay-cap") {
								html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='date' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
							} else if (content[i].slug == "so-dang-ky") {
								html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='6' type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
							} else {
								html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
							}
						}
						$(".properties").append(html);
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
		var check_type_property_1 = $("#type_property").val();
		if (check_loan_product_1 == 14 ) {
			var price_property_asset_1 = $("#price_property").val() !== undefined ? getFloat($("#price_property").val()) : 0;
			var result_total_4 = price_property_asset_1 * 0.8;
			if (check_type_property_1 == "5db7e6bfd6612bceec515b76"){
				result_total_4 = price_property_asset_1 * 0.6;
			}
			if (check_type_property_1 == "5f213c10d6612b465f4cb7b6"){
				result_total_4 = price_property_asset_1 ;
			}
			$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
		}
		if (check_loan_product_1 == 18 || check_loan_product_1 == 3) {
			var price_property_asset_1 = $("#price_property").val() !== undefined ? getFloat($("#price_property").val()) : 0;
			var result_total_4 = price_property_asset_1 * 0.5;
			$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
		}


	}
});
$('#type_property').change(function() {
    
    if($('#type_loan  :selected').data('code') =='CC')
    {
    $('#number_day_loan option[value="1"]').attr('selected','selected');
     $('#number_day_loan').prop('disabled', true);
     $("select[name='hinh_thuc_tra_lai'] option[value=2]").attr('selected','selected');
     $("select[name='hinh_thuc_tra_lai']").prop('disabled', true);
    }else{
        $('#number_day_loan').prop('disabled', false);
        $("select[name='hinh_thuc_tra_lai']").prop('disabled', false);
    }
	var check_type_loan = $('#type_loan').val();
	var check_type_property = $('#type_property').val();

	if (check_type_property == "5f213c10d6612b465f4cb7b6") {

		$('#type_property').val('');
		typePropertyChangeAction();
	}

	if (check_type_property == "606aceb461a5d8511f0c4d33") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6bfd6612bceec515b76") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6b4d6612b173e0728a4") {
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
		$('#loan_product_18').show();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log("testttt");
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6bfd6612bceec515b76") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6b4d6612b173e0728a4") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Tín chấp") {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else {
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
		$('#loan_product_18').hide();
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	}

	if (check_type_loan == "Tín chấp") {
		//5fd8170905390000c50077e9 - Tín chấp local
		//5f213c10d6612b465f4cb7b6 - Tín chấp live
		$("#type_property").val("5f213c10d6612b465f4cb7b6");

		function get_property_by_main_contract() {
			var id = "5f213c10d6612b465f4cb7b6"
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
			console.log(3);
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
						let html = "";
						let content = data.properties;
						// console.log(content);
						for (var i = 0; i < content.length; i++) {
							if (content[i].slug == "ngay-cap") {
								html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='date' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
							} else if (content[i].slug == "so-dang-ky") {
								html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='6' type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
							} else {
								html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
							}
						}
						$(".properties").append(html);
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
		var check_type_property_1 = $("#type_property").val();
		if (check_loan_product_1 == 14 ) {
			var price_property_asset_1 = $("#price_property").val() !== undefined ? getFloat($("#price_property").val()) : 0;
			var result_total_4 = price_property_asset_1 * 0.8;
			if (check_type_property_1 == "5db7e6bfd6612bceec515b76"){
				result_total_4 = price_property_asset_1 * 0.6;
			}
			if (check_type_property_1 == "5f213c10d6612b465f4cb7b6"){
				result_total_4 = price_property_asset_1 ;
			}
			$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
		}
		if (check_loan_product_1 == 18 || check_loan_product_1 == 3) {
			var price_property_asset_1 = $("#price_property").val() !== undefined ? getFloat($("#price_property").val()) : 0;
			var result_total_4 = price_property_asset_1 * 0.5;

			$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
		}
	}
});
$("select[name='hinh_thuc_phi']").change(function() {
	if($(this).val()=='bpc')
	{
     $("#form_coupon").css("display","none");
     $("#form_other").css("display","none");
	}else if($(this).val()=='coupon')
	{
		$("#form_coupon").css("display","block");
		$("#form_other").css("display","none");
		$("#stores").val("5ecb73a7d6612b80a62d6f1a").change();

	}else if($(this).val()=='other')
	{
		$("#form_coupon").css("display","none");
		$("#form_other").css("display","block");
		
	}else {
		$("#form_coupon").css("display","none");
		$("#form_other").css("display","none");
	}


	});
function getFloat(val) {
    var val = val.replace(/,/g,"");
    return parseFloat(val);
}
$(".clear").on("click", function() {
    location.reload();
       $('#fetch_results:input', $(this)).each(function(index) {
      this.value = "";
    });
});
$(".caculator_loan").on("click", function() {
    var type_loan =  $("#type_loan :selected").data("code");
    var type_property =  $("#type_property :selected").data("code");
    var amount_money = $("#money").val() !== undefined ? getFloat($("#money").val()) : 0;
    var ky_han =  $("#number_day_loan :selected").val();
    var hinh_thuc_tra_lai =  $("select[name='hinh_thuc_tra_lai'] :selected").val();
    var hinh_thuc_phi =  $("select[name='hinh_thuc_phi'] :selected").val();
    var ngay_giai_ngan =  $("input[name='date']").val();
    var coupon =  $("#code_coupon").val();
    var ngay_tat_toan =  $("input[name='ngay_tat_toan']").val();
    var management_consulting_fee =  $("input[name='management_consulting_fee']").val() !== undefined ? $("input[name='management_consulting_fee']").val() : 0;
    var renewal_fee =  $("input[name='renewal_fee']").val() !== undefined ?  $("input[name='renewal_fee']").val() : 0;
    var loan_interest =  $("input[name='loan_interest']").val() !== undefined ?  $("input[name='loan_interest']").val() : 0;
   var loan_product =  $("#loan_product").val();
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
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            setTimeout(function(){ 
                $(".theloading").hide();
            }, 1000);
            if (data.code == 200) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                $('#tb_caculator tbody').empty();
               $('#tb_caculator tbody').append(data.data);
                setTimeout(function(){ 
                     $("#successModal").modal("hide");
                }, 3000);
              
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
                setTimeout(function(){ 
                     $("#successModal").modal("hide");
                }, 3000);
            }
        },
        error: function(error) {
            setTimeout(function(){ 
                $(".theloading").hide();
            }, 1000);
        }
    })
});

var array = [];
var count = [];
$('#loan_product').change(function (event) {
	event.preventDefault();
	var check_loan_product = $("#loan_product").val();
	array.push(check_loan_product);
	var price_property_asset = $("#price_property").val() !== undefined ? getFloat($("#price_property").val()) : 0;
	//5db7e6b4d6612b173e0728a4 - Xe Máy
	//5db7e6bfd6612bceec515b76 - Ô tô
	//5f213c10d6612b465f4cb7b6 - Tín chấp
	var check_type_property_new = $("#type_property").val();
	if (check_loan_product == 14) {
		$('#kdol_v').show();
		$('#show_hide_linkShop').show();
		var result_total = price_property_asset * 0.8;
		if (check_type_property_new == "5db7e6bfd6612bceec515b76"){
			result_total = price_property_asset * 0.6;
		}
		if (check_type_property_new == "5f213c10d6612b465f4cb7b6"){
			result_total = price_property_asset ;
		}

		$("input[name='amount_money']").val(numeral(result_total).format('0,0'));
		if (check_type_property_new == "5f213c10d6612b465f4cb7b6"){
			$("#type_interest_motobike").hide();
			$("#type_interest").val(1)
		} else {
			$("#type_interest_motobike").show();
		}
	} else {
		$('#show_hide_linkShop').hide();
		$('#link_shop').val("");
		var selectClass = $('#selectize_property_by_main').selectize();
		var selectizeClass = selectClass[0].selectize;
		selectizeClass.clear();
		var check_id = $('#type_property').val();

		var id = check_id;
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
		console.log(3);
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
					let html = "";
					let content = data.properties;
					// console.log(content);
					for (var i = 0; i < content.length; i++) {
						if (content[i].slug == "ngay-cap") {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='date' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						} else if (content[i].slug == "so-dang-ky") {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='6' type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						} else {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						}
					}
					$(".properties").append(html);
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
	if (check_loan_product == 18 || check_loan_product == 3) {
		$("#type_interest_motobike").hide();
		$("#type_interest").val(1);

		var result_total = price_property_asset * 0.5;
		$("input[name='amount_money']").val(numeral(result_total).format('0,0'));
	} else {
		$("#type_interest_motobike").show();
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

$('#code_area').change(function() {

	
	
	
	var code_area = $('#code_area :selected').val();
	
	var formData = {
		code_area: code_area,
	};
	$.ajax({
		url: _url.base_url + '/store/getStore_by_code_area',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (result) {

			if (result.res) {
				$("#stores option:selected").remove();

				
                  check_drop_box_store(result.data, 'stores', '');
				get_coupon();
				
			} else {

			}
		},
		error: function (data) {
		}
	})
});

function check_drop_box_store(check = null, type, text) {
	
	if (check != null && check != 0) {
   
		for (var key in check) {
			if(key==0)
			{
				$('#' + type+" option").remove();
				$('#' + type).append('<option selected value="' + check[key].id + '" >' + check[key].name + '</option>');
				
			}else{
               $('#' + type).append('<option  value="' + check[key].id + '" >' + check[key].name + '</option>');
			}
			
		}
	} 
}

