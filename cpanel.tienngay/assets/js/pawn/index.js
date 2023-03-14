$(document).ready(function () {

	$('#insurrance').change(function () {
		if (this.checked) {

			if ($('[name="loan_insurance"]').val() == '1') {
				$('#fee_gic').val(fee_gic());
			}
			if ($('[name="loan_insurance"]').val() == '2') {
				$('#fee_gic').val(fee_gic());
			}
		} else {

			$('#fee_gic').val(0);
			$('[name="loan_insurance"]').val(0);
		}
	});
	$('[name="gic_plt"]').change(function () {


		$('#fee_gic_plt').val(numeral($(this).val()).format('0,0'));
		$('#is_free_gic_plt').prop('checked', false);


	});
	$('[name="code_pti_vta"]').change(function () {
		$('#price_pti_vta').val(fee_pti_vta());
	});
	$('[name="year_pti_vta"]').change(function () {
		$('#price_pti_vta').val(fee_pti_vta());
	});
	$("#is_free_gic_plt").change(function () {
		if (this.checked) {

			$('#fee_gic_plt').val(0);

		} else {

			$('#fee_gic_plt').val(numeral($('[name="gic_plt"]').val()).format('0,0'));

		}
	});
	$('[name="loan_insurance"]').change(function () {
		var optionSelected = $(this).find("option:selected");
		var valueSelected = optionSelected.val();

		if ($('#insurrance').prop("checked") == true) {
			if ($('[name="loan_insurance"]').val() == '1') {
				$('#fee_gic').val(fee_gic());
			}
			if ($('[name="loan_insurance"]').val() == '2') {
				$('#fee_gic').val(fee_gic());

			}
		} else {
			//     console.log('xxxx');
			$('#fee_gic').val(0);
			$('[name="loan_insurance"]').val(0);
		}

	});


});
$("#number_day_loan").change(function () {

	if ($('#insurrance').prop("checked") == true) {
		if ($('[name="loan_insurance"]').val() == '1') {
			$('#fee_gic').val(fee_gic());
		}
		if ($('[name="loan_insurance"]').val() == '2') {
			$('#fee_gic').val(fee_gic());
		}
	} else {
		//     console.log('xxxx');
		$('#fee_gic').val(0);
		$('[name="loan_insurance"]').val(0);
	}

});


$(document).ready(function () {
	$("#type_loan").change(function () {
		var type_loan = $('#type_loan').val();
		if (type_loan == "Cầm cố") {
			$("#car_storage").show();
			$("#giu_xe").show();
		}
		if (type_loan == "Cho vay") {
			$("#car_storage").hide();
			$("#car_storage").val("");
			$("#giu_xe").hide();
		}
		$('#fee_gic').val(fee_gic());
	})

});

$(document).ready(function () {
	$("#type_property").change(function () {
		var type_property = $('#type_property').val();
		var user_nextpay = $('#user_nextpay').val();
		console.log(user_nextpay)
		if (type_property == "5db7e6b4d6612b173e0728a4") {
			if (user_nextpay == 1) {
				$('#number_day_loan_motobike').show();
				$("#number_day_loan option[value=" + 3 + "]").show();
			} else {
				$('#number_day_loan_motobike').hide();
				$("#number_day_loan option[value=" + 3 + "]").hide();
			}

			if ($('#type_loan  :selected').data('code') != "CC") {
				$("#number_day_loan").val('3');
			}
			$('#type_interest').val('1');

		}
		if (type_property == "5db7e6bfd6612bceec515b76") {
			$('#number_day_loan_motobike').show();
			$("#number_day_loan option[value=" + 3 + "]").show();

		}


	});

	$("#type_property").change(function () {
		var type_property = $('#type_property').val();
		var user_nextpay = $('#user_nextpay').val();
		if (type_property == "5db7e6b4d6612b173e0728a4") {
			if (user_nextpay == 1) {
				$('#number_day_loan_motobike').show();
				$("#number_day_loan option[value=" + 3 + "]").show();
			} else {
				$('#number_day_loan_motobike').hide();
				$("#number_day_loan option[value=" + 3 + "]").hide();
			}
			if ($('#type_loan  :selected').data('code') != "CC") {
				$("#number_day_loan").val('3');
			}
			$('#type_interest').val('1');
		}
		if (type_property == "5db7e6bfd6612bceec515b76") {
			$('#type_interest_motobike').show();

		}
		if (type_property == "606aceb461a5d8511f0c4d33"){
			$('#loan_product_19').hide();
		} else {
			$('#loan_product_19').show();
		}

	});

	var type_loan_check_up = $('#type_loan').val();
	var type_property_check_up = $('#type_property').val();
	if (type_loan_check_up != "Cho vay" && type_property_check_up != "5db7e6b4d6612b173e0728a4") {
		$('#number_day_loan_motobike').show();
		$("#number_day_loan option[value=" + 3 + "]").show();
	}


});

$(document).ready(function () {
	var user_nextpay = $('#user_nextpay').val();
	$("#type_loan").change(function () {
		var type_loan = $('#type_loan').val();

		if (type_loan == "Cầm cố") {
			$("#number_day_loan").val('1');
			$("#type_interest").val('1');

			$(".tra_lai").hide();
			$(".thoi_gian_vay").hide();
			$('#fee_gic').val(fee_gic());
		}
		if (type_loan == "Cho vay") {
			$(".tra_lai").show();
			$(".thoi_gian_vay").show();
			if (type_property == '5db7e6b4d6612b173e0728a4') {
				if (user_nextpay == 1) {
					$('#number_day_loan_motobike').show();
					$("#number_day_loan option[value=" + 3 + "]").show();
				} else {
					$('#number_day_loan_motobike').hide();
					$("#number_day_loan option[value=" + 3 + "]").hide();
				}
			}
			if ($('#type_loan  :selected').data('code') != "CC") {
				$("#number_day_loan").val('3');
			}
			$('#fee_gic').val(fee_gic());
		}

	})


});


function remove_old_data(oid) {
	$(oid + ' option').remove();
}

$("#number_day_loan").change(function () {
	get_coupon();
});
$("#number_day_loan1").change(function () {
	get_coupon();
});
$("#stores").change(function () {
	get_coupon();
});
$('#loan_product').change(function (event) {
	get_coupon();
	get_property_main_state();
});

function get_property_main_state() {
	let id = $('#type_property').val();
	let loan = $('#loan_product').val();
	console.log(loan);
	var formData = {
		id: id
	};
	if (loan == 16 || loan == 17) {
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
					var dataEstase = data.data.filter(item => {
						if (loan == 16 && item.id == '606aeb668ab0574cd95f5353') {
							return true;
						} else if (loan == 17 && item.id == '606aebb1cee2903a15760523') {
							return true;
						}
						return false;
					})
					console.log(dataEstase);

					var selectClass = $('#selectize_property_by_main').selectize();
					var selectizeClass = selectClass[0].selectize;
					selectizeClass.clear();
					selectizeClass.clearOptions();
					selectizeClass.load(function (callback) {
						callback(dataEstase);
					});
					$('.properties').children().remove();
					let html = "";
					let content = data.properties;
					// console.log(content);
					for (var i = 0; i < content.length; i++) {
						if (content[i].slug == 'thua-dat-so' || content[i].slug == 'dien-tich-m2' || content[i].slug == 'hinh-thuc-su-dung-rieng-m2' || content[i].slug == 'hinh-thuc-su-dung-chung-m2' || content[i].slug == 'thoi-han-su-dung') {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input onkeypress='return isNumber(event)' type='text' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						} else if (content[i].slug == "ngay-cap") {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='date' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						} else if (content[i].slug == "so-dang-ky") {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='7' type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
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
}

function get_coupon() {
	$("#code_coupon option").remove();
	var type_loan = $('#type_loan  :selected').data('id');
	var loan_product = $('#loan_product  :selected').val();
	var type_property = $('#type_property :selected').val();
	var number_day_loan = $('#number_day_loan :selected').val();
	var store_id = $('#stores :selected').val();
	var created_at = $('#created_at').val();
	var formData = {
		type_loan: type_loan,
		loan_product: loan_product,
		type_property: type_property,
		number_day_loan: number_day_loan,
		created_at: created_at,
		store_id: store_id,

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
				$("#code_coupon option").remove();
				if (loan_product == '16' || loan_product == '17' || loan_product == '5') {
					check_drop_box_all(result.data, 'code_coupon', 'bochon');
				} else {
					check_drop_box_all(result.data, 'code_coupon', '');
				}

			} else {

			}
		},
		error: function (data) {
		}
	});
}

function check_drop_box_all(check = null, type, text) {
	if (text == "") {
		$('#' + type).append($('<option>', {value: '', text: '- Chọn coupon -'}));
	}
	if (check != null && check != 0) {
		$.each(check, function (k, v) {
			$('#' + type).append($('<option>', {value: v.code, text: v.code}));
		})
	} else {

	}
}

$('#checkContract').on('hidden.bs.modal', function (e) {
	// do something...

	$('input[name="check_phone"]').prop('checked', false);
	$('input[name="check_customer_identify"]').prop('checked', false);
	$('input[name="phone_number_relative_1"]').prop('checked', false);
	$('input[name="phone_number_relative_2"]').prop('checked', false);
})

$('input[name="phone_number_relative_2"]').click(function () {
	var phone_number_relative_2 = $("#phone_number_relative_2").val();
	if ($(this).prop("checked") == true && phone_number_relative_2.length > 0) {
		var formData = {
			phone_number_relative_2: phone_number_relative_2
		};
		$.ajax({
			url: _url.base_url + '/Ajax/checkContract',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {

				if (data.res) {
					$("#checkContract").modal('show');
					$('#list_contract_check').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						let status = "không xác định";
						status = get_status(content[i].status);

						let key = i + 1;
						html += "<tr><td>" + key + "</td>";
						html += "<td>" + content[i].code_contract_disbursement + "</td>"
						html += "<td><a href='" + _url.base_url + "pawn/detail?id=" + content[i]._id.$oid + "'>" + content[i].store.name + "</a></td>"
						html += "<td>" + status + "</td>"
						html += "</tr>";
					}
					$("#list_contract_check").append(html);
				} else {
					$("#checkContractFalse").modal('show');
				}
			},
			error: function (data) {
			}
		});
	}
});

$('input[name="phone_number_relative_1"]').click(function () {
	var phone_number_relative_1 = $("#phone_number_relative_1").val();
	if ($(this).prop("checked") == true && phone_number_relative_1.length > 0) {
		var formData = {
			phone_number_relative_1: phone_number_relative_1
		};
		$.ajax({
			url: _url.base_url + '/Ajax/checkContract',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {

				if (data.res) {
					$("#checkContract").modal('show');
					$('#list_contract_check').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						let status = "không xác định";
						status = get_status(content[i].status);
						let key = i + 1;
						html += "<tr><td>" + key + "</td>";
						html += "<td>" + content[i].code_contract_disbursement + "</td>"
						html += "<td><a href='" + _url.base_url + "pawn/detail?id=" + content[i]._id.$oid + "'>" + content[i].store.name + "</a></td>"
						html += "<td>" + status + "</td>"
						html += "</tr>";
					}
					$("#list_contract_check").append(html);
				} else {
					$("#checkContractFalse").modal('show');
				}
			},
			error: function (data) {
			}
		});
	}
});

$('input[name="check_phone"]').click(function () {
	var phone = $("#customer_phone_number").val();
	if ($(this).prop("checked") == true && phone.length > 0) {
		var formData = {
			phone: phone
		};
		$.ajax({
			url: _url.base_url + '/Ajax/checkContract',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				if (data.res) {
					$("#checkContract").modal('show');
					$('#list_contract_check').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						let status = "không xác định";
						status = get_status(content[i].status);
						let key = i + 1;
						html += "<tr><td>" + key + "</td>";
						html += "<td>" + content[i].code_contract_disbursement + "</td>"
						html += "<td><a href='" + _url.base_url + "pawn/detail?id=" + content[i]._id.$oid + "'>" + content[i].store.name + "</a></td>"
						html += "<td>" + status + "</td>"
						html += "</tr>";
					}
					$("#list_contract_check").append(html);
				} else {
					$("#checkContractFalse").modal('show');
				}
			},
			error: function (data) {
			}
		});
	}
});
$('input[name="check_input_identify"]').click(function () {
	$("#Identify_loading").hide();
	$("#checkIdentify").modal('show');

});
$('input[name="check_face_identify"]').click(function () {
	$("#Face_Identify_loading").hide();
	$("#checkFace_identify").modal('show');

});
$('input[name="check_face_search"]').click(function () {
	$("#Face_search_loading").hide();
	$("#checkFace_search").modal('show');

});
var isLoading = false;
var isUploaded = false;
if ($('#imgImg_mattruoc').attr('src') != "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png") {
	isUploaded = true;
}
var imageId;
$(".alert-danger").hide();
$(".alert-success").hide();
$('#imgImg_mattruoc').on('click', function () {
	isUploaded = false;
	$('#input_cmt_search').trigger('click');
	imageId = $(this).attr('id');
});

// check existing in blacklist
$('.identification_Face_search').on('click', function () {
	$('#cvs_customer_info').hide();
	$('.face_identify_results').hide();
	$('#list_info_Face_search').children().remove();
	$('#list_info_Face_search').html("");
	var img_person = $('#imgImg_mattruoc').attr('src');
	if (!isLoading && isUploaded && img_person !== "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png") {
		isLoading = true;
		var formData = {
			img_person: img_person
		};
		$.ajax({
			url: _url.base_url + '/Ajax/get_info_face_search',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#Face_search_loading").show();
			},
			success: function (data) {
				isLoading = false;
				if (data.res) {
					console.log(data.data);
					$("#Face_search_loading").hide();

					$('#list_info_Face_search').children().remove();
					$('#list_info_Face_search').html("");
					let isBlacklist = false;

					if (data.data && Object.entries(data.data).length != 0) {
						isBlacklist = true;
						let html = "<tr><th scope=\"row\">Ảnh</th><th scope=\"row\">Tên</th><th scope=\"row\">Số ĐT</th><th scope=\"row\">Số CMTND</th><th scope=\"row\">Ghi chú</th></tr>";
						for (let i in data.data) {
							html += "<tr>";
							html += "<td> <image style='width: 200px' src='" + data.data[i].url + "'></image> </td>";
							html += "<td>" + JSON.stringify(data.data[i].metadata.name) + "</td>";
							html += "<td>" + JSON.stringify(data.data[i].metadata.phone) + "</td>";
							html += "<td>" + JSON.stringify(data.data[i].metadata.identify) + "</td>";
							html += "<td>" + JSON.stringify(data.data[i].metadata.note) + "</td>";
							html += "</tr>";
						}
						console.log(html);
						// try {   if(data.data.metadata.customer_infor !== undefined ) {
						//    html += "<tr>";
						//    html += "<td>Thông tin</td>";
						//    html += "<td><b id='identify_name'>"+JSON.stringify(data.data.metadata.customer_infor) +"</b></td>";
						//     html += "</tr>";
						//   } } catch (e) {  }
						//    try {   if(data.data.metadata.code_contract !== undefined ) {
						//    html += "<tr>";
						//    html += "<td>Mã phiếu ghi</td>";
						//    html += "<td><b id='identify_id'>"+data.data.metadata.code_contract+"</b></td>";
						//     html += "</tr>";
						//   } } catch (e) {  }
						//      try {   if(data.data.metadata.code_contract == undefined ) {
						//
						//   } } catch (e) { html += "<tr>";
						//    html += "<td>Thông báo: </td>";
						//    html += "<td><b id='identify_id'>Không tìm thấy thông tin</b></td>";
						//     html += "</tr>"; }
						//    try {   if(data.data.metadata.store !== undefined ) {
						//    html += "<tr>";
						//    html += "<td>Phòng giao dịch</td>";
						//    html += "<td><b id='identify_sex'>"+JSON.stringify(data.data.metadata.store)+"</b></td>";
						//     html += "</tr>";
						//   } } catch (e) { }

						$("#list_info_Face_search").append(html);
						$('#nextBtn_Face_search').css('display', 'block');
						sessionStorage.setItem("check_Face_search", "true");
						sessionStorage.setItem("data_Face_search", JSON.stringify(data.data));
					}

					// console.log("isBlacklist: "+isBlacklist);
					if (isBlacklist) {
						$("#isBlacklist").val(1);
						$(".alert-danger").show();
						$(".alert-danger").text("Phát hiện trong blacklist!");
						$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
							$(".alert-danger").slideUp(5000);
						});
						$([document.documentElement, document.body]).animate({
							scrollTop: $("#div_error").offset().top
						}, 500);
					} else {
						$("#isBlacklist").val(0);
						$(".alert-success").show();
						$(".alert-success").text("Không phát hiện trong blacklist!");
						$(".alert-success").fadeTo(2000, 500).slideUp(500, function () {
							$(".alert-success").slideUp(5000);
						});
					}
				} else {
					$("#Face_search_loading").hide();
					$(".alert-danger").text(data.message);
					$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
						$(".alert-danger").slideUp(500);
					});
				}
			},
			error: function (data) {
				isLoading = false;
			}
		});
	} else {
		var msg = isLoading ? "Đang upload ảnh!" : "Chưa upload đủ ảnh!";
		$(".alert-danger").text(msg);
		$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert-danger").slideUp(500);
		});
	}
});

$('.return_Face_search').on('click', function () {
	$("#Face_search_loading").hide();
	$('#list_info_Face_search').children().remove();
	$('#list_info_Face_search').html("");
	$('#imgImg_chandung_search').attr('src', 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png');
	$('#nextBtn_Face_search').css('display', 'none');
});

var id, type;
$(".alert-danger").hide();
$(".apply_info_Identify").hide();

$('#imgImg_matsau').on('click', function () {
	$(".apply_info_Identify").hide();
	$('#imgInp_Identify').trigger('click');
	id = $(this).attr('id');
	type = "CMT";

});
$('.return_Identify').on('click', function () {
	$(".apply_info_Identify").hide();
	$('#list_info_Identify').children().remove();
	$('#list_info_Identify').html("");
	$('#imgImg_mattruoc').attr('src', 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png');
	$('#imgImg_matsau').attr('src', 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png');

});
$('.apply_info_Identify').on('click', function () {
	var gender = ($('#identify_sex').text() == 'nam') ? 'nam' : 'nu';
	$('#customer_name').val($('#identify_name').text());
	$('#customer_identify').val($('#identify_id').text());
	check_radio(gender, ['#has_gender', '#no_gender']);
	$('#customer_BOD').val($('#identify_born').text());

	$('#selectize_province_household').data('selectize').setValue($('#identify_diachi_tinh').val());
	$('#selectize_province_current_address').data('selectize').setValue($('#identify_quequan_tinh').val());

	get_district_by_province($('#identify_diachi_tinh').val(), $('#identify_diachi_huyen').val(), type = 'selectize_district_household');
	get_district_by_province($('#identify_quequan_tinh').val(), $('#identify_quequan_huyen').val(), type = 'selectize_district_current_address');
	$('#selectize_district_household').data('selectize').setValue($('#identify_diachi_huyen').val());
	$('#selectize_district_current_address').data('selectize').setValue($('#identify_quequan_huyen').val());

	setTimeout(function () {
		get_ward_by_district($('#identify_quequan_huyen').val(), $('#identify_quequan_phuong').val(), type = 'selectize_ward_current_address');
		get_ward_by_district($('#identify_diachi_huyen').val(), $('#identify_diachi_phuong').val(), type = 'selectize_ward_household');
		$('#selectize_ward_household').data('selectize').setValue($('#identify_quequan_phuong').val());
		$('#selectize_ward_current_address').data('selectize').setValue($('#identify_diachi_phuong').val());
	}, 3000);
	$("#checkIdentify").modal('hide');

});

function getInfoFromImg() {
	var mattruoc = $('#imgImg_mattruoc').attr('src');
	var matsau = $('#imgImg_matsau').attr('src');
	if (type == undefined) type = "CMT";
	var formData = {
		mattruoc: mattruoc,
		matsau: matsau,
		type: type
	};
	console.log(formData);
	$.ajax({
		url: _url.base_url + '/Ajax/get_info_cvs',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#Identify_loading").show();
		},
		success: function (data) {

			if (data.res) {
				$("#Identify_loading").hide();
				console.log(data.data.mattruoc.data.born);
				$('#list_info_Identify').children().remove();
				$('#list_info_Identify').html("");
				let html = "";
				// console.log(data.data.mattruoc.data);
				try {
					if (data.data.mattruoc.data.name !== 'undefined') {
						html += "<tr>";
						html += "<td>Họ và tên</td>";
						html += "<td><b id='identify_name'>" + data.data.mattruoc.data.name + "</b></td>";
						html += "</tr>";
					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.id !== 'undefined') {
						html += "<tr>";
						html += "<td>Mã CMND</td>";
						html += "<td><b id='identify_id'>" + data.data.mattruoc.data.id + "</b></td>";
						html += "</tr>";
					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.sex !== undefined) {
						html += "<tr>";
						html += "<td>Giới tính</td>";
						html += "<td><b id='identify_sex'>" + data.data.mattruoc.data.sex + "</b></td>";
						html += "</tr>";
					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.born !== undefined) {
						html += "<tr>";
						html += "<td>Ngày sinh</td>";
						html += "<td><b id='identify_born'>" + convert_date(data.data.mattruoc.data.born) + "</b></td>";
						html += "</tr>";
					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.address !== 'undefined') {
						html += "<tr>";
						html += "<td>ĐKHK thường trú</td>";
						html += "<td><b id='identify_address'>" + data.data.mattruoc.data.address + "</b></td>";
						html += "</tr>";
					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.country !== 'undefined') {
						html += "<tr>";
						html += "<td>Quê quán</td>";
						html += "<td><b id='identify_country'>" + data.data.mattruoc.data.country + "</b></td>";
						html += "</tr>";
					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.diachi_phuong !== 'undefined') {
						html += " <input type='hidden' id='identify_diachi_phuong'  value='" + data.data.mattruoc.data.diachi_phuong + "'>";

					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.diachi_huyen !== 'undefined') {
						html += " <input type='hidden' id='identify_diachi_huyen'  value='" + data.data.mattruoc.data.diachi_huyen + "'>";

					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.diachi_tinh !== 'undefined') {
						html += " <input type='hidden' id='identify_diachi_tinh'  value='" + data.data.mattruoc.data.diachi_tinh + "'>";

					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.quequan_phuong !== 'undefined') {
						html += " <input type='hidden' id='identify_quequan_phuong'  value='" + data.data.mattruoc.data.quequan_phuong + "'>";

					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.quequan_huyen !== 'undefined') {
						html += " <input type='hidden' id='identify_quequan_huyen'  value='" + data.data.mattruoc.data.quequan_huyen + "'>";

					}
				} catch (e) {
				}
				try {
					if (data.data.mattruoc.data.quequan_tinh !== 'undefined') {
						html += " <input type='hidden' id='identify_quequan_tinh'  value='" + data.data.mattruoc.data.quequan_tinh + "'>";

					}
				} catch (e) {
				}

				$("#list_info_Identify").append(html);
				$(".apply_info_Identify").show();
			} else {
				$("#Identify_loading").hide();
				$(".alert-danger").text('Không lấy được thông tin');
				$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
					$(".alert-danger").slideUp(500);
				});
			}
		},
		error: function (data) {
		}
	});
};

function get_district_by_province(province, district = null, type) {

	if (district == null) {
		$('#' + type).append('<option value="" class="' + type + '">-- Chọn quận/huyện --</option>');
	}
	$.ajax({
		url: _url.base_url + 'lead_custom/get_district_by_province/' + province,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			let districts = result.data;
			var selectClass = $('#' + type).selectize();
			var selectizeClass = selectClass[0].selectize;
			selectizeClass.clear();
			selectizeClass.clearOptions();
			selectizeClass.load(function (callback) {
				callback(districts);
			});
			console.log(district);
			$('#' + type).data('selectize').setValue(district);
		}
	});
}

function get_ward_by_district(district, ward = null, type) {

	if (ward == null) {
		$('#' + type).append('<option value="" class="' + type + '">-- Chọn xã/phường --</option>');
	}
	$.ajax({
		url: _url.base_url + 'lead_custom/get_ward_by_district/' + district,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			let wards = result.data;
			var selectClass = $('#' + type).selectize();
			var selectizeClass = selectClass[0].selectize;
			selectizeClass.clear();
			selectizeClass.clearOptions();
			selectizeClass.load(function (callback) {
				callback(wards);
			});
			console.log(ward);
			$('#' + type).data('selectize').setValue(ward);

		}
	});
}

var id_face, type_face;
$('#imgImg_giayto').on('click', function () {
	$('#imgInp_Face').trigger('click');
	id_face = $(this).attr('id');
	type_face = "FACE";

});
$('#imgImg_chandung').on('click', function () {
	$('#imgInp_Face').trigger('click');
	id_face = $(this).attr('id');
	type_face = "FACE";
});

$('.return_Face_Identify').on('click', function () {
	isUploaded = false;
	$('.face_identify_results').hide();
	$('#cvs_customer_info').hide();
	$('#imgImg_mattruoc').attr('src', 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png');
	$('#imgImg_matsau').attr('src', 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png');
	$('#imgImg_chandung').attr('src', 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png');
	$('#nextBtn_Face_Identify').css('display', 'none');
	$('#list_info_Face_search').children().remove();
	$('#list_info_Face_search').html("");

});
$('#imgInp_Face').on('change', function () {
	var files = $(this)[0].files[0];
	var formData = new FormData();
	console.log(id_face);
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
		success: function (data) {
			if (data.code == 200 && data.path !== "") {
				if (data.path != null && data.path != "") {
					$('#' + id_face).attr('src', data.path);
					isUploaded = true;
				}
				// Set image for user avatar on the header

			} else {

				$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
			}
		}
	});
});
$('#input_cmt_search').on('change', function () {
	var files = $(this)[0].files[0];
	//console.log(files.size);
	if (files.size > 2097152) {
		$(".alert-danger").text("Ảnh dung lượng phải nhỏ hơn 2MB!");
		$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert-danger").slideUp(500);
		});
		return;
	}
	var formData = new FormData();
	console.log(imageId);
	formData.append('file', files);
	$.ajax({
		dataType: 'json',
		enctype: 'multipart/form-data',
		url: _url.base_url + 'ajax/upload_img',
		type: 'POST',
		data: formData,
		processData: false, // tell jQuery not to process the data
		contentType: false, // tell jQuery not to set contentType
		success: function (data) {
			if (data.code == 200 && data.path !== "") {

				if (data.path != null && data.path != "") {
					$('#' + imageId).attr('src', data.path);
					isUploaded = true;
				}

				// Set image for user avatar on the header

			} else {

				$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
			}
		}
	});
});

// compare id and selfie
$('.identification_Face_Identify').on('click', function () {
	var img_person = $('#imgImg_chandung').attr('src');
	var img_cmt = $('#imgImg_mattruoc').attr('src');
	$('.face_identify_results').hide();
	$('#list_info_Identify').children().remove();
	$('#list_info_Identify').html("");
	if (type_face == undefined) type_face = "FACE";
	if (!isLoading && isUploaded && img_person !== "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" && img_cmt !== "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png") {
		isLoading = true;
		var formData = {
			img_person: img_person,
			backside: img_cmt,
			type: type_face
		};
		$.ajax({
			url: _url.base_url + '/Ajax/get_info_cvs',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#Face_Identify_loading").show();
				$(".face_identify_results").hide();
			},
			success: function (res) {
				isLoading = false;
				console.log(res);
				if (res.res) {
					$("#Face_Identify_loading").hide();
					$("#cvs_customer_info").show();
					$(".face_identify_results").show();
					$(".face_identify_results").text('Kết quả: ' + Math.ceil(res.data.matching) + '%');
					// if(res.data.matching > 70) getInfoFromImg();
					getInfoFromImg();
					$('#nextBtn_Face_Identify').show();
					sessionStorage.setItem("check_Face_Identify", 'true');
					formData['matching'] = res.data.matching;
					sessionStorage.setItem("data_Face_Identify", JSON.stringify(formData));
					// run get info
				} else {
					$("#Face_Identify_loading").hide();
					$(".face_identify_results").show();
					$(".face_identify_results").text('Kết quả: ' + res.data.invalidMessage);
					$(".alert-danger").text(res.message);
					$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
						$(".alert-danger").slideUp(500);
					});
				}
			},
			error: function (data) {
				isLoading = false;
			}
		});
	} else {
		var msg = isLoading ? "Đang upload ảnh!" : "Chưa upload đủ ảnh!";
		$(".alert-danger").text(msg);
		$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert-danger").slideUp(500);
		});
	}
});
$('#nextBtn_Face_Identify').on('click', function () {
	var idLead = $('#idLead_Identify').val();
	var idContract = $('#idContract_Identify').val();
	var url = '';
	if (idLead) {
		url = _url.base_url + 'pawn/createContract?id_lead=' + idLead;
	} else if (idContract) {
		url = _url.base_url + 'pawn/continueCreate?id=' + idContract;
	} else {
		url = _url.base_url + 'pawn/createContract';
	}
	$(location).attr('href', url);
})
$('#imageBlackList').on('change', function () {
	var files = $(this)[0].files[0];
	var formData = new FormData();
	formData.append('file', files);
	$.ajax({
		dataType: 'json',
		enctype: 'multipart/form-data',
		url: _url.base_url + 'ajax/upload_img',
		type: 'POST',
		data: formData,
		processData: false, // tell jQuery not to process the data
		contentType: false, // tell jQuery not to set contentType
		success: function (data) {
			if (data.code == 200 && data.path !== "") {

				if (data.path != null && data.path != "") {
					$('#imgBlackList').attr('src', data.path);
					$('#urlImgBlackList').val(data.path);
				}
				// Set image for user avatar on the header

			} else {

				$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
			}
		}
	});
})

function check_radio(check = '', type) {
	if (check == 'nam') {
		$(type[0]).prop('checked', true);
	} else if (check == 'nu') {
		$(type[1]).prop('checked', true);
	} else {
		$(type[1]).prop('checked', true);
	}
}

$('#imgInp_Identify').on('change', function () {
	var files = $(this)[0].files[0];
	var formData = new FormData();
	console.log(id);
	formData.append('file', files);
	$.ajax({
		dataType: 'json',
		enctype: 'multipart/form-data',
		url: _url.base_url + 'ajax/upload_img',
		type: 'POST',
		data: formData,
		processData: false, // tell jQuery not to process the data
		contentType: false, // tell jQuery not to set contentType
		success: function (data) {
			if (data.code == 200 && data.path != "") {

				if (data.path != null)
					$('#' + id).attr('src', data.path);
				// Set image for user avatar on the header

			} else {
				$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
			}
		}
	});
});

function isset(accessor) {
	try {
		// Note we're seeing if the returned value of our function is not
		// undefined
		return typeof accessor() !== 'undefined'
	} catch (e) {
		// And we're able to catch the Error it would normally throw for
		// referencing a property of undefined
		return false
	}
}

$('input[name="check_customer_identify"]').click(function () {
	var customer_identify = $("#customer_identify").val();
	var customer_identify_old = $("#customer_identify_old").val();

	if ($(this).prop("checked") == true && (customer_identify.length > 0 || customer_identify_old.length > 0)) {
		var formData = {
			customer_identify: customer_identify,
			customer_identify_old: customer_identify_old
		};
		$.ajax({
			url: _url.base_url + '/Ajax/checkContract',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {

				if (data.res) {
					$("#checkContract").modal('show');
					$('#list_contract_check').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						let status = "không xác định";
						status = get_status(content[i].status);
						let key = i + 1;
						html += "<tr><td>" + key + "</td>";
						html += "<td>" + content[i].code_contract_disbursement + "</td>"
						html += "<td><a href='" + _url.base_url + "pawn/detail?id=" + content[i]._id.$oid + "'>" + content[i].store.name + "</a></td>"
						html += "<td>" + status + "</td>"
						html += "</tr>";
					}
					$("#list_contract_check").append(html);
				} else {
					$("#checkContractFalse").modal('show');
				}
			},
			error: function (data) {
			}
		});
	}
});

$("#add_vbi").on('click', function (event) {
	event.preventDefault();
	$('#code_vbi2').hide();
	$('#code_vbi2' + $(this).val()).show();
})
$('[name="gic_easy"]').on('change', function (event) {
	event.preventDefault();

	let fee = $(this).children("option:selected").val();
	$('#fee_gic_easy').val(numeral(fee).format('0,0'));

});

$('#selectize_vbi').selectize({
	create: false,
	valueField: 'code_vbi',
	labelField: 'name',
	searchField: 'name',
	maxItems: 2,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('[name="code_vbi[]"]').on('change', function (event) {
	event.preventDefault();
	let fee = $('#selectize_vbi').val()

	if (fee != null) {
		let fee1 = fee[0];
		let fee2 = fee[1];
		$('#maVBI_1').val(fee1);
		if (fee2 == 0) {
			$('#maVBI_2').val("");
		}
		$('#maVBI_2').val(fee2);
		if (typeof fee1 == "undefined") {
			$('#code_VBI_1').val("");
			$('#fee_vbi1').val(numeral(0).format('0,0'));
		} else if (fee1 == 1) {
			$('#fee_vbi1').val(numeral(70000).format('0,0'));
			$('#code_VBI_1').val("Sốt xuất huyết cá nhân gói đồng");

		} else if (fee1 == 2) {
			$('#fee_vbi1').val(numeral(140000).format('0,0'));
			$('#code_VBI_1').val("Sốt xuất huyết cá nhân gói bạc");

		} else if (fee1 == 3) {
			$('#fee_vbi1').val(numeral(210000).format('0,0'));
			$('#code_VBI_1').val("Sốt xuất huyết cá nhân gói vàng");

		} else if (fee1 == 4) {
			$('#fee_vbi1').val(numeral(245000).format('0,0'));
			$('#code_VBI_1').val("Sốt xuất huyết gia đình 6 người gói đồng");

		} else if (fee1 == 5) {
			$('#code_VBI_1').val("Sốt xuất huyết gia đình 6 người gói bạc");
			$('#fee_vbi1').val(numeral(525000).format('0,0'));
		} else if (fee1 == 6) {
			$('#code_VBI_1').val("Sốt xuất huyết gia đình 6 người gói vàng");

			$('#fee_vbi1').val(numeral(770000).format('0,0'));
		} else if (fee1 == 7) {
			$('#code_VBI_1').val("Ung thư vú - nữ giới 18-40 tuổi Lemon");

			$('#fee_vbi1').val(numeral(42000).format('0,0'));
		} else if (fee1 == 8) {
			$('#code_VBI_1').val("Ung thư vú - nữ giới 18-40 tuổi Orange");

			$('#fee_vbi1').val(numeral(102000).format('0,0'));
		} else if (fee1 == 9) {
			$('#code_VBI_1').val("Ung thư vú - nữ giới 18-40 tuổi Pomelo");

			$('#fee_vbi1').val(numeral(152000).format('0,0'));
		} else if (fee1 == 10) {
			$('#code_VBI_1').val("Ung thư vú - nữ giới 41-55 tuổi Lemon");

			$('#fee_vbi1').val(numeral(132000).format('0,0'));
		} else if (fee1 == 11) {
			$('#code_VBI_1').val("Ung thư vú - nữ giới 41-55 tuổi Orange");

			$('#fee_vbi1').val(numeral(332000).format('0,0'));
		} else if (fee1 == 12) {
			$('#code_VBI_1').val("Ung thư vú - nữ giới 41-55 tuổi Pomelo");
			$('#fee_vbi1').val(numeral(492000).format('0,0'));
		}

		if (typeof fee2 == "undefined") {
			$('#code_VBI_2').val("");
			$('#fee_vbi2').val(numeral(0).format('0,0'));
		} else if (fee2 == 1) {
			$('#code_VBI_2').val("Sốt xuất huyết cá nhân gói đồng");
			$('#fee_vbi2').val(numeral(70000).format('0,0'));
		} else if (fee2 == 2) {
			$('#code_VBI_2').val("Sốt xuất huyết cá nhân gói bạc");
			$('#fee_vbi2').val(numeral(140000).format('0,0'));
		} else if (fee2 == 3) {
			$('#code_VBI_2').val("Sốt xuất huyết cá nhân gói vàng");
			$('#fee_vbi2').val(numeral(210000).format('0,0'));
		} else if (fee2 == 4) {
			$('#code_VBI_2').val("Sốt xuất huyết gia đình 6 người gói đồng");
			$('#fee_vbi2').val(numeral(245000).format('0,0'));
		} else if (fee2 == 5) {
			$('#code_VBI_2').val("Sốt xuất huyết gia đình 6 người gói bạc");
			$('#fee_vbi2').val(numeral(525000).format('0,0'));
		} else if (fee2 == 6) {
			$('#code_VBI_2').val("Sốt xuất huyết gia đình 6 người gói vàng");
			$('#fee_vbi2').val(numeral(770000).format('0,0'));
		} else if (fee2 == 7) {
			$('#code_VBI_2').val("Ung thư vú - nữ giới 18-40 tuổi Lemon");
			$('#fee_vbi2').val(numeral(42000).format('0,0'));
		} else if (fee2 == 8) {
			$('#code_VBI_2').val("Ung thư vú - nữ giới 18-40 tuổi Orange");
			$('#fee_vbi2').val(numeral(102000).format('0,0'));
		} else if (fee2 == 9) {
			$('#code_VBI_2').val("Ung thư vú - nữ giới 18-40 tuổi Pomelo");
			$('#fee_vbi2').val(numeral(152000).format('0,0'));
		} else if (fee2 == 10) {
			$('#code_VBI_2').val("Ung thư vú - nữ giới 41-55 tuổi Lemon");
			$('#fee_vbi2').val(numeral(132000).format('0,0'));
		} else if (fee2 == 11) {
			$('#code_VBI_2').val("Ung thư vú - nữ giới 41-55 tuổi Orange");
			$('#fee_vbi2').val(numeral(332000).format('0,0'));
		} else if (fee2 == 12) {
			$('#code_VBI_2').val("Ung thư vú - nữ giới 41-55 tuổi Pomelo");
			$('#fee_vbi2').val(numeral(492000).format('0,0'));
		}

		let feeTotal = getFloat($("#fee_vbi1").val()) + getFloat($("#fee_vbi2").val());
		$('#fee_vbi').val(numeral(feeTotal).format('0,0'));

	} else {
		$('#maVBI_1').val("");
		$('#code_VBI_1').val("");
		$('#fee_vbi1').val(numeral(0).format('0,0'));
		let feeTotal = getFloat($("#fee_vbi1").val()) + getFloat($("#fee_vbi2").val());
		$('#fee_vbi').val(numeral(feeTotal).format('0,0'));
	}

});

function fee_pti_vta() {
	var fee_pti = 0;
	 code_pti_vta = $("#code_pti_vta").val();
	 year_pti_vta = $("#year_pti_vta").val();
	var formData = {
		packet: code_pti_vta,
		period: year_pti_vta
	}
	if (code_pti_vta != "" && year_pti_vta != "") {
		$.ajax({
			url: _url.base_url + 'Pti_vta_fee/getAllFee',
			method: "POST",
			data: formData,
			success: function (data) {
				console.log(data);
				result = data.data;
				if (data.status == 200) {
					$('#code_fee').val(result._id.$oid);
					if (code_pti_vta == "G1" && year_pti_vta == "3M") {
						$('#price_pti_vta').text(result.three_month);
						fee_pti = $('#price_pti_vta').val(result.three_month);
					} else if (code_pti_vta == "G1" && year_pti_vta == "6M") {
						$('#price_pti_vta').text(result.six_month);
						fee_pti = $('#price_pti_vta').val(result.six_month);
					} else if (code_pti_vta == "G1" && year_pti_vta == "1Y") {
						$('#price_pti_vta').text(result.twelve_month);
						fee_pti = $('#price_pti_vta').val(result.twelve_month);
					} else if (code_pti_vta == "G2" && year_pti_vta == "3M") {
						$('#price_pti_vta').text(result.three_month);
						fee_pti = $('#price_pti_vta').val(result.three_month);
					} else if (code_pti_vta == "G2" && year_pti_vta == "6M") {
						$('#price_pti_vta').text(result.six_month);
						fee_pti = $('#price_pti_vta').val(result.six_month);
					} else if (code_pti_vta == "G2" && year_pti_vta == "1Y") {
						$('#price_pti_vta').text(result.twelve_month);
						fee_pti = $('#price_pti_vta').val(result.twelve_month);
					} else if (code_pti_vta == "G3" && year_pti_vta == "3M") {
						$('#price_pti_vta').text(result.three_month);
						fee_pti = $('#price_pti_vta').val(result.three_month);
					} else if (code_pti_vta == "G3" && year_pti_vta == "6M") {
						$('#price_pti_vta').text(result.six_month);
						fee_pti = $('#price_pti_vta').val(result.six_month);
					} else if (code_pti_vta == "G3" && year_pti_vta == "1Y") {
						$('#price_pti_vta').text(result.twelve_month);
						fee_pti = $('#price_pti_vta').val(result.twelve_month);
					}
				}
			},
			error: function (data) {

			}
		});
	} else {
		fee_pti = 0;
	}
	return fee_pti;
}

function fee_gic() {
	var fee_gi = 0;
	tilekhoanvay = $("#tilekhoanvay").val() !== undefined ? getFloat($("#tilekhoanvay").val()) : 0;
	money = getFloat($('#money').val());
	number_day_loan = getFloat($('#number_day_loan').val());
	number_day_loan = !isNaN(number_day_loan) ? number_day_loan : 1;
	type_loan = $('#type_loan').find(':selected').data('code');
	user_nextpay = $('#user_nextpay').val() !== undefined ? $('#user_nextpay').val() : 0;
	loan_insurance = $('[name="loan_insurance"]').val();

	if (type_loan == 'CC') {
		number_day_loan = 1;
	}
	console.log(number_day_loan + 'GIC');
	console.log(type_loan + 'GIC');
	if(user_nextpay == 1){
		if(number_day_loan == 1 || number_day_loan == 3){
			fee_gi = Number((Number(money) * 100) / 100) * 1 / 100;
		}else {
			fee_gi = Number((Number(money) * 100) / 100) * 5 / 100;
		}
	}else {


		if (number_day_loan <= 12) {
			fee_gi = Number((Number(money) * 200) / 100) * (tilekhoanvay) / 100;
		} else {
			fee_gi = Number((Number(money) * 120) / 100) * (tilekhoanvay) * 2 / 100;
		}
	}
	if (loan_insurance == '2') {
		if (money < 3000000) {
			alert("Số tiền vay nhỏ hơn 3000.000đ không đủ điều kiện tạo BH MIC khoản vay!")
			fee_gi = 0;
		}
	}
	fee = numeral(fee_gi).format('0,0');
	return fee
}

function fee_mic() {
	var fee = 0;
	var money = getFloat($('#money').val());
	var month = getFloat($('#number_day_loan').val());
	var user_nextpay = $('#user_nextpay').val() !== undefined ? $('#user_nextpay').val() : 0;
	var formData = {
		money: money,
		month: month
	};

	$.ajax({
		url: _url.base_url + '/ajax/get_fee_mic',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			if (data.res) {
				fee = data.data.PHI;
				if(user_nextpay == 1){
					if(month == 1 || month == 3){
						fee = numeral(money * 1 / 100).format('0,0');
					}else {
						fee = numeral(money * 5 / 100).format('0,0');
					}
				} else {
					fee = numeral(fee).format('0,0');
				}
				$('#fee_gic').val(fee);
			} else {
				$("#approve_disbursement").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text("Có lỗi xảy ra xin vui lòng liên hệ đội kĩ thuật");
			}
		},
		error: function (data) {
			$("#loading").hide();
		}
	});
	return fee
}

function appraise_property(thiz) {
	var percent_type_loan = $("#percent_type_loan").val();
	var check = $(thiz).is(":checked");
	var price_depreciations = $(thiz).val();
	var price_goc = getFloat($("input[name='price_goc']").val().replace(/,/g, ""));
	var price_property = getFloat($("input[name='price_property']").val().replace(/,/g, ""));
	if (price_property == 0) return;
	if (check == true) {
		var priceProperty = parseInt(price_property) - parseInt(price_depreciations) * parseInt(price_goc) / 100;
	} else {
		var priceProperty = parseInt(price_property) + parseInt(price_depreciations) * parseInt(price_goc) / 100;
	}
	$("input[name='price_property']").val(numeral(priceProperty).format('0,0'));
	var price = parseInt(priceProperty) * parseInt(percent_type_loan) / 100;


	var loan_product_result = $('#loan_product').val();
	var check_type_property_result = $("#type_property").val();
	if (loan_product_result == 14) {
		var price_kdol = priceProperty * 0.8;
		if (check_type_property_result == "5db7e6bfd6612bceec515b76") {
			price_kdol = priceProperty * 0.6;
		}
		if (check_type_property_result == "5f213c10d6612b465f4cb7b6") {
			price_kdol = priceProperty;
		}
		$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
		return;
	}
	if (loan_product_result == 18 || loan_product_result == 3) {
		var price_kdol = priceProperty * 0.5;
		$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
		return;
	}
	if (loan_product_result == 7) {
		var price_kdol = priceProperty * 0.7;
		$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
		return;
	}



	// if(loan_product_result == 2) {
	// 	if (check_type_property_result == "5db7e6b4d6612b173e0728a4") {
	// 		if( price >= 30000000 ){
	// 			return $("input[name='amount_money']").val('30,000,000');
	// 		} else if ( price <= 3000000 ){
	// 			return $("input[name='amount_money']").val('3,000,000');
	// 		}
	// 	}
	// } else if(loan_product_result == 3) {
	// 	if (check_type_property_result == "5db7e6b4d6612b173e0728a4") {
	// 		if( price >= 15000000 ){
	// 			return $("input[name='amount_money']").val('15,000,000');
	// 		} else if ( price <= 3000000 ){
	// 			return $("input[name='amount_money']").val('3,000,000');
	// 		}
	// 	}
	// }
	return $("input[name='amount_money']").val(numeral(price).format('0,0'));
}

function appraise_property_XM(thiz) {
	console.log('xxxx');
	var percent_type_loan = $("#percent_type_loan").val();
	var percent_property = $(thiz).val();
	var price_goc = getFloat($("input[name='price_goc']").val().replace(/,/g, ""));

	if (percent_property == 0) {
		console.log('xxxx_1');
		var priceProperty = price_goc;
	} else {
		console.log('xxxx_2');
		var priceProperty = price_goc - (parseInt(price_goc) * percent_property / 100);
	}

	console.log(percent_type_loan);
	$("input[name='price_property']").val(numeral(priceProperty).format('0,0'));
	var price = parseInt(priceProperty) * parseInt(percent_type_loan) / 100;

	var loan_product_result = $('#loan_product').val();
	var check_type_property_new = $("#type_property").val();
	if (loan_product_result == 14) {
		console.log("result");
		var price_kdol = priceProperty * 0.8;
		if (check_type_property_new == "5db7e6bfd6612bceec515b76") {
			price_kdol = priceProperty * 0.6;
		}
		if (check_type_property_new == "5f213c10d6612b465f4cb7b6") {
			price_kdol = priceProperty;
		}
		$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
		return;
	}
	if (loan_product_result == 18 || loan_product_result == 3) {
		var price_kdol = priceProperty * 0.5;
		$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
		return;
	}
	if (loan_product_result == 7) {
		var price_kdol = priceProperty * 0.7;
		$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
		return;
	}
	$("input[name='amount_money']").val(numeral(price).format('0,0'));
}

$(document).ready(function () {

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
			$.ajax({
				url: _url.base_url + '/Ajax/getDepreciationByProperty',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$("#loading").show();
				},
				success: function (data) {

					if (data.res) {
						$('.depreciation_by_property').children().remove();
						let html = "";
						let content = data.data;
						let code_type_property = $("#type_property :selected").data("code");
						for (var i = 0; i < content.length; i++) {
							if (code_type_property == 'XM') {
								html += "<label><input  onchange='appraise_property(this)' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "'  name='price_depreciation' type='checkbox' value='" + content[i].price + "' >" + content[i].name + "</label></br>"
							} else if (code_type_property == 'OTO') {
								html += "<label><input  onchange='appraise_property(this)' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "'  name='price_depreciation' type='checkbox' value='" + content[i].price + "' >" + content[i].name + "</label></br>"
							}
						}
						$("input[name='price_property']").val(numeral(data.price_property).format('0,0'));
						$("input[name='price_goc']").val(data.price_goc);
						var percent_formality = data.percent;
						$("#percent_type_loan").val(data.percent);
						// var percent_formality = $(".formality").val();
						var price_property = $("input[name='price_property']").val().replace(/,/g, "");
						var price = parseInt(price_property) * parseInt(percent_formality) / 100;

						var loan_product_check = $('#loan_product').val();
						var check_type_property_check = $("#type_property").val();
						if (loan_product_check == 14) {

							var price1 = price_property * 0.8;
							if (check_type_property_check == "5db7e6bfd6612bceec515b76") {
								price1 = price_property * 0.6;
							}
							if (check_type_property_check == "5f213c10d6612b465f4cb7b6") {
								price1 = price_property;
							}
							$("input[name='amount_money']").val(numeral(price1).format('0,0'));
						} else if (loan_product_check == 18 || loan_product_check == 3) {
							var price1 = price_property * 0.5;
							$("input[name='amount_money']").val(numeral(price1).format('0,0'));
						} else if(loan_product_check == 7){
							var price1 = price_property * 0.7;
							$("input[name='amount_money']").val(numeral(price1).format('0,0'));
						}
							// else if(loan_product_check == 2) {
							// 	console.log(1)
							// 	if (check_type_property_check == "5db7e6b4d6612b173e0728a4") {
							// 		if( price >= 30000000 ){
							// 			$("input[name='amount_money']").val('30,000,000');
							// 		}else if ( price <= 3000000 ){
							// 			$("input[name='amount_money']").val('3,000,000');
							// 		}else {
							// 			$("input[name='amount_money']").val(numeral(price).format('0,0'));
							// 		}
							// 	}
							// } else if(loan_product_check == 3) {
							// 	console.log(2)
							// 	if (check_type_property_check == "5db7e6b4d6612b173e0728a4") {
							// 		if( price >= 15000000 ){
							// 			$("input[name='amount_money']").val('15,000,000');
							// 		}else if ( price <= 3000000 ){
							// 			$("input[name='amount_money']").val('3,000,000');
							// 		}else {
							// 			$("input[name='amount_money']").val(numeral(price).format('0,0'));
							// 		}
							// 	}
						// }
						else {
							$("input[name='amount_money']").val(numeral(price).format('0,0'));
						}
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
						var check_type_property_check = $("#type_property").val();
						if (loan_product_check == 14) {

							var price1 = price_property * 0.8;
							if (check_type_property_check == "5db7e6bfd6612bceec515b76") {
								price1 = price_property * 0.6;
								console.log(1);
							}
							if (check_type_property_check == "5f213c10d6612b465f4cb7b6") {
								price1 = price_property;

							}
							console.log(price1);
							$("input[name='amount_money']").val(numeral(price1).format('0,0'));
						}
							// else if(loan_product_check == 2) {
							// 	console.log(3)
							// 	if (check_type_property_check == "5db7e6b4d6612b173e0728a4") {
							// 		if( price >= 30000000 ){
							// 			$("input[name='amount_money']").val('30,000,000');
							// 		}else if ( price <= 3000000 ){
							// 			$("input[name='amount_money']").val('3,000,000');
							// 		}else {
							// 			$("input[name='amount_money']").val(numeral(price).format('0,0'));
							// 		}
							// 	}
							// } else if(loan_product_check == 3) {
							// 	console.log(4)
							// 	if (check_type_property_check == "5db7e6b4d6612b173e0728a4") {
							// 		if( price >= 15000000 ){
							// 			$("input[name='amount_money']").val('15,000,000');
							// 		}else if ( price <= 3000000 ){
							// 			$("input[name='amount_money']").val('3,000,000');
							// 		}else {
							// 			$("input[name='amount_money']").val(numeral(price).format('0,0'));
							// 		}
							// 	}
						// }
						else if (loan_product_check == 18 || loan_product_check == 3) {
							var price1 = price_property * 0.5;

							$("input[name='amount_money']").val(numeral(price1).format('0,0'));
						} else if(loan_product_check == 7){
							var price1 = price_property * 0.7;
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


	$('#amount_money').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;

		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
		});
	});
	// $('#amount_money').keyup(function(event) {
	//     $('.number').keypress(function(event) {
	//         if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
	//             event.preventDefault();
	//         }
	//     });
	// });
	$('#salary').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;

		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
		});
	});

	$('#money').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
		});


		if ($('#insurrance').prop("checked") == true) {
			if ($('[name="loan_insurance"]').val() == '1') {
				$('#fee_gic').val(fee_gic());
			}
			if ($('[name="loan_insurance"]').val() == '2') {
				$('#fee_gic').val(fee_gic());
			}

		} else {
			$('#fee_gic').val(0);
		}


	});


	$('#number_day_loan').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});

	});
	$('#customer_identify').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$('#customer_identify_old').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$('#customer_phone_number').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$('#phone_number_relative_1').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$('#phone_number_relative_2').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$('#phone_number_company').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$("input[data-slug='so-dang-ky']").keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});


	$('#period_pay_interest').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$('#bank_account').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
	$('#atm_card_number').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});


	$('.number').keypress(function (event) {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});

});


function get_property_by_main(thiz) {
	var id = $(thiz).val();
	var formData = {
		id: id
	};
	console.log(1);
	$.ajax({
		url: _url.base_url + '/property_main/getPopertyByMain',
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
};

function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

function get_property_by_main_contract(thiz) {
	var id = $(thiz).val();
	var code = $("#type_property :selected").data("code")
	typePropertyChangeAction();
	if (code == "OTO") {
		$('select[name="gic_easy"]').val("0");
		$('select[name="gic_easy"]').prop('disabled', true);
		$('#fee_gic_easy').val(0);
		$('#phi_tnds').val(0);
	} else {
		$('select[name="gic_easy"]').prop('disabled', false);
	}
	if (code != "NĐ") {
		var formData = {
			id: id
		};
		console.log(2);
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
						if (content[i].slug == 'thua-dat-so' || content[i].slug == 'dien-tich-m2' || content[i].slug == 'hinh-thuc-su-dung-rieng-m2' || content[i].slug == 'hinh-thuc-su-dung-chung-m2' || content[i].slug == 'thoi-han-su-dung') {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input onkeypress='return isNumber(event)' type='text' name='property_infor' required class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						} else if (content[i].slug == "ngay-cap") {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='date' name='property_infor' required id='" + content[i].slug + "' class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						} else if (content[i].slug == "so-dang-ky") {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='7' type='text' name='property_infor' required  id='" + content[i].slug + "' class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
						} else {
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input type='text' name='property_infor' required id='" + content[i].slug + "' class='form-control property-infor' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
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
					var selectClass = $('#selectize_property_by_main').selectize();
					var selectizeClass = selectClass[0].selectize;
					selectizeClass.clear();
					selectizeClass.clearOptions();
					selectizeClass.load(function (callback) {
						callback('');
					});
					$('.properties').children().remove();
					console.log('error')
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
	$('#fee_gic').val(fee_gic());
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


$(".submitFeeTable").click(function (event) {
	// var hinh_thuc_lai = $(thiz).val();
	var amount_money = getFloat($("input[name='amount_money']").val());
	var type_loan = $("#type_loan :selected").val();
	var number_day_loan = $("#number_day_loan").val();
	var period_pay_interest = $("#period_pay_interest").val();
	var type_interest = $("#type_interest").val();
	if ($('#insurrance').prop('checked') == true) {
		var insurrance = 1;
	} else {
		var insurrance = 0;
	}
	var date_payment = $('#date_payment').val();
	if (isNaN(amount_money) === true) {
	}
	var formData = {
		amount_money: amount_money,
		type_loan: type_loan,
		number_day_loan: number_day_loan,
		period_pay_interest: period_pay_interest,
		type_interest: type_interest,
		insurrance: insurrance,
		date_payment: date_payment,

	};
	$.ajax({
		url: _url.base_url + '/pawn/spreadsheetFeeLoan',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			if (data.res) {
				if (type_interest == 1) {
					$('.bang_phi1').show();
					$('.bang_phi2').hide();
					$('.tbody_bang_phi1').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						html += "<tr><td>" + content[i].ky_tra + "</td><td class='text-danger'>" + numeral(content[i].tien_tra_1_ky).format('0,0') + "</td><td>" + numeral(content[i].round_tien_tra_1_ky).format('0,0') + "</td><td>" + numeral(content[i].tien_goc_1ky).format('0,0') + "</td><td>" + numeral(content[i].tong_phi_lai).format('0,0') + "</td><td>" + numeral(content[i].phi_tu_van).format('0,0') + "</td><td>" + numeral(content[i].phi_tham_dinh).format('0,0') + "</td><td>" + numeral(content[i].lai_ky).format('0,0') + "</td><td>" + numeral(content[i].tien_goc_con).format('0,0') + "</td><td class='text-danger text-right'></td><td class='text-danger text-right'>" + numeral(content[i].tien_tat_toan).format('0,0') + "</td>"

					}
					$('.tong_tien_tra_ky').text(numeral(data.dataTotal.tong_tien_tra_ky).format('0,0'));
					$('.tong_round_tien_tra_ky').text(numeral(data.dataTotal.tong_round_tien_tra_ky).format('0,0'));
					$('.tong_phi_tu_van').text(numeral(data.dataTotal.tong_phi_tu_van).format('0,0'));
					$('.tong_phi_tham_dinh').text(numeral(data.dataTotal.tong_phi_tham_dinh).format('0,0'));
					$(".tbody_bang_phi1").append(html);
				} else if (type_interest == 2) {
					$('.bang_phi2').show();
					$('.bang_phi1').hide();
					$('#tbody_bang_phi2').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						html += "<tr><td>" + content[i].ky_tra + "</td><td class='text-danger'>" + numeral(content[i].phi_lai).format('0,0') + "</td><td>" + numeral(content[i].phi_tu_van).format('0,0') + "</td><td>" + numeral(content[i].phi_tham_dinh).format('0,0') + "</td><td>" + numeral(content[i].lai_ky).format('0,0') + "</td><td class='text-danger text-right'></td><td class='text-danger text-right'>" + numeral(content[i].tien_tat_toan).format('0,0') + "</td>"

					}
					$('.tong_tien_tra_ky2').text(numeral(data.data_total.tong_tien_tra_ky).format('0,0'));
					$('.tong_phi_tu_van2').text(numeral(data.data_total.tong_phi_tu_van).format('0,0'));
					$('.tong_phi_tham_dinh2').text(numeral(data.data_total.tong_phi_tham_dinh).format('0,0'));
					$('.tong_lai_ky2').text(numeral(data.data_total.tong_lai_ky).format('0,0'));
					$('.tong_tien_tat_toan2').text(numeral(data.data_total.tong_tien_tat_toan).format('0,0'));

					$("#tbody_bang_phi2").append(html);
				}


			} else {

			}
		},
		error: function (data) {
			// console.log(data);
			// $("#loading").hide();
		}
	});

});

function hinh_thuc_lai(thiz) {
	// var hinh_thuc_lai = $(thiz).val();
	var hinh_thuc_lai = $(".hinh_thuc_lai").val();
	var amount_money = $("input[name='amount_money']").val();
	var ky_vay = $(".ky_han_vay").val();
	console.log(amount_money);
	if (amount_money == "") return;
	var formData = {
		hinh_thuc_lai: hinh_thuc_lai,
		amount_money: amount_money,
		ky_vay: ky_vay
	};
	$.ajax({
		url: _url.base_url + '/pawn/spreadsheetFeeLoan',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			console.log(data);
			if (data.res) {
				if (hinh_thuc_lai == 1) {
					$('.bang_phi1').show();
					$('.bang_phi2').hide();
					$('.tbody_bang_phi1').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						html += "<tr><td>" + content[i].ky_tra + "</td><td class='text-danger'>" + numeral(content[i].tien_tra_1_ky).format('0,0') + "</td><td>" + numeral(content[i].round_tien_tra_1_ky).format('0,0') + "</td><td>" + numeral(content[i].tien_goc_1ky).format('0,0') + "</td><td>" + numeral(content[i].tong_phi_lai).format('0,0') + "</td><td>" + numeral(content[i].phi_tu_van).format('0,0') + "</td><td>" + numeral(content[i].phi_tham_dinh).format('0,0') + "</td><td>" + numeral(content[i].lai_ky).format('0,0') + "</td><td>" + numeral(content[i].tien_goc_con).format('0,0') + "</td><td class='text-danger text-right'></td><td class='text-danger text-right'>" + numeral(content[i].tien_tat_toan).format('0,0') + "</td>"

					}
					$('.tong_tien_tra_ky').text(numeral(data.dataTotal.tong_tien_tra_ky).format('0,0'));
					$('.tong_round_tien_tra_ky').text(numeral(data.dataTotal.tong_round_tien_tra_ky).format('0,0'));
					$('.tong_phi_tu_van').text(numeral(data.dataTotal.tong_phi_tu_van).format('0,0'));
					$('.tong_phi_tham_dinh').text(numeral(data.dataTotal.tong_phi_tham_dinh).format('0,0'));
					$(".tbody_bang_phi1").append(html);
				}
				if (hinh_thuc_lai == 2) {
					$('.bang_phi2').show();
					$('.bang_phi1').hide();
					$('.tbody_bang_phi2').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						html += "<tr><td>" + content[i].ky_tra + "</td><td class='text-danger'>" + numeral(content[i].tong_phi_lai).format('0,0') + "</td><td>" + content[i].phi_tu_van + "</td><td>" + content[i].phi_tham_dinh + "</td><td>" + content[i].lai_ky + "</td><td class='text-danger text-right'></td><td class='text-danger text-right'>" + content[i].tien_tat_toan + "</td>"

					}
					$(".tbody_bang_phi2").append(html);
				}


			} else {

			}
		},
		error: function (data) {
			// console.log(data);
			// $("#loading").hide();
		}
	});
}

$('#selectize_province_current_address').selectize({
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
			id: value
		};
		$.ajax({
			url: _url.base_url + '/Ajax/get_district_by_province',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				if (data.res) {
					var selectClass = $('#selectize_district_current_address').selectize();
					var selectizeClass = selectClass[0].selectize;
					selectizeClass.clear();
					selectizeClass.clearOptions();
					selectizeClass.load(function (callback) {
						callback(data.data);
					});


				} else {

				}
			},
			error: function (data) {
				// console.log(data);
				// $("#loading").hide();
			}
		});
	}
});

$('#selectize_district_current_address').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	},
	onChange: function (value) {
		var formData = {
			id: value
		};
		$.ajax({
			url: _url.base_url + '/Ajax/get_ward_by_district',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				if (data.res) {
					var selectClass = $('#selectize_ward_current_address').selectize();
					var selectizeClass = selectClass[0].selectize;
					selectizeClass.clear();
					selectizeClass.clearOptions();
					selectizeClass.load(function (callback) {
						callback(data.data);
					});
					//    var var_war=$('#id_war').val();
					// $('#selectize_ward_current_address').data('selectize').setValue(var_war);

				} else {

				}
			},
			error: function (data) {
				// console.log(data);
				// $("#loading").hide();
			}
		});
	}
});

$('#selectize_ward_current_address').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});


$('#selectize_bank_vimo').selectize({
	create: false,
	valueField: 'bank_id',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('#selectize_positioningDevices').selectize({
	create: false,
	valueField: 'bank_id',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});


$('#selectize_province_household').selectize({
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
			id: value
		};
		$.ajax({
			url: _url.base_url + '/Ajax/get_district_by_province',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				if (data.res) {
					var selectClass = $('#selectize_district_household').selectize();
					var selectizeClass = selectClass[0].selectize;
					selectizeClass.clear();
					selectizeClass.clearOptions();
					selectizeClass.load(function (callback) {
						callback(data.data);
					});


				} else {

				}
			},
			error: function (data) {
				// console.log(data);
				// $("#loading").hide();
			}
		});
	}
});

$('#selectize_district_household').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	},
	onChange: function (value) {
		var formData = {
			id: value
		};
		$.ajax({
			url: _url.base_url + '/Ajax/get_ward_by_district',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				if (data.res) {
					var selectClass = $('#selectize_ward_household').selectize();
					var selectizeClass = selectClass[0].selectize;
					selectizeClass.clear();
					selectizeClass.clearOptions();
					selectizeClass.load(function (callback) {
						callback(data.data);
					});


				} else {

				}
			},
			error: function (data) {
				// console.log(data);
				// $("#loading").hide();
			}
		});
	}
});

$('#selectize_ward_household').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

function convert_date(date_tring) {
	var sep = date_tring.indexOf("-") >= 0 ? "-" : "/";
	var parts = date_tring.split(sep);
	var dd = parts[0].length == 1 && parseInt(parts[0]) < 10 ? "0" + parts[0] : parts[0];
	var mm = parts[1].length == 1 && parseInt(parts[1]) < 10 ? "0" + parts[1] : parts[1];

	return parts[2] + '-' + mm + '-' + dd;
}

function getFloat(val) {
	var val = val.replace(/,/g, "");
	return parseFloat(val);
}

$(".email-autocomplete").autocomplete({
	maxResult: 5,
	source: function (request, response) {
		console.log(1);
		var textSearch = $(".email-autocomplete").val();
		$.ajax({
			url: _url.user_search_autocomplete,
			method: "POST",
			data: {
				name: "email",
				value: textSearch.trim()
			},
			success: function (data) {
				response($.map(data.data, function (item) {
					return {
						email: item.email
					};
				}).slice(0, 10));
			}
		})
	},
	minLength: 2,
	select: function (event, ui) {
		//window.location.href = ui.item.href;
		$(".email-autocomplete").val(ui.item.email);
		return false;
	},
	appendTo: "#results",
})
	.data("ui-autocomplete")._renderItem = function (ul, item) {
	return $("<li class='ajaxItem list-group-item' >")
		.append("<span class='description'>" + item.email + "</span>")
		.appendTo(ul);
};

$(".phone-autocomplete").autocomplete({
	maxResult: 5,
	source: function (request, response) {
		console.log(1);
		var textSearch = $(".phone-autocomplete").val();
		$.ajax({
			url: _url.user_search_autocomplete,
			method: "POST",
			data: {
				name: "phone_number",
				value: textSearch.trim()
			},
			success: function (data) {
				response($.map(data.data, function (item) {
					return {
						phone: item.phone_number
					};
				}).slice(0, 10));
			}
		})
	},
	minLength: 2,
	select: function (event, ui) {
		//window.location.href = ui.item.href;
		$(".phone-autocomplete").val(ui.item.phone);
		return false;
	},
	appendTo: "#resultsPhone",
})
	.data("ui-autocomplete")._renderItem = function (ul, item) {
	return $("<li class='ajaxItem list-group-item' >")
		.append("<span class='description'>" + item.phone + "</span>")
		.appendTo(ul);
};

$(".identify-autocomplete").autocomplete({
	maxResult: 5,
	source: function (request, response) {
		console.log(1);
		var textSearch = $(".identify-autocomplete").val();
		$.ajax({
			url: _url.user_search_autocomplete,
			method: "POST",
			data: {
				name: "identify",
				value: textSearch.trim()
			},
			success: function (data) {
				response($.map(data.data, function (item) {
					return {
						identify: item.identify
					};
				}).slice(0, 10));
			}
		})
	},
	minLength: 2,
	select: function (event, ui) {
		//window.location.href = ui.item.href;
		$(".identify-autocomplete").val(ui.item.identify);
		return false;
	},

	appendTo: "#resultsIdentify",
})

	.data("ui-autocomplete")._renderItem = function (ul, item) {
	return $("<li class='ajaxItem list-group-item' >")
		.append("<span class='description'>" + item.identify + "</span>")
		.appendTo(ul);
};

$(".identify-old-autocomplete").autocomplete({
	maxResult: 5,
	source: function (request, response) {
		console.log(1);
		var textSearch = $(".identify-old-autocomplete").val();
		$.ajax({
			url: _url.contract_search_autocomplete,
			method: "POST",
			data: {
				name: "customer_infor.customer_identify_old",
				value: textSearch.trim()
			},
			success: function (data) {
				response($.map(data.data, function (item) {
					return {
						customer_identify_old: item.customer_identify_old
					};
				}).slice(0, 10));
			}
		})
	},
	minLength: 2,
	select: function (event, ui) {
		//window.location.href = ui.item.href;
		$(".identify-old-autocomplete").val(ui.item.customer_identify_old);
		return false;
	},
	appendTo: "#resultsIdentifyOld",
})
	.data("ui-autocomplete")._renderItem = function (ul, item) {
	return $("<li class='ajaxItem list-group-item' >")
		.append("<span class='description'>" + item.customer_identify_old + "</span>")
		.appendTo(ul);
};
$(document).ready(function () {
	$(".nextBtnCreate").click(function (event) {
		event.preventDefault();
		//check verify
		// if ($("#isBlacklist").val() == "2") {
		// 	alert('Chưa xác nhận ảnh selfie hoặc cmnd khách hàng');
		// 	return;
		// }

		var curStep = $(this).closest(".setup-content"),
			curStepBtn = curStep.attr("id"),
			nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
			curInputs = curStep.find("input[required]"),
			isValid = true;

		var step = $(this).attr('data-step');
		//Get customer infor
		var customerInfor = getCustomerInfor();
		//Get current address
		var currentAddress = getCustomerAddress();
		//Get householdInfor
		var houseHoldAddress = getHouseholdAddress();
		//Get jobInfor
		var jobInfor = getJobInfor();
		//Get relativeInfor
		var relativeInfor = getRelativeInfor();
		//Get loanInfor
		var loanInfor = getLoanInfor();
		//Get property infor
		var propertyInfor = getPropertyInfor();
		//Get receiver infor
		var receiverInfor = getReceiverInfor();
		//Get receiver infor
		var expertiseInfor = getExpertiseInfor();
		//get store
		var store = getStoreInfor();
		var formData = {
			customer_infor: customerInfor,
			current_address: currentAddress,
			houseHold_address: houseHoldAddress,
			job_infor: jobInfor,
			relative_infor: relativeInfor,
			loan_infor: loanInfor,
			property_infor: propertyInfor,
			receiver_infor: receiverInfor,
			expertise_infor: expertiseInfor,
			store: store,
			step: step
		};
		$.ajax({
			url: _url.base_url + '/pawn/validateCreateContract',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(formData);
				setTimeout(function () {
					$(".theloading").hide();
				}, 1000);
				if (data.code == 200) {
					//console.log("Save OK!");
					$(".form-group").removeClass("has-error");
					$(".alert-danger").hide();
					if (data.flag_gic != undefined && data.flag_gic == 1) {
						toastr.options.timeOut = 10000;
						toastr.warning('KH đã mua Bảo hiểm xe (GIC Easy) còn hiệu lực tại HĐ: ' + data.data + ' , vui lòng bỏ chọn BH GIC EASY nếu khách không mua nữa! (Tab: Thông tin khoản vay).');
					}
					//validate by js
					// for (var i = 0; i < curInputs.length; i++) {
					// if (!curInputs[i].validity.valid) {
					//     isValid = false;
					//     $(curInputs[i]).closest(".form-group").addClass("has-error");
					// }
					// }

					if (isValid) nextStepWizard.removeAttr('disabled').removeClass('disabled').trigger('click');
				} else {
					//  $("#insurrance").prop('checked', false);
					$("#div_error").css("display", "block");
					$(".alert-danger").text(data.message);
					$(".div_error").text(data.message);

					// window.scrollTo(0, 0);
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#div_error").offset().top
					}, 500);
				}
			},
			error: function (data) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 1000);
			}
		});

	});


	$(".btn-save-contract").on("click", function (event) {
		event.preventDefault();
		//check verify
		// if ($("#isBlacklist").val() == "2") {
		// 	alert('Chưa xác nhận ảnh selfie hoặc cmnd khách hàng');
		// 	return;
		// }
		var data_Face_search = JSON.parse(sessionStorage.getItem('data_Face_search'));
		var data_Face_Identify = JSON.parse(sessionStorage.getItem('data_Face_Identify'));
		var step = $("#step_index").val();
		//Get customer infor
		var customerInfor = getCustomerInfor();
		//Get current address
		var currentAddress = getCustomerAddress();
		//Get householdInfor
		var houseHoldAddress = getHouseholdAddress();
		//Get jobInfor
		var jobInfor = getJobInfor();
		//Get relativeInfor
		var relativeInfor = getRelativeInfor();
		//Get loanInfor
		var loanInfor = getLoanInfor();
		//Get property infor
		var propertyInfor = getPropertyInfor();
		//Get receiver infor
		var receiverInfor = getReceiverInfor();
		//Get receiver infor
		var expertiseInfor = getExpertiseInfor();
		//get store
		var store = getStoreInfor();
		$("#saveContract").modal("hide");
		//Call ajax
		$.ajax({
			url: _url.base_url + '/pawn/saveContract',
			method: "POST",
			data: {
				customer_infor: customerInfor,
				current_address: currentAddress,
				houseHold_address: houseHoldAddress,
				job_infor: jobInfor,
				relative_infor: relativeInfor,
				loan_infor: loanInfor,
				property_infor: propertyInfor,
				receiver_infor: receiverInfor,
				expertise_infor: expertiseInfor,
				store: store,
				step: step,
				data_Face_search: data_Face_search,
				data_Face_Identify: data_Face_Identify
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				console.log(data)
				if (data.code != 200) {

					$("#div_error").css("display", "block");
					$(".alert-danger").text(data.message);
					$(".div_error").text(data.message);
					// window.scrollTo(0, 0);
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#div_error").offset().top
					}, 500);

					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 3000);
				} else {

					$("#successModal").modal("show");
					$(".msg_success").text('Lưu hợp đồng thành công');

					sessionStorage.clear()
					setTimeout(function () {
						window.location.href = _url.contract;
					}, 2000);

				}
			},
			error: function (error) {
				console.log(error);
			}
		})
	});

	$(".btn-save-contract-continue").on("click", function (event) {
		event.preventDefault();
		var step = $("#step_index").val();
		//Get customer infor
		var customerInfor = getCustomerInfor();
		//Get current address
		var currentAddress = getCustomerAddress();
		//Get householdInfor
		var houseHoldAddress = getHouseholdAddress();
		//Get jobInfor
		var jobInfor = getJobInfor();
		//Get relativeInfor
		var relativeInfor = getRelativeInfor();
		//Get loanInfor
		var loanInfor = getLoanInfor();
		//Get property infor
		var propertyInfor = getPropertyInfor();
		//Get receiver infor
		var receiverInfor = getReceiverInfor();
		//Get receiver infor
		var expertiseInfor = getExpertiseInfor();
		//get store
		var store = getStoreInfor();
		//Call ajax
		$.ajax({
			url: _url.base_url + '/pawn/continueSaveContract',
			method: "POST",
			data: {
				id: $("#contract_id").val(),
				customer_infor: customerInfor,
				current_address: currentAddress,
				houseHold_address: houseHoldAddress,
				job_infor: jobInfor,
				relative_infor: relativeInfor,
				loan_infor: loanInfor,
				property_infor: propertyInfor,
				receiverInfor: receiverInfor,
				expertise_infor: expertiseInfor,
				store: store,
				step: step
			},
			beforeSend: function () {
				$("#theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status != 200) {
					$("#saveContract").modal("hide");
					$("#div_error").css("display", "block");
					$("#div_error").text(data.message);
					window.scrollTo(0, 0);
				} else {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.href = _url.contract;
					}, 2000);
				}
			},
			error: function (error) {
				console.log(error);
			}
		})
	});

	$(".btn-create-contract").on("click", function () {
		//check verify
		// if ($("#isBlacklist").val() == "2") {
		// 	alert('Chưa xác nhận ảnh selfie hoặc cmnd khách hàng');
		// 	return;
		// }
		var data_Face_search = JSON.parse(sessionStorage.getItem('data_Face_search'));
		var data_Face_Identify = JSON.parse(sessionStorage.getItem('data_Face_Identify'));
		//Get customer infor
		var customerInfor = getCustomerInfor();
		//Get current address
		var currentAddress = getCustomerAddress();
		//Get householdInfor
		var houseHoldAddress = getHouseholdAddress();
		//Get jobInfor
		var jobInfor = getJobInfor();
		//Get relativeInfor
		var relativeInfor = getRelativeInfor();
		//Get loanInfor
		var loanInfor = getLoanInfor();
		//Get property infor
		var propertyInfor = getPropertyInfor();
		//Get receiver infor
		var receiverInfor = getReceiverInfor();
		//Get receiver infor
		var expertiseInfor = getExpertiseInfor();
		//get store
		var store = getStoreInfor();
		//Call ajax
		$("#createContract").modal("hide");
		$.ajax({
			url: _url.process_create_contract,
			method: "POST",
			data: {
				customer_infor: customerInfor,
				current_address: currentAddress,
				houseHold_address: houseHoldAddress,
				job_infor: jobInfor,
				relative_infor: relativeInfor,
				loan_infor: loanInfor,
				property_infor: propertyInfor,
				receiver_infor: receiverInfor,
				expertise_infor: expertiseInfor,
				store: store,
				data_Face_search: data_Face_search,
				data_Face_Identify: data_Face_Identify

			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status != 200) {
					console.log(data.message);
					sessionStorage.clear()
					$(".div_error").text(data.message);
					$("#div_error").css("display", "block");
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 3000);
				} else {
					$("#successModal").modal("show");
					$(".msg_success").text('Tạo hợp đồng thành công');

					sessionStorage.clear()
					setTimeout(function () {
						window.location.href = _url.contract;
					}, 2000);

				}
			},
			error: function (error) {
				console.log(error);
			}
		})
	});


	$(".btn-continue-create-contract").on("click", function () {
		//check verify
		// if ($("#isBlacklist").val() == "2") {
		// 	alert('Chưa xác nhận ảnh selfie hoặc cmnd khách hàng');
		// 	return;
		// }
		var data_Face_search = JSON.parse(sessionStorage.getItem('data_Face_search'));
		var data_Face_Identify = JSON.parse(sessionStorage.getItem('data_Face_Identify'));
		//Get customer infor
		var customerInfor = getCustomerInfor();
		//Get current address
		var currentAddress = getCustomerAddress();
		//Get householdInfor
		var houseHoldAddress = getHouseholdAddress();
		//Get jobInfor
		var jobInfor = getJobInfor();
		//Get relativeInfor
		var relativeInfor = getRelativeInfor();
		//Get loanInfor
		var loanInfor = getLoanInfor();
		//Get property infor
		var propertyInfor = getPropertyInfor();
		//Get receiver infor
		var receiverInfor = getReceiverInfor();
		//Get receiver infor
		var expertiseInfor = getExpertiseInfor();
		//get store
		var store = getStoreInfor();
		$("#createContract").modal("hide");
		//Call ajax
		$.ajax({
			url: _url.base_url + '/pawn/continueCreateContract',
			method: "POST",
			data: {
				id: $("#contract_id").val(),
				customer_infor: customerInfor,
				current_address: currentAddress,
				houseHold_address: houseHoldAddress,
				job_infor: jobInfor,
				relative_infor: relativeInfor,
				loan_infor: loanInfor,
				property_infor: propertyInfor,
				receiverInfor: receiverInfor,
				expertise_infor: expertiseInfor,
				store: store,
				data_Face_search: data_Face_search,
				data_Face_Identify: data_Face_Identify
			},
			beforeSend: function () {
				$("#theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status != 200) {
					$("#div_error").css("display", "block");
					$("#div_error").text(data.message);
					window.scrollTo(0, 0);
				} else {
					$("#successModal").modal("show");
					$(".msg_success").text('Tạo hợp đồng thành công');

					sessionStorage.clear()
					setTimeout(function () {
						window.location.href = _url.contract;
					}, 2000);
				}
			},
			error: function (error) {
				console.log(error);
			}
		})
	});


	$(".btn-update-contract").on("click", function () {
		//Get customer infor
		var customerInfor = getCustomerInfor();
		//Get current address
		var currentAddress = getCustomerAddress();
		//Get householdInfor
		var houseHoldAddress = getHouseholdAddress();
		//Get jobInfor
		var jobInfor = getJobInfor();
		//Get relativeInfor
		var relativeInfor = getRelativeInfor();
		//Get loanInfor
		var loanInfor = getLoanInfor();
		//Get property infor
		var propertyInfor = getPropertyInfor();
		//Get receiver infor
		var receiverInfor = getReceiverInfor();
		//Get receiver infor
		var expertiseInfor = getExpertiseInfor();
		//get store
		var store = getStoreInfor();
		console.log(loanInfor);
		//Call ajax
		$.ajax({
			url: _url.process_update_contract,
			method: "POST",
			data: {
				id: $("#contract_id").val(),
				customer_infor: customerInfor,
				current_address: currentAddress,
				houseHold_address: houseHoldAddress,
				job_infor: jobInfor,
				relative_infor: relativeInfor,
				loan_infor: loanInfor,
				property_infor: propertyInfor,
				receiverInfor: receiverInfor,
				expertise_infor: expertiseInfor,
				store: store
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status != 200) {
					$("#div_error").css("display", "block");
					$("#div_error").text(data.message);
					window.scrollTo(0, 0);
				} else {
					window.location.href = _url.contract;
				}
			},
			error: function (error) {
				console.log(error);
			}
		})
	});
});

function getPropertyInfor() {
	var arrPropertyInfor = [];
	var count = $("input[name='property_infor']").length;
	if (count > 0) {
		$("input[name='property_infor']").each(function () {
			var data = {};
			data['name'] = $(this).data('name');
			data['slug'] = $(this).data('slug');
			data['value'] = $(this).val();
			arrPropertyInfor.push(data);
		});
	}
	return arrPropertyInfor;
}

function getDecreaseProperty() {
	var arrDecrease = [];
	var count = $("input[name='price_depreciation']").length;
	if (count > 0) {
		$("input[name='price_depreciation']").each(function () {
			var decrease = {};
			decrease['checked'] = $(this).prop("checked") == true ? 1 : 2;
			decrease['name'] = $(this).data('name');
			decrease['slug'] = $(this).data('slug');
			decrease['value'] = $(this).val();
			arrDecrease.push(decrease);
		});
	}
	return arrDecrease;
}

function getLoanInfor() {
	var loanInfor = {};
	//type_loan
	var type_loan = {};
	var id_type_loan = $("#type_loan :selected").data("id");
	var code_type_loan = $("#type_loan :selected").data("code");
	var text_type_loan = $("#type_loan :selected").text();
	type_loan['id'] = id_type_loan;
	type_loan['text'] = text_type_loan;
	type_loan['code'] = code_type_loan;

	//type_property
	var type_property = {};
	var id_type_property = $("#type_property :selected").val();
	var txt_type_property = $("#type_property :selected").text();
	var code_type_property = $("#type_property :selected").data("code");
	type_property['id'] = id_type_property;
	type_property['text'] = txt_type_property;
	type_property['code'] = code_type_property;
	//type_property
	var gan_dinh_vi = $("input[name='gan_dinh_vi']:checked").val();
	var o_to_ngan_hang = $("input[name='o_to_ngan_hang']:checked").val();
	if (type_property['code'] == 'OTO') {

		loanInfor['gan_dinh_vi'] = (gan_dinh_vi == "" || gan_dinh_vi == undefined) ? '' : gan_dinh_vi;
	}
	if (type_property['code'] == 'OTO' && type_loan['code'] == "CC") {

		loanInfor['o_to_ngan_hang'] = (o_to_ngan_hang == "" || o_to_ngan_hang == undefined) ? '' : o_to_ngan_hang;
	}
	var loan_product = {};
	var code_loan_product = $("#loan_product :selected").val();
	var txt_loan_product = $("#loan_product :selected").text();
	loan_product['text'] = txt_loan_product;
	loan_product['code'] = code_loan_product;

	//name_property
	var name_property = {};
	var id_name_property = $("#selectize_property_by_main :selected").val();
	var txt_name_property = $("#selectize_property_by_main :selected").text();
	name_property['id'] = id_name_property;
	name_property['text'] = txt_name_property;

	var type_tnds = $("#type_tnds").val();
	var mic_dung_tich_xe = $("#mic_dung_tich_xe").val();
	var mic_muc_trach_nhiem = $("#mic_muc_trach_nhiem").val();
	var hieu_xe = $("#hieu_xe").val();
	var hang_xe = $("#hang_xe").val();
	var nhom_xe = $("#nhom_xe").val();
	var phi_tnds = getFloat($("#phi_tnds").val());
	var bao_hiem_tnds = {};
	if (type_tnds == 'MIC_TNDS' && phi_tnds > 0) {
		bao_hiem_tnds['type_tnds'] = type_tnds;
		bao_hiem_tnds['dung_tich_xe'] = mic_dung_tich_xe;
		bao_hiem_tnds['muc_trach_nhiem'] = mic_muc_trach_nhiem;
		bao_hiem_tnds['price_tnds'] = phi_tnds;
	} else if (type_tnds == 'VBI_TNDS' && phi_tnds > 0) {
		bao_hiem_tnds['type_tnds'] = type_tnds;
		bao_hiem_tnds['hieu_xe'] = hieu_xe;
		bao_hiem_tnds['hang_xe'] = hang_xe;
		bao_hiem_tnds['nhom_xe'] = nhom_xe;
		bao_hiem_tnds['price_tnds'] = phi_tnds;
	} else {
		bao_hiem_tnds = {}
	}
	var code_pti_vta = $("#code_pti_vta").val();
	var year_pti_vta = $("#year_pti_vta").val();
	var price_pti_vta = getFloat($("#price_pti_vta").val());
	if (!Number.isInteger(price_pti_vta)) {
		price_pti_vta = 0;
	}
	var code_fee = $('#code_fee').val();
	var bao_hiem_pti_vta = {};
	if (code_pti_vta != "" && year_pti_vta != "" && price_pti_vta != "") {
		bao_hiem_pti_vta['code_pti_vta'] = code_pti_vta;
		bao_hiem_pti_vta['year_pti_vta'] = year_pti_vta;
		bao_hiem_pti_vta['price_pti_vta'] = price_pti_vta;
		bao_hiem_pti_vta['code_fee'] = code_fee;
	} else {
		bao_hiem_pti_vta = {}
	}

	// PTI Bảo Hiểm Tai Nạn
	var pti_bhtn = {};
	var pti_bhtn_goi = $("#pti_bhtn").val();
	var pti_bhtn_phi = $("#phi_pti_bhtn").val();
	var pti_bhtn_price = $("#pti_bhtn_price").val();
	if (pti_bhtn_goi != "" && pti_bhtn_phi != "") {
		pti_bhtn['goi'] = pti_bhtn_goi;
		pti_bhtn['phi'] = getFloat(pti_bhtn_phi);
		pti_bhtn['price'] = getFloat(pti_bhtn_price);
	}

	var image_property = {};
	image_property['image_front'] = $('.wait img').attr('src');
	image_property['image_back'] = $('.wait1 img').attr('src');
	var decreaseProperty = getDecreaseProperty();
	// console.log($("#price_property").val());

	var price_property = $("#price_property").val().length != 0 ? getFloat($("#price_property").val()) : 0;
	var amount_money_max = $("#amount_money").val().length != 0 ? getFloat($("#amount_money").val()) : 0;
	var amount_money = $("#money").val() !== undefined ? getFloat($("#money").val()) : 0;
	var type_interest = $("#type_interest :selected").val();
	var number_day_loan = $("#number_day_loan").val() * 30;
	var period_pay_interest = $("#period_pay_interest").val();
	if ($('#insurrance').prop('checked') == true) {
		var insurrance_contract = 1;
	} else {
		var insurrance_contract = 2;
	}
	if ($('#is_free_gic_plt').prop('checked') == true) {
		var is_free_gic_plt = 1;
	} else {
		var is_free_gic_plt = 2;
	}

	var fee1 = $("#fee_vbi1").val() !== undefined ? getFloat($("#fee_vbi1").val()) : 0;
	var fee2 = $("#fee_vbi2").val() !== undefined ? getFloat($("#fee_vbi2").val()) : 0;
	var code_VBI_1 = $("#code_VBI_1").val() !== undefined ? ($("#code_VBI_1").val()) : 0;
	var code_VBI_2 = $("#code_VBI_2").val() !== undefined ? ($("#code_VBI_2").val()) : 0;
	var maVBI_1 = $("#maVBI_1").val() !== undefined ? getFloat($("#maVBI_1").val()) : 0;
	var maVBI_2 = $("#maVBI_2").val() !== undefined ? getFloat($("#maVBI_2").val()) : 0;

	var amount_VBI = $("#fee_vbi").val() !== undefined ? getFloat($("#fee_vbi").val()) : 0;


	var amount_GIC = $("#fee_gic").val() !== undefined ? getFloat($("#fee_gic").val()) : 0;
	var amount_GIC_easy = $("#fee_gic_easy").val() !== undefined ? getFloat($("#fee_gic_easy").val()) : 0;
	var amount_GIC_plt = $("#fee_gic_plt").val() !== undefined ? getFloat($("#fee_gic_plt").val()) : 0;
	var code_GIC_easy = $("[name='gic_easy'] :selected").text();
	var code_GIC_plt = $("[name='gic_plt'] :selected").text();

	var code_coupon = $("#code_coupon").val();
	var loan_purpose = $("#loan_purpose").val();
	var note = $("#note").val();

	var link_shop = $("#link_shop").val();

	loanInfor['link_shop'] = link_shop;
	loanInfor['code_VBI_1'] = code_VBI_1;
	loanInfor['code_VBI_2'] = code_VBI_2;
	loanInfor['amount_VBI'] = amount_VBI;
	loanInfor['amount_code_VBI_1'] = fee1;
	loanInfor['amount_code_VBI_2'] = fee2;
	loanInfor['maVBI_1'] = maVBI_1;
	loanInfor['maVBI_2'] = maVBI_2;


		var device_asset_location = {};
		device_asset_location['device_asset_location_id'] = $("#selectize_positioningDevices").val();
		device_asset_location['code'] = $('#selectize_positioningDevices :selected').text();
		loanInfor['device_asset_location'] = device_asset_location;


	loanInfor['type_loan'] = type_loan;

	loanInfor['code_coupon'] = code_coupon;
	loanInfor['type_property'] = type_property;
	loanInfor['name_property'] = name_property;
	loanInfor['loan_product'] = loan_product;
	loanInfor['bao_hiem_tnds'] = bao_hiem_tnds;
	loanInfor['bao_hiem_pti_vta'] = bao_hiem_pti_vta;
	loanInfor['pti_bhtn'] = pti_bhtn;
	if (code_type_property == 'XM' || code_type_property == 'OTO') {
		loanInfor['image_property'] = image_property;
	}
	loanInfor['decreaseProperty'] = decreaseProperty;
	loanInfor['price_property'] = price_property;
	loanInfor['amount_money_max'] = amount_money_max;
	loanInfor['code_GIC_easy'] = (code_GIC_easy == "Chọn gói bảo hiểm") ? "" : code_GIC_easy;
	loanInfor['code_GIC_plt'] = (code_GIC_plt.split("-", 1) == "Chọn gói bảo hiểm") ? "" : code_GIC_plt.split("-", 1)[0];
	loanInfor['amount_GIC_plt'] = amount_GIC_plt;
	if ($('[name="loan_insurance"]').val() == '1') {
		loanInfor['amount_GIC'] = amount_GIC;
		loanInfor['loan_insurance'] = '1';
		loanInfor['amount_MIC'] = 0;
	}
	if ($('[name="loan_insurance"]').val() == '2') {
		if (amount_money < 3000000) {
			loanInfor['amount_MIC'] = 0;
		} else {
			loanInfor['amount_MIC'] = amount_GIC;
		}
		loanInfor['loan_insurance'] = '2';
		loanInfor['amount_GIC'] = 0;
	}
	if ($('[name="loan_insurance"]').val() != '2' && $('[name="loan_insurance"]').val() != '1') {
		loanInfor['amount_MIC'] = 0;
		loanInfor['loan_insurance'] = '';
		loanInfor['amount_GIC'] = 0;
		insurrance_contract = 2;
	}

	if (is_free_gic_plt == 1) {
		amount_GIC_plt = 0;
	}
	if (!Number.isInteger(amount_money)) {
		amount_money = 0;
	}
	if (!Number.isInteger(amount_GIC)) {
		amount_GIC = 0;
	}
	if (!Number.isInteger(amount_GIC_easy)) {
		amount_GIC_easy = 0;
	}
	if (!Number.isInteger(amount_GIC_plt)) {
		amount_GIC_plt = 0;
	}
	if (!Number.isInteger(amount_VBI)) {
		amount_VBI = 0;
	}
	if (!Number.isInteger(phi_tnds)) {
		phi_tnds = 0;
	}

	pti_bhtn_phi = getFloat(pti_bhtn_phi);
    if (pti_bhtn_phi < 0) {
        pti_bhtn_phi = 0;
    }

	loanInfor['amount_GIC_easy'] = amount_GIC_easy;
	loanInfor['amount_loan'] = Number(amount_money - amount_GIC - amount_GIC_easy - amount_GIC_plt - amount_VBI - phi_tnds - price_pti_vta - pti_bhtn_phi);
	loanInfor['amount_money'] = Number(amount_money);
	loanInfor['type_interest'] = type_interest;
	loanInfor['number_day_loan'] = number_day_loan;
	loanInfor['period_pay_interest'] = period_pay_interest;
	loanInfor['insurrance_contract'] = insurrance_contract;
	loanInfor['is_free_gic_plt'] = is_free_gic_plt;
	loanInfor['loan_purpose'] = loan_purpose;
	loanInfor['note'] = note;
	return loanInfor;
}

$(document).ready(function () {
	const number_phone_length = 10;
	//Check auto HĐ liên quan theo tên khách hàng
	$('#customer_name').change(function (event) {
		event.preventDefault();
		let customer_name = $('#customer_name').val();
		let formData = {customer_name: customer_name};
		ajax_contract_relative(formData);
	});

	//Check auto HĐ liên quan theo SĐT khách hàng và source lead
	$("#customer_phone_number").change(function (event) {
		event.preventDefault();
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
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				console.log(data)
				if (data.status == 200) {
					if (typeof data.check_phone.data.source != "undefined") {
						$("#customer_resources").val(data.check_phone.data.source);
						$("#customer_resources").prop('disabled', true);
						if (data.check_phone.data.source == 10) {
							$('#list_ctv_hide').show();
						}
						if (data.check_phone.data.source == 11) {
							$('#show_hide_presenter').show();
							$('#presenter_name').val(data.check_phone.data.presenter_name)
							$('#customer_phone_introduce').val(data.check_phone.data.customer_phone_introduce)
							$('#presenter_bank').val(data.check_phone.data.presenter_bank)
							$('#presenter_stk').val(data.check_phone.data.presenter_stk)
							$('#presenter_cmt').val(data.check_phone.data.presenter_cmt)
						}
					}
					if (typeof data.check_phone.data.source_pgd != "undefined") {
						$("#customer_resources").val(data.check_phone.data.source_pgd);
						$("#customer_resources").prop('disabled', true);
						$('#list_ctv_hide').hide();

					}
					toastr.error("Thời gian lead được tạo: " + data.check_phone.time + " ngày");
				} else {
					$("#customer_resources").val(1);
					$("#customer_resources").prop('disabled', false);
					$('#list_ctv_hide').hide();
					$('#show_hide_presenter').hide();

					$('#presenter_name').val("")
					$('#customer_phone_introduce').val("")
					$('#presenter_bank').val("")
					$('#presenter_stk').val("")
					$('#presenter_cmt').val("")
					$('#uploads_presenter_cmt').empty()

				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
		//Check hợp đồng liên quan theo SĐT khách hàng
		let formDataCustomer = {customer_phone_number: phone_number_source};
		ajax_contract_relative(formDataCustomer);
	});

	//Check hợp đồng liên quan theo SĐT khách hàng
	$('.customer_phone_number').change(function (event) {
		event.preventDefault();
		let customer_phone_number_input = $('.customer_phone_number').val();
		let formDataPhone = {customer_phone_number: customer_phone_number_input};
		if (customer_phone_number_input.length >= number_phone_length) {
			ajax_contract_relative(formDataPhone);
		}
	});

	//Check auto HĐ liên quan theo CMT/CCCD khách hàng
	$('#customer_identify').change(function (event) {
		event.preventDefault();
		let customer_identify = $('#customer_identify').val();
		let formData = {customer_identify: customer_identify};
		ajax_contract_relative(formData);
	});

	//Check auto HĐ liên quan theo CMT/CCCD cũ của khách hàng
	$('#customer_identify_old').change(function (event) {
		event.preventDefault();
		let customer_identify_old = $('#customer_identify_old').val();
		let formData = {customer_identify: customer_identify_old};
		ajax_contract_relative(formData);
	});

	//Check auto HĐ liên quan theo passport (hộ chiếu) của khách hàng
	$('#passport_number').change(function (event) {
		event.preventDefault();
		let passport_number = $('#passport_number').val();
		let formData = {passport_number: passport_number};
		ajax_contract_relative(formData);
	});

	//Check auto HĐ liên quan theo SĐT tham chiếu 1 của khách hàng
	$('#phone_number_relative_1').change(function (event) {
		event.preventDefault();
		let phone_number_relative_1 = $('#phone_number_relative_1').val();
		let formData = {phone_number_relative: phone_number_relative_1};
		if (phone_number_relative_1.length >= number_phone_length) {
			ajax_contract_relative(formData);
			ajax_check_staff_phone(formData);
		}
	});

	//Check auto HĐ liên quan theo SĐT tham chiếu 2 của khách hàng
	$('#phone_number_relative_2').change(function (event) {
		event.preventDefault();
		let phone_number_relative_2 = $('#phone_number_relative_2').val();
		let formData = {phone_number_relative: phone_number_relative_2};
		if (phone_number_relative_2.length >= number_phone_length) {
			ajax_contract_relative(formData);
			ajax_check_staff_phone(formData);
		}
	});

	//Check auto HĐ liên quan theo SĐT tham chiếu 3 của khách hàng
	$('#phone_relative_3').change(function (event) {
		event.preventDefault();
		let phone_relative_3 = $('#phone_relative_3').val();
		let formData = {phone_number_relative: phone_relative_3};
		if (phone_relative_3.length >= number_phone_length) {
			ajax_contract_relative(formData);
			ajax_check_staff_phone(formData);
		}
	});

	// Call Ajax get contract relative
	function ajax_contract_relative(formData) {
		$.ajax({
			url: _url.base_url + '/Ajax/check_contract_relative',
			method: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					let contract_ref = response.data;
					let html = '';
					if (contract_ref.length > 0) {
						$('#contractReference').modal('show');
						$('#list_contract_reference').children().remove();
						for (let i = 0; i < contract_ref.length; i++) {
							let bucket_contract = 'Không xác định';
							let case_bucket = 0;
							let status_contract = 'Không xác định';
							let time_slow_payment = contract_ref[i].debt.so_ngay_cham_tra ? contract_ref[i].debt.so_ngay_cham_tra : 0;
							let create_date = "";
							let the_number = i + 1;
							if (in_array(contract_ref[i].status, [1,2,3,4,5,6,7,8,9,10,15,19,33,34])) {
								time_slow_payment = '-';
							}
							let passport_number = contract_ref[i].customer_infor.passport_number ? contract_ref[i].customer_infor.passport_number : '';
							status_contract = get_status(contract_ref[i].status);
							case_bucket = get_case_bucket(time_slow_payment);
							bucket_contract = get_bucket_text(case_bucket);
							create_date = new Date(contract_ref[i].created_at * 1000).format('d/m/Y H:i:s')
							html += "<tr>" + "<td>" + the_number + "</td>";
							html += "<td><a href='" + _url.base_url + "pawn/detail?id=" + contract_ref[i]._id.$oid + "' target='_blank' data-toggle='tooltip' title='Xem chi tiết hợp đồng'>" + contract_ref[i].code_contract + "</a></td>";
							html += "<td><a href='" + _url.base_url + "accountant/view?id=" + contract_ref[i]._id.$oid + "' target='_blank' data-toggle='tooltip' title='Xem chi tiết thanh toán'>" + contract_ref[i].code_contract_disbursement + "</a></td>";
							html += "<td>" + contract_ref[i].customer_infor.customer_name + "</td>";
							html += "<td>" + hide_phone_js(contract_ref[i].customer_infor.customer_phone_number) + "</td>";
							html += "<td>" + contract_ref[i].customer_infor.customer_identify + "</td>";
							html += "<td>" + passport_number + "</td>";
							html += "<td>" + contract_ref[i].store.name + "</td>";
							html += "<td>" + status_contract + "</td>";
							html += "<td>" + time_slow_payment + "</td>";
							html += "<td>" + bucket_contract + "</td>";
							html += "<td>" + create_date.toLocaleString() + "</td>";
						}
						$('#list_contract_reference').append(html);
					}
				} else {
					$('#checkContractFalse').modal('show');
				}
			},
			error: function () {

			}
		})
	}

	// Call Ajax check SDT tham chiếu có trùng với SĐT của NV VFC ko
	function ajax_check_staff_phone(formData) {
		$.ajax({
			url: _url.base_url + '/Ajax/check_staff_phone',
			method: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				console.log(response)
				$('.theloading').hide();
				if (response.status == 400) {
					toastr.error(response.msg)
				} else {

				}
			},
			error: function () {

			}
		})
	}
});


function getCustomerInfor() {
	var customerInfor = {};
	var isCustomerNew = $("input[name='status_customer']:checked").val();
	var customerName = $("#customer_name").val();
	var customerEmail = $("#customer_email").val();
	var statusEmail = $("input[name='status_email']:checked").val();
	var typeContractSign = $("input[name='type_contract_sign']:checked").val();
	var customerPhoneNumber = $("#customer_phone_number").val();
	var customerIdentify = $("#customer_identify").val();
	var customerIdentifyDateRange = $("#date_range").val();
	var customerIdentifyIssuedBy = $("#issued_by").val();
	var customerIdentifyOld = $("#customer_identify_old").val();
	var customerGender = $("input[name='customer_gender']:checked").val();
	var customerBOD = $("#customer_BOD").val();
	var marriage = $("input[name='marriage']:checked").val();
	var customer_resources = $("#customer_resources").val();
	var list_ctv = $("#list_ctv").val();
	var isBlacklist = $("#isBlacklist").val();

	var passport_number = $("#passport_number").val();
	var passport_address = $("#passport_address").val();
	var passport_date = $("#passport_date").val();

	var presenter_name = $('#presenter_name').val();
	var customer_phone_introduce = $('#customer_phone_introduce').val();
	var presenter_bank = $('#presenter_bank').val();
	var presenter_stk = $('#presenter_stk').val();
	var presenter_cmt = $('#presenter_cmt').val();
	var count = $("img[name='img_file_presenter_cmt']").length;
	var img_file_presenter_cmt = {};

	if (count > 0) {
		$("img[name='img_file_presenter_cmt']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'cmt') {
				img_file_presenter_cmt[key] = data;
			}
		});
	}

	// var stay_with = $("input[name='stay_with']:checked").val();
	// var number_children = $("input[name='number_children']:checked").val();
	// var customerFb = $("#customer_fb").val();
	// var customerHousehold = $("#customer_household").val();
	// var customerPassport = $("#customer_passport").val();
	customerInfor['presenter_name'] = presenter_name;
	customerInfor['customer_phone_introduce'] = customer_phone_introduce;
	customerInfor['presenter_bank'] = presenter_bank;
	customerInfor['presenter_stk'] = presenter_stk;
	customerInfor['presenter_cmt'] = presenter_cmt;
	customerInfor['img_file_presenter_cmt'] = img_file_presenter_cmt;

	var id_lead = $("#id_lead").val();
	customerInfor['status_customer'] = isCustomerNew;
	customerInfor['customer_name'] = customerName;
	customerInfor['customer_email'] = customerEmail;
	customerInfor['status_email'] = statusEmail;
	customerInfor['type_contract_sign'] = typeContractSign;
	if (id_lead != "") {
		// customerInfor['customer_phone_number'] = window.atob(customerPhoneNumber);
		customerInfor['customer_phone_number'] = customerPhoneNumber;
	} else {
		customerInfor['customer_phone_number'] = customerPhoneNumber;
	}
	customerInfor['customer_identify'] = customerIdentify;
	customerInfor['date_range'] = customerIdentifyDateRange;
	customerInfor['issued_by'] = customerIdentifyIssuedBy;

	customerInfor['customer_identify_old'] = customerIdentifyOld;
	customerInfor['customer_gender'] = customerGender;
	customerInfor['customer_BOD'] = customerBOD;

	customerInfor['passport_number'] = passport_number;
	customerInfor['passport_address'] = passport_address;
	customerInfor['passport_date'] = passport_date;


	customerInfor['customer_resources'] = customer_resources;
	customerInfor['list_ctv'] = list_ctv;
	customerInfor['is_blacklist'] = isBlacklist;
	// customerInfor['customer_fb'] = customerFb;
	// customerInfor['customer_household'] = customerHousehold;
	// customerInfor['customer_passport'] = customerPassport;
	// customerInfor['customer_insurance'] = customerInsurence;
	customerInfor['marriage'] = marriage;
	customerInfor['id_lead'] = id_lead;
	// customerInfor['stay_with'] = stay_with;
	// customerInfor['number_children'] = number_children;
	customerInfor['img_id_front'] = $('#imgImg_mattruoc').attr('src');
	customerInfor['img_id_back'] = $('#imgImg_matsau').attr('src');
	customerInfor['img_portrait'] = $('#imgImg_chandung').attr('src');
	return customerInfor;
}

function getCustomerAddress() {
	var currentAddress = {};
	var province = $("#selectize_province_current_address").val();
	var province_name = $("#selectize_province_current_address option:selected").text();
	var district = $("#selectize_district_current_address").val();
	var district_name = $("#selectize_district_current_address option:selected").text();
	var ward = $("#selectize_ward_current_address").val();
	var ward_name = $("#selectize_ward_current_address option:selected").text();
	var formResidence = $("#form_residence_current_address").val();
	var timeLife = $("#time_life_current_address").val();
	var currentStay = $("#current_stay_current_address").val();
	currentAddress['province'] = province;
	currentAddress['province_name'] = province_name;
	currentAddress['district'] = district;
	currentAddress['district_name'] = district_name;
	currentAddress['ward'] = ward;
	currentAddress['ward_name'] = ward_name;
	currentAddress['form_residence'] = formResidence;
	currentAddress['time_life'] = timeLife;
	currentAddress['current_stay'] = currentStay;
	return currentAddress;
}

function getHouseholdAddress() {
	var householdAddress = {};
	var province = $("#selectize_province_household").val();
	var province_name = $("#selectize_province_household option:selected").text();
	var district = $("#selectize_district_household").val();
	var district_name = $("#selectize_district_household option:selected").text();
	var ward = $("#selectize_ward_household").val();
	var ward_name = $("#selectize_ward_household option:selected").text();
	var addressHousehold = $("#address_household").val();
	householdAddress['province'] = province;
	householdAddress['province_name'] = province_name;
	householdAddress['district'] = district;
	householdAddress['district_name'] = district_name;
	householdAddress['ward'] = ward;
	householdAddress['ward_name'] = ward_name;
	householdAddress['address_household'] = addressHousehold;
	return householdAddress;
}


function getJobInfor() {
	var jobInfor = {};
	// var nameJob = $("#name_job").val();
	var nameCompany = $("#name_company").val();
	var phoneNumberCompany = $("#phone_number_company").val();
	// var numberTaxCompany = $("#number_tax_company").val();
	var addressCompany = $("#address_company").val();
	var salary = $("#salary").val().length != 0 ? getFloat($("#salary").val()) : 0;
	var receiveSalaryVia = $("#receive_salary_via").val();
	var jobPosition = $("#job_position").val();
	var job = $("#job").val();
	var work_year = $("#work_year").val();
	// jobInfor['name_job'] = nameJob;
	jobInfor['name_company'] = nameCompany;
	jobInfor['phone_number_company'] = phoneNumberCompany;
	// jobInfor['number_tax_company'] = numberTaxCompany;
	jobInfor['address_company'] = addressCompany;
	jobInfor['salary'] = salary;
	jobInfor['receive_salary_via'] = receiveSalaryVia;
	jobInfor['job_position'] = jobPosition;
	jobInfor['job'] = job;
	jobInfor['work_year'] = work_year;
	return jobInfor;
}

function getRelativeInfor() {
	var relativeInfor = {};
	var type_relative_1 = $("#type_relative_1").val();
	var fullname_relative_1 = $("#fullname_relative_1").val();
	var phone_number_relative_1 = $("#phone_number_relative_1").val();
	var hoursehold_relative_1 = $("#hoursehold_relative_1").val();
	var confirm_relativeInfor_1 = $("#confirm_relativeInfor1").val();
	var type_relative_2 = $("#type_relative_2").val();
	var fullname_relative_2 = $("#fullname_relative_2").val();
	var phone_number_relative_2 = $("#phone_number_relative_2").val();
	var hoursehold_relative_2 = $("#hoursehold_relative_2").val();
	var confirm_relativeInfor_2 = $("#confirm_relativeInfor2").val();
	var fullname_relative_3 = $("#fullname_relative_3").val();
	var address_relative_3 = $("#address_relative_3").val();
	var phone_relative_3 = $("#phone_relative_3").val();
	var type_relative_3 = $("#type_relative_3").val();
	var confirm_relativeInfor3 = $("#confirm_relativeInfor3").val();
	var loan_security_one = $("input[name='loan_security_one']:checked").val();
	var loan_security_two = $("input[name='loan_security_two']:checked").val();
	var loan_security_three = $("input[name='loan_security_three']:checked").val();


	relativeInfor['type_relative_1'] = type_relative_1;
	relativeInfor['fullname_relative_1'] = fullname_relative_1;
	relativeInfor['phone_number_relative_1'] = phone_number_relative_1;
	relativeInfor['loan_security_1'] = loan_security_one;
	relativeInfor['hoursehold_relative_1'] = hoursehold_relative_1;
	relativeInfor['confirm_relativeInfor_1'] = confirm_relativeInfor_1;
	relativeInfor['type_relative_2'] = type_relative_2;
	relativeInfor['fullname_relative_2'] = fullname_relative_2;
	relativeInfor['phone_number_relative_2'] = phone_number_relative_2;
	relativeInfor['loan_security_2'] = loan_security_two;
	relativeInfor['hoursehold_relative_2'] = hoursehold_relative_2;
	relativeInfor['confirm_relativeInfor_2'] = confirm_relativeInfor_2;
	relativeInfor['fullname_relative_3'] = fullname_relative_3;
	relativeInfor['address_relative_3'] = address_relative_3;
	relativeInfor['phone_relative_3'] = phone_relative_3;
	relativeInfor['loan_security_3'] = loan_security_three;
	relativeInfor['type_relative_3'] = type_relative_3;
	relativeInfor['confirm_relativeInfor3'] = confirm_relativeInfor3;

	return relativeInfor;
}


function getReceiverInfor() {
	var ReceiverInfor = {};
	var type_payout = $("#type_payout :checked").val();
	var amount = $("#money").val().length != 0 ? getFloat($("#money").val()) : 0;
	var bank_id = $("#selectize_bank_vimo :checked").val();
	var bank_name = $("#selectize_bank_vimo :checked").text();
	// var description = $("#description_bank").val();
	var atm_card_number = $("#atm_card_number").val();
	var atm_card_holder = $("#atm_card_holder").val();
	var bank_account = $("#bank_account").val();
	var bank_account_holder = $("#bank_account_holder").val();
	var bank_branch = $("#bank_branch").val();
	ReceiverInfor['type_payout'] = type_payout;
	ReceiverInfor['amount'] = amount;
	ReceiverInfor['bank_id'] = bank_id;
	ReceiverInfor['bank_name'] = bank_name;
	// ReceiverInfor['description'] = description;
	ReceiverInfor['atm_card_number'] = atm_card_number;
	ReceiverInfor['atm_card_holder'] = atm_card_holder;
	ReceiverInfor['bank_account'] = bank_account;
	ReceiverInfor['bank_account_holder'] = bank_account_holder;
	ReceiverInfor['bank_branch'] = bank_branch;
	return ReceiverInfor;
}


$('#company_debt').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#company_borrowing').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});


function formatCurrency(number) {
	var n = number.split('').reverse().join("");
	var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
	return n2.split('').reverse().join('');
}


$(".modal_company").click(function (event) {
	event.preventDefault();
	$("input[name='company_name']:selected").val();
	$("input[name='company_name_other']").val();
	$("input[name='company_debt']").val();
	$("input[name='company_finalization']").val();
	$("input[name='company_borrowing']").val();
	$("input[name='company_out_of_date']").val();

});

$(".company_close").click(function (event) {
	event.preventDefault();
	$("input[name='company_name']:selected").val();
	$("input[name='company_name_other']").val("");
	$("input[name='company_debt']").val("");
	$("input[name='company_finalization']").val("");
	$("input[name='company_borrowing']").val("");
	$("input[name='company_out_of_date']").val("");

});


var count_company = $("#add_company").children().length - 1;
var listData = [];
$("#company_btnSave").click(function (event) {
	count_company = count_company + 1;
	event.preventDefault();

	var data = {};
	data['count'] = count_company;
	data['company_name'] = $("#company_name").val();
	data['company_name_other'] = $("input[name='company_name_other']").val();
	data['company_debt'] = $("input[name='company_debt']").val();
	data['company_finalization'] = $("input[name='company_finalization']").val();
	data['company_borrowing'] = $("input[name='company_borrowing']").val();
	data['company_out_of_date'] = $("input[name='company_out_of_date']").val();

	if (data['company_name'] == "khac") {
		data['company_name'] = data['company_name_other'];
	}

	temp = "<tr id='add_" + count_company + "'><td>" + data['company_name'] + "</td><td>" + data['company_debt'] + "</td><td>" + data['company_finalization'] + "</td><td>" + data['company_borrowing'] + "</td><td>" + data['company_out_of_date'] + "</td><td><button data-id='" + count_company + "' onclick='remove_company(this)' ><i class='fa fa-trash' style='color: red' aria-hidden='true'></i></button></td></tr>";
	$("#add_company").append(temp);
	listData[count_company] = data;

	sessionStorage.setItem('company_storage', JSON.stringify(listData));
	$('#addNewCompanyModal').modal('hide');
	$("input[name='company_name']:selected").val();
	$("input[name='company_name_other']").val("");
	$("input[name='company_debt']").val("");
	$("input[name='company_finalization']").val("");
	$("input[name='company_borrowing']").val("");
	$("input[name='company_out_of_date']").val("");

});


function remove_company(thiz) {
	var id = $(thiz).attr('data-id');
	$("#add_" + id).remove();
	listData.splice(id, 1);
	sessionStorage.setItem('company_storage', JSON.stringify(listData));
}

$('#company_btnUpdate').click(function (event) {
	event.preventDefault();

	var company_name = $("#company_name").val();
	var company_name_other = $("input[name='company_name_other']").val();
	var company_debt = $("input[name='company_debt']").val();
	var company_finalization = $("input[name='company_finalization']").val();
	var company_borrowing = $("input[name='company_borrowing']").val();
	var company_out_of_date = $("input[name='company_out_of_date']").val();
	var check_phone = $("#customer_phone_number1").val();


	var formData = new FormData();
	formData.append('company_name', company_name);
	formData.append('company_name_other', company_name_other);
	formData.append('company_debt', company_debt);
	formData.append('company_finalization', company_finalization);
	formData.append('company_borrowing', company_borrowing);
	formData.append('company_out_of_date', company_out_of_date);
	formData.append('check_phone', check_phone);

	$('#addNewCompanyModal').modal('hide');
	$.ajax({
		url: _url.base_url + 'pawn/insert_company_storage',
		type: "POST",
		data: formData,
		dataType: 'json',
		processData: false,
		contentType: false,
		// beforeSend: function(){$(".theloading").show();},
		success: function (data) {
			if (data.status == 200) {

				if (data.data.data.company_name == "khac") {
					data.data.data.company_name = data.data.data.company_name_other;
				}

				temp = "<tr id='company-" + data.data.data._id.$oid + "'><td>" + data.data.data.company_name + "</td><td>" + data.data.data.company_debt + "</td><td>" + data.data.data.company_finalization + "</td><td>" + data.data.data.company_borrowing + "</td><td>" + data.data.data.company_out_of_date + "</td><td><button class='del-company' data-id='" + data.data.data._id.$oid + "'><i class='fa fa-trash' style='color: red' aria-hidden='true'></i></button></td></tr>";
				$("#add_company").append(temp);
				$("input[name='company_name']:selected").val("");
				$("input[name='company_name_other']").val("");
				$("input[name='company_debt']").val("");
				$("input[name='company_finalization']").val("");
				$("input[name='company_borrowing']").val("");
				$("input[name='company_out_of_date']").val("");
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
})

function deleteCompany(id) {
	var formData = new FormData();
	formData.append('id', id);

	$.ajax({
		url: _url.base_url + 'pawn/delete_company_storage',
		type: "POST",
		data: formData,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function (data) {
			if (data.status == 200) {
				$('#company-' + id).remove();
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
}

// $('.del-company').click(function (event){
// 	event.preventDefault();
//
// 	if (confirm('Bạn có chắc chắn muốn xóa?')){
// 		let id = $(this).attr('data-id');
//
// 		deleteCompany(id)
// 	}
//
// });

$('body').on('click', '.del-company', function (event) {
	event.preventDefault();
	if (confirm('Bạn có chắc chắn muốn xóa?')) {
		let id = $(this).attr('data-id');
		deleteCompany(id)
	}
})


$('#company_name').change(function (event) {
	event.preventDefault();
	let company_name = $("#company_name").val();
	if (company_name == "khac") {
		$('#show_company_name').show();
	} else {
		$('#show_company_name').hide();
	}
})


function getExpertiseInfor() {
	var ExpertiseInfor = {};
	var expertise_file = $("#expertise_file").val();
	var expertise_field = $("#expertise_field").val();
	var car_storage = $("#car_storage").val();


	if (sessionStorage.getItem('company_storage') != "") {
		var company_storage = JSON.parse(sessionStorage.getItem('company_storage'));
		ExpertiseInfor['company_storage'] = company_storage;
	}

	if ($('#exception1_value').val() != "") {
		var exception1_value = JSON.parse($('#exception1_value').val());
		ExpertiseInfor['exception1_value'] = exception1_value;
	}
	if ($('#exception2_value').val() != "") {
		var exception2_value = JSON.parse($('#exception2_value').val());
		ExpertiseInfor['exception2_value'] = exception2_value;
	}
	if ($('#exception3_value').val() != "") {
		var exception3_value = JSON.parse($('#exception3_value').val());
		ExpertiseInfor['exception3_value'] = exception3_value;
	}
	if ($('#exception4_value').val() != "") {
		var exception4_value = JSON.parse($('#exception4_value').val());
		ExpertiseInfor['exception4_value'] = exception4_value;
	}
	if ($('#exception5_value').val() != "") {
		var exception5_value = JSON.parse($('#exception5_value').val());
		ExpertiseInfor['exception5_value'] = exception5_value;
	}
	if ($('#exception6_value').val() != "") {
		var exception6_value = JSON.parse($('#exception6_value').val());
		ExpertiseInfor['exception6_value'] = exception6_value;
	}
	if ($('#exception7_value').val() != "") {
		var exception7_value = JSON.parse($('#exception7_value').val());
		ExpertiseInfor['exception7_value'] = exception7_value;
	}

	ExpertiseInfor['expertise_file'] = expertise_file;
	ExpertiseInfor['expertise_field'] = expertise_field;
	ExpertiseInfor['car_storage'] = car_storage;

	return ExpertiseInfor;
}

function getStoreInfor() {
	var StoreInfor = {};
	var id = $("#stores").val();
	// var id = $("#stores :selected").val();
	var address = $("#stores :selected").attr('data-address');
	var code_address = $("#stores :selected").attr('data-code-address');
	var name = $("#stores :selected").text();
	StoreInfor['id'] = id;
	StoreInfor['name'] = name;
	StoreInfor['address'] = address;
	StoreInfor['code_address'] = code_address;
	return StoreInfor;
}

function typePayout() {
	var typePayout = $('#type_payout').val();
	$("#bank_branch").val();
	$("#bank_account").val();
	$("#bank_account_holder").val();
	$("#atm_card_number").val();
	$("#atm_card_holder").val();
	var accountType = 3;
	if (typePayout == 2) {
		$("#atm_card_number").prop('disabled', true);
		$("#atm_card_holder").prop('disabled', true);
		$("#bank_branch").prop('disabled', false);
		$("#bank_account").prop('disabled', false);
		$("#bank_account_holder").prop('disabled', false);
	}
	if (typePayout == 3) {
		$("#atm_card_number").prop('disabled', false);
		$("#atm_card_holder").prop('disabled', false);
		$("#bank_branch").prop('disabled', true);
		$("#bank_account").prop('disabled', true);
		$("#bank_account_holder").prop('disabled', true);
		accountType = 2;
	}
	// var formData = {
	//     account_type: accountType
	// };
	// $.ajax({
	//     url :  _url.base_url + '/Ajax/get_bank_nganluong',
	//     type: "POST",
	//     data : formData,
	//     dataType : 'json',
	//     beforeSend: function(){$("#loading").show();},
	//     success: function(data) {
	//         console.log(data);
	//         if (data.res) {
	//           var selectClass = $('#selectize_bank_vimo').selectize();
	//           var selectizeClass = selectClass[0].selectize;
	//           selectizeClass.clear();
	//           selectizeClass.clearOptions();
	//           selectizeClass.load(function(callback) {
	//               callback(data.data);
	//           });


	//         } else {

	//         }
	//     },
	//     error: function(data) {
	//         // console.log(data);
	//         // $("#loading").hide();
	//     }
	// });


}

$(document).ready(function () {

	$('#change_exception').change(function (event) {
		event.preventDefault();
		var change_exception = $('#change_exception').val();
		if (change_exception == "E1") {
			$('#exception1').show();
		} else if (change_exception == "E2") {
			$('#exception2').show();
		} else if (change_exception == "E3") {
			$('#exception3').show();
		} else if (change_exception == "E4") {
			$('#exception4').show();
		} else if (change_exception == "E5") {
			$('#exception5').show();
		} else if (change_exception == "E6") {
			$('#exception6').show();
		} else if (change_exception == "E7") {
			$('#exception7').show();
		}
	})

});

$('[name="lead_exception_E1[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E1').val()
	var data1 = [];
	if (value != null) {
		data1.push(value);
	}
	$('#exception1_value').val(JSON.stringify(data1));
})
$('[name="lead_exception_E2[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E2').val()
	var data2 = [];
	if (value != null) {
		data2.push(value);
	}
	$('#exception2_value').val(JSON.stringify(data2));
})
$('[name="lead_exception_E3[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E3').val()
	var data3 = [];
	if (value != null) {
		data3.push(value);
	}
	$('#exception3_value').val(JSON.stringify(data3));
})
$('[name="lead_exception_E4[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E4').val()
	var data4 = [];
	if (value != null) {
		data4.push(value);
	}
	$('#exception4_value').val(JSON.stringify(data4));
})
$('[name="lead_exception_E5[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E5').val()
	var data5 = [];
	if (value != null) {
		data5.push(value);
	}
	$('#exception5_value').val(JSON.stringify(data5));
})
$('[name="lead_exception_E6[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E6').val()
	var data6 = [];
	if (value != null) {
		data6.push(value);
	}
	$('#exception6_value').val(JSON.stringify(data6));
})
$('[name="lead_exception_E7[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E7').val()
	var data7 = [];
	if (value != null) {
		data7.push(value);
	}
	$('#exception7_value').val(JSON.stringify(data7));
})


$('#lead_exception_E1').selectize({
	create: false,
	valueField: 'lead_exception_E1',
	labelField: 'name1',
	searchField: 'name1',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}

});
$('#lead_exception_E2').selectize({
	create: false,
	valueField: 'lead_exception_E2',
	labelField: 'name2',
	searchField: 'name2',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E3').selectize({
	create: false,
	valueField: 'lead_exception_3',
	labelField: 'name3',
	searchField: 'name3',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E4').selectize({
	create: false,
	valueField: 'lead_exception_E4',
	labelField: 'name4',
	searchField: 'name4',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E5').selectize({
	create: false,
	valueField: 'lead_exception_E5',
	labelField: 'name5',
	searchField: 'name5',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E6').selectize({
	create: false,
	valueField: 'lead_exception_E6',
	labelField: 'name6',
	searchField: 'name1',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E7').selectize({
	create: false,
	valueField: 'lead_exception_E7',
	labelField: 'name7',
	searchField: 'name7',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$(document).ready(function () {

	$('#exception1_del').click(function (event) {
		event.preventDefault();
		$('#exception1').hide();
		$('#lead_exception_E1')[0].selectize.clear();
	});
	$('#exception2_del').click(function (event) {
		event.preventDefault();
		$('#exception2').hide();
		$('#lead_exception_E2')[0].selectize.clear();
	});
	$('#exception3_del').click(function (event) {
		event.preventDefault();
		$('#exception3').hide();
		$('#lead_exception_E3')[0].selectize.clear();
	});
	$('#exception4_del').click(function (event) {
		event.preventDefault();
		$('#exception4').hide();
		$('#lead_exception_E4')[0].selectize.clear();
	});
	$('#exception5_del').click(function (event) {
		event.preventDefault();
		$('#exception5').hide();
		$('#lead_exception_E5')[0].selectize.clear();
	});
	$('#exception6_del').click(function (event) {
		event.preventDefault();
		$('#exception6').hide();
		$('#lead_exception_E6')[0].selectize.clear();
	});
	$('#exception7_del').click(function (event) {
		event.preventDefault();
		$('#exception7').hide();
		$('#lead_exception_E7')[0].selectize.clear();
	});
});

function get_status($status) {
	var status_text = "Chưa xác định";
	switch ($status) {
		case 0:
			status_text = "Nháp";
			break;
		case 1:
			status_text = "Mới";
			break;
		case 2:
			status_text = "Chờ trưởng PGD duyệt";
			break;
		case 3:
			status_text = "Đã hủy";
			break;
		case 4:
			status_text = "Trưởng PGD không duyệt";
			break;
		case 5:
			status_text = "Chờ hội sở duyệt";
			break;
		case 6:
			status_text = "Đã duyệt";
		case 7:
			status_text = "Kế toán không duyệt";
			break;
		case 8:
			status_text = "Hội sở không duyệt";
			break;
		case 9:
			status_text = "Chờ ngân lượng xử lý";
			break;
		case 10:
			status_text = "Giải ngân ngân lượng thất bại";
			break;
		case 11:
			status_text = "Chờ TP QLHDV duyệt gia hạn";
			break;
		case 12:
			status_text = "Chờ TP QLHDV duyệt cơ cấu";
			break;
		case 13:
			status_text = "TP QLHDV không duyệt gia hạn";
			break;
		case 14:
			status_text = "TP QLHDV không duyệt cơ cấu";
			break;
		case 15:
			status_text = "Chờ giải ngân";
			break;
		case 16:
			status_text = "Đã tạo lệnh giải ngân thành công";
		case 17:
			status_text = "Đang vay";
			break;
		case 18:
			status_text = "Giải ngân thất bại";
			break;
		case 19:
			status_text = "Đã tất toán";
			break;
		case 20:
			status_text = "Đã quá hạn";
			break;
		case 21:
			status_text = "Chờ hội sở duyệt gia hạn";
			break;
		case 22:
			status_text = "Chờ kế toán duyệt gia hạn";
		case 23:
			status_text = "Đã gia hạn";
			break;
		case 24:
			status_text = "Chờ kế toán xác nhận";
			break;
		case 25:
			status_text = "Chờ hội sở duyệt gia hạn";
			break;
		case 26:
			status_text = "Hội sở không duyệt gia hạn";
			break;
		case 27:
			status_text = "Chờ hội sở duyệt cơ cấu";
			break;
		case 28:
			status_text = "Hội sở không duyệt cơ cấu";
			break;
		case 29:
			status_text = "Chờ tạo phiếu thu gia hạn";
			break;
		case 30:
			status_text = "Chờ ASM duyệt gia hạn";
			break;
		case 31:
			status_text = "Chờ tạo phiếu thu cơ cấu";
		case 32:
			status_text = "Chờ ASM duyệt cơ cấu";
			break;
		case 33:
			status_text = "Đã gia hạn";
			break;
		case 34:
			status_text = "Đã cơ cấu";
			break;
		case 35:
			status_text = "Chờ ASM duyệt";
			break;
		case 36:
			status_text = "ASM không duyệt";
			break;
		case 37:
			status_text = "Chờ thanh lý";
		case 38:
			status_text = "Chờ CEO duyệt thanh lý";
			break;
		case 39:
			status_text = "Chờ TP THN thanh lý tài sản";
			break;
		case 40:
			status_text = "Chờ tạo phiếu thu thanh lý tài sản";
			break;
		case 41:
			status_text = "ASM không duyệt gia hạn";
			break;
		case 42:
			status_text = "ASM không duyệt cơ cấu";
			break;
		case 43:
			status_text = "CEO không duyệt thanh lý xe";
		case 44:
			status_text = "Chờ định giá tài sản thanh lý";
			break;
		case 45:
			status_text = "BPĐG trả về yêu cầu định giá tài sản";
			break;
		case 46:
			status_text = "Chờ TPTHN cập nhật giá tham khảo";
			break;
		case 47:
			status_text = "Chờ TPTHN duyệt thay CEO";
			break;
		case 48:
			status_text = "Chờ bán tài sản thanh lý";
			break;
		case 49:
			status_text = "Chờ BPĐG định giá lại";
			break;
	}
	return status_text;
}

$(document).ready(function () {


	$('#type_property').change(function (event) {
		event.preventDefault();
		var type_loan_1 = $('#type_loan').val();
		var type_property_1 = $('#type_property').val();
		if (type_loan_1 == "Cho vay" && type_property_1 == "5db7e6b4d6612b173e0728a4") {
			$('#loan_product_18').show();
		} else {
			$('#loan_product').val("");
			$('#loan_product_18').hide();
		}
	});

	$('#type_loan').change(function (event) {
		event.preventDefault();


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
									html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='7' type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
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
			if (check_loan_product_1 == 14) {
				var price_property_asset_1 = getFloat($('#price_property').val());
				var result_total_4 = price_property_asset_1 * 0.8;
				if (check_type_property_1 == "5db7e6bfd6612bceec515b76") {
					result_total_4 = price_property_asset_1 * 0.6;
				}
				if (check_type_property_1 == "5f213c10d6612b465f4cb7b6") {
					result_total_4 = price_property_asset_1;
				}
				$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
			}
			if (check_loan_product_1 == 18 ||  check_loan_product_1 == 3) {
				var price_property_asset_1 = getFloat($('#price_property').val());
				var result_total_4 = price_property_asset_1 * 0.5;

				$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
			}
			if (check_loan_product_1 == 7 ) {
				var price_property_asset_1 = getFloat($('#price_property').val());
				var result_total_4 = price_property_asset_1 * 0.7;

				$("input[name='amount_money']").val(numeral(result_total_4).format('0,0'));
			}
		}


	});

	var check_type_loan_update = $('#type_loan').val();
	var check_type_property_update = $('#type_property').val();


	if (check_type_property_update == "606aceb461a5d8511f0c4d33") {
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
		$('#loan_product_18').hide();
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
		$('#loan_product_18').show();
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
		$('#loan_product_18').hide();
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
		$('#loan_product_18').hide();
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
		$('#loan_product_18').hide();
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
		$('#loan_product_18').hide();
	}

	$("#type_property option[value=" + '5f213c10d6612b465f4cb7b6' + "]").hide();


	var loan_product_update = $("#loan_product").val();
	if (loan_product_update == 14) {
		$('#kdol_v').show();
	}


});

var array = [];
var count = [];
$('#loan_product').change(function (event) {
	event.preventDefault();
	var check_loan_product = $("#loan_product").val();
	array.push(check_loan_product);
	var price_property_asset = getFloat($('#price_property').val());
	//5db7e6b4d6612b173e0728a4 - Xe Máy
	//5db7e6bfd6612bceec515b76 - Ô tô
	//5f213c10d6612b465f4cb7b6 - Tín chấp
	var check_type_property_new = $("#type_property").val();
	if (check_loan_product == 14) {
		$('#kdol_v').show();
		$('#show_hide_linkShop').show();
		var result_total = price_property_asset * 0.8;
		if (check_type_property_new == "5db7e6bfd6612bceec515b76") {
			result_total = price_property_asset * 0.6;
		}
		if (check_type_property_new == "5f213c10d6612b465f4cb7b6") {
			result_total = price_property_asset;
		}

		$("input[name='amount_money']").val(numeral(result_total).format('0,0'));
		// if (check_type_property_new == "5f213c10d6612b465f4cb7b6"){
		// 	$("#type_interest_motobike").hide();
		// 	$("#type_interest").val(1)
		// } else {
		// 	$("#type_interest_motobike").show();
		// }
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
							html += "<div class='form-group'></div><label class='control-label col-lg-3 col-md-3 col-sm-3 col-xs-12'>" + content[i].name + "<span class='text-danger'>*</span></label><div class='col-lg-9 col-md-6 col-sm-6 col-xs-12'><input maxlength='7' type='text' name='property_infor' required class='form-control property-infor' id='" + content[i].slug + "' data-slug='" + content[i].slug + "' data-name='" + content[i].name + "' placeholder='" + content[i].name + "'></div></div>"
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
	var user_nextpay = $('#user_nextpay').val();
	if (check_loan_product == 14 && check_type_loan_change == "Cho vay" && check_type_property_change == "5db7e6b4d6612b173e0728a4") {
		$('#type_interest_motobike').show();
		$('#number_day_loan_motobike').show();
		$("#number_day_loan option[value=" + 3 + "]").show();
	}

	if (check_loan_product != 14 && check_type_loan_change == "Cho vay" && check_type_property_change == "5db7e6b4d6612b173e0728a4") {
		if (user_nextpay == 1) {
			$('#type_interest_motobike').show();
			$('#number_day_loan_motobike').show();
			$("#number_day_loan option[value=" + 3 + "]").show();
		} else {
			$('#type_interest_motobike').hide();
			$('#number_day_loan_motobike').hide();
			$("#number_day_loan option[value=" + 3 + "]").hide();
		}
		$('#type_interest').val(1);
	}

	if (check_loan_product == 19){
		// $("#number_day_loan option[value=" + 3 + "]").hide();
		$('#toggle_positioningDevices').show();

	} else {
		// $("#number_day_loan option[value=" + 3 + "]").show();
		$('#toggle_positioningDevices').hide()

	}




});

$(document).ready(function () {

	$('#customer_resources').change(function (event) {
		event.preventDefault();
		var check_ctv_resources = $('#customer_resources').val();
		if (check_ctv_resources == 10) {
			$('#list_ctv_hide').show();
		}
		if (check_ctv_resources != 10) {
			$('#list_ctv_hide').hide();
			$('#list_ctv').val("");
		}

	});

	var check_ctv_resources_update = $('#customer_resources').val();
	if (check_ctv_resources_update == 10) {
		$('#list_ctv_hide').show();
	}
});

$(document).ready(function () {

	$('#type_property').change(function (event) {
		event.preventDefault();
		let type_property_checkhs = $('#type_property').val();
		let type_interest_checkhs = $('#type_interest').val();
		//5db7e6bfd6612bceec515b76 - ô tô
		if (type_property_checkhs == "5db7e6bfd6612bceec515b76" && type_interest_checkhs == 2) {
			$('#number_day_loan').val("");
			$('#value9').hide();
			$('#value12').hide();
			$('#value18').hide();
			$('#value24').hide();
		} else {
			$('#number_day_loan').val("");
			$('#value9').show();
			$('#value12').show();
			$('#value18').show();
			$('#value24').show();
		}
	});

	$('#type_interest').change(function (event) {
		event.preventDefault();
		let type_property_checkhs = $('#type_property').val();
		let type_interest_checkhs = $('#type_interest').val();
		if (type_property_checkhs == "5db7e6bfd6612bceec515b76" && type_interest_checkhs == 2) {
			$('#number_day_loan').val("");
			$('#value9').hide();
			$('#value12').hide();
			$('#value18').hide();
			$('#value24').hide();
		} else {
			$('#number_day_loan').val("");
			$('#value9').show();
			$('#value12').show();
			$('#value18').show();
			$('#value24').show();
		}
	});

	$('#number_day_loan').click(function (event) {
		event.preventDefault();
		let type_property_checkhs_up = $('#type_property').val();
		let type_interest_checkhs_up = $('#type_interest').val();

		if (type_property_checkhs_up == "5db7e6bfd6612bceec515b76" && type_interest_checkhs_up == 2) {
			$('#value9').hide();
			$('#value12').hide();
			$('#value18').hide();
			$('#value24').hide();
		}
	});
});

function typePropertyChangeAction() {
	var check_type_loan = $('#type_loan').val();
	var check_type_property = $('#type_property').val();
	console.log('xxxxx');
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
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6bfd6612bceec515b76") {
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
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cho vay" && check_type_property == "5db7e6b4d6612b173e0728a4") {
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
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6bfd6612bceec515b76") {
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
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Cầm cố" && check_type_property == "5db7e6b4d6612b173e0728a4") {
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
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	} else if (check_type_loan == "Tín chấp") {
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
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
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
		let value_loan = $("#loan_product option[selected=selected][style='display:block;']").val();
		console.log(value_loan);
		$('#loan_product').val(value_loan);
	}
}

$(document).ready(function () {
	if ($('#choose_contract_paper').prop('checked') == true) {
		$('#receive_notifi_sign').hide();
	}
	});

$('#choose_contract_paper').click(function (event) {
	if ($('#choose_contract_paper').prop('checked') == true) {
		$('#receive_notifi_sign').addClass('d-none');
		$('#receive_notifi_sign').hide();
	}
});
$('#choose_contract_digital').click(function (event) {
	if ($('#choose_contract_digital').prop('checked') == true) {
		$('#receive_notifi_sign').removeClass('d-none');
		$('#receive_notifi_sign').show();
	}
});

var check_positioning = $('#loan_product').val();
if(check_positioning == 19){
	// $("#number_day_loan option[value=" + 3 + "]").hide();

} else {
	// $("#number_day_loan option[value=" + 3 + "]").show();
}

//Lấy case nhóm
function get_case_bucket(time_slow_payment) {
	let case_bucket = 0;
	if (time_slow_payment < 0) {
		case_bucket = 0;
	} else if (time_slow_payment == 0) {
		case_bucket = 1;
	} else if (time_slow_payment >= 1 && time_slow_payment <= 9) {
		case_bucket = 2;
	} else if (time_slow_payment >= 10 && time_slow_payment <= 30) {
		case_bucket = 3;
	} else if (time_slow_payment >= 31 && time_slow_payment <= 60) {
		case_bucket = 4;
	} else if (time_slow_payment >= 61 && time_slow_payment <= 90) {
		case_bucket = 5;
	} else if (time_slow_payment >= 91 && time_slow_payment <= 120) {
		case_bucket = 6;
	} else if (time_slow_payment >= 121 && time_slow_payment <= 150) {
		case_bucket = 7;
	} else if (time_slow_payment >= 151 && time_slow_payment <= 180) {
		case_bucket = 8;
	} else if (time_slow_payment >= 181 && time_slow_payment <= 360) {
		case_bucket = 9;
	} else {
		case_bucket = 10;
	}
	if (time_slow_payment == '-') {
		case_bucket = 11;
	}
	return case_bucket;
}

//Lấy tên nhóm
function get_bucket_text(case_bucket) {
	let bucket_contract = "Không xác định";
	switch (case_bucket) {
		case 0:
			bucket_contract = '<span class="label label-success">Chưa đến kỳ </span>';
			break;
		case 1:
			bucket_contract = '<span class="label label-info">Đến kỳ thanh toán</span>';
			break;
		case 2:
			bucket_contract = '<span class="label label-warning"> nhóm 1</span><br>( đủ tiêu chuẩn)';
			break;
		case 3:
			bucket_contract = '<span class="label label-warning"> nhóm 2</span><br>( cần chú ý)';
			break;
		case 4:
			bucket_contract = '<span class="label label-danger"> nhóm 3</span><br>( dưới tiêu chuẩn)';
			break;
		case 5:
			bucket_contract = '<span class="label label-danger"> nhóm 3</span><br>( dưới tiêu chuẩn)';
			break;
		case 6:
			bucket_contract = '<span class="label label-danger"> xấu nhóm 4</span><br>( nghi ngờ bị mất vốn)';
			break;
		case 7:
			bucket_contract = '<span class="label label-danger"> xấu nhóm 4</span><br>(  nghi ngờ bị mất vốn)';
			break;
		case 8:
			bucket_contract = '<span class="label label-danger"> xấu nhóm 4</span><br>(  nghi ngờ bị mất vốn)';
			break;
		case 9:
			bucket_contract = '<span class="label label-danger"> xấu nhóm 5</span><br>( có khả năng mất vốn)';
			break;
		case 10:
			bucket_contract = '<span class="label label-danger"> xấu nhóm 5</span><br>( có khả năng mất vốn)';
			break;
		case 11:
			bucket_contract = '<span>-</span>';
			break;
	}
	return bucket_contract;
}

//Ẩn số điện thoại, output: 0989****6789
function hide_phone_js(number, character = "*") {
	if (number !== undefined) {
		number = number.replace(/[^0-9]+/g, ''); /*ensureOnlyNumbers*/
		var length = number.length;
		return number.substring(0, 4) + character.repeat(length - 7) + number.substring(length - 3, length);
	}
}

function in_array(needle, haystack) {
	let length = haystack.length;
	for (let i = 0; i < length; i++) {
		if (haystack[i] == needle) {
			return true;
		}
	}
	return false;
}

//Check auto contract relative by all infor customer
$(document).ready(function () {
	let customer_name = $("#customer_name").val();
	let customer_phone_number = $("#customer_phone_number").val();
	let customer_identify = $("#customer_identify").val();
	let customer_identify_old = $("#customer_identify_old").val();
	let passport_number = $("#passport_number").val();
	let phone_number_relative_1 = $("#phone_number_relative_1").val();
	let phone_number_relative_2 = $("#phone_number_relative_2").val();
	let phone_relative_3 = $("#phone_relative_3").val();
	let frame_number = $("#so-khung").val();
	let formDataCustomer = {
		customer_name: customer_name,
		customer_phone_number: customer_phone_number,
		customer_identify: customer_identify,
		customer_identify_old: customer_identify_old,
		passport_number: passport_number,
		phone_number_relative_1: phone_number_relative_1,
		phone_number_relative_2: phone_number_relative_2,
		phone_relative_3: phone_relative_3,
		frame_number: frame_number,
	};
	$.ajax({
		url: _url.base_url + '/Ajax/check_contract_relative_all',
		method: "POST",
		data: formDataCustomer,
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			if (response.status == 200) {
				let contract_customer_name = response.contract_customer_name;
				let contract_phone_number = response.contract_phone_number;
				let contract_customer_identify = response.contract_customer_identify;
				let contract_customer_identify_old = response.contract_customer_identify_old;
				let contract_passport_number = response.contract_passport_number;
				let contract_phone_r1 = response.contract_phone_r1;
				let contract_phone_r2 = response.contract_phone_r2;
				let contract_phone_r3 = response.contract_phone_r3;
				let contract_frame_number = response.contract_frame_number;
				let html_customer_name = '';
				let html_phone_number = '';
				let html_customer_identify = '';
				let html_customer_identify_old = '';
				let html_passport_number = '';
				let html_phone_r1 = '';
				let html_phone_r2 = '';
				let html_phone_r3 = '';
				let html_frame_number = '';
				$('#contractReferenceAll').modal('show');
				$('#list_contract_reference_all').children().remove();
					html_customer_name = generate_contract_relative_html('Họ tên khách hàng: ', customer_name, contract_customer_name);
					html_phone_number = generate_contract_relative_html('Số điện thoại: ', customer_phone_number, contract_phone_number);
					html_customer_identify = generate_contract_relative_html('CMT/CCCD mới: ', customer_identify, contract_customer_identify);
					html_customer_identify_old = generate_contract_relative_html('CMT/CCCD cũ: ', customer_identify_old, contract_customer_identify_old);
					html_passport_number = generate_contract_relative_html('Hộ chiếu: ', passport_number, contract_passport_number);
					html_phone_r1 = generate_contract_relative_html('SĐT tham chiếu 1: ', phone_number_relative_1, contract_phone_r1);
					html_phone_r2 = generate_contract_relative_html('SĐT tham chiếu 2: ', phone_number_relative_2, contract_phone_r2);
					html_phone_r3 = generate_contract_relative_html('SĐT tham chiếu 3: ', phone_relative_3, contract_phone_r3);
					html_frame_number = generate_contract_relative_html('Số khung: ', frame_number, contract_frame_number);
				if (contract_customer_name.length > 0) {
					$('#list_contract_reference_all').append(html_customer_name);
				}
				if (contract_phone_number.length > 0) {
					$('#list_contract_reference_all').append(html_phone_number);
				}
				if (contract_customer_identify.length > 0) {
					$('#list_contract_reference_all').append(html_customer_identify);
				}
				if (contract_customer_identify_old.length > 0) {
					$('#list_contract_reference_all').append(html_customer_identify_old);
				}
				if (contract_passport_number.length > 0) {
					$('#list_contract_reference_all').append(html_passport_number);
				}
				if (contract_phone_r1.length > 0) {
					$('#list_contract_reference_all').append(html_phone_r1);
				}
				if (contract_phone_r2.length > 0) {
					$('#list_contract_reference_all').append(html_phone_r2);
				}
				if (contract_phone_r3.length > 0) {
					$('#list_contract_reference_all').append(html_phone_r3);
				}
				if (contract_frame_number.length > 0) {
					$('#list_contract_reference_all').append(html_frame_number);
				}
			} else {
				$('#checkContractFalse').modal('show');
			}
		},
		error: function () {

		}
	});

	// Hàm gen bảng html hợp đồng liên quan
	function generate_contract_relative_html(infor_text, infor_value, contract_ref) {
		const number_phone_length = 10;
		if (infor_value >= number_phone_length) {
			infor_value = hide_phone_js(infor_value);
		}
		let html = "";
			html = "<tr><th colspan='13'>" + infor_text + infor_value + "</th></tr>"
		for (let i = 0; i < contract_ref.length; i++) {
			let bucket_contract = 'Không xác định';
			let case_bucket = 0;
			let status_contract = 'Không xác định';
			let time_slow_payment = contract_ref[i].debt.so_ngay_cham_tra ? contract_ref[i].debt.so_ngay_cham_tra : 0;
			let create_date = "";
			let the_number = i + 1;
			if (in_array(contract_ref[i].status, [1,2,3,4,5,6,7,8,9,10,15,19,33,34])) {
				time_slow_payment = '-';
			}
			status_contract = get_status(contract_ref[i].status);
			case_bucket = get_case_bucket(time_slow_payment);
			bucket_contract = get_bucket_text(case_bucket);
			create_date = new Date(contract_ref[i].created_at * 1000).format('d/m/Y H:i:s')
			html += "<tr>" + "<td>" + the_number + "</td>";
			html += "<td><a href='" + _url.base_url + "pawn/detail?id=" + contract_ref[i]._id.$oid + "' target='_blank' data-toggle='tooltip' title='Xem chi tiết hợp đồng'>" + contract_ref[i].code_contract + "</a></td>";
			html += "<td><a href='" + _url.base_url + "accountant/view?id=" + contract_ref[i]._id.$oid + "' target='_blank' data-toggle='tooltip' title='Xem chi tiết thanh toán'>" + contract_ref[i].code_contract_disbursement + "</a></td>";
			html += "<td>" + contract_ref[i].customer_infor.customer_name + "</td>";
			html += "<td>" + hide_phone_js(contract_ref[i].customer_infor.customer_phone_number) + "</td>";
			html += "<td>" + contract_ref[i].customer_infor.customer_identify + "</td>";
			html += "<td>" + contract_ref[i].customer_infor.passport_number + "</td>";
			html += "<td>" + contract_ref[i].store.name + "</td>";
			html += "<td>" + status_contract + "</td>";
			html += "<td>" + time_slow_payment + "</td>";
			html += "<td>" + bucket_contract + "</td>";
			html += "<td>" + create_date.toLocaleString() + "</td>";
		}
		return html;
	}
});


