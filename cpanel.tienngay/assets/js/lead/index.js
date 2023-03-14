$(function () {
	var
		$table = $('.datatable-buttons'),
		rows = $table.find('tr');

	rows.each(function (index, row) {
		var
			$row = $(row),
			level = $row.data('level'),
			id = $row.data('id'),
			$columnName = $row.find('td[data-column="name"]'),
			children = $table.find('tr[data-parent="' + id + '"]');
		if (children.length) {
			var expander = $columnName.prepend('' +
				'<span class="treegrid-expander treegrid-expander-collapsed" style="float: right;"></span>' +
				'');

			children.hide();

			expander.on('click', function (e) {
				var $target = $(e.target);
				if ($target.hasClass('treegrid-expander-collapsed')) {
					$target
						.removeClass('treegrid-expander-collapsed')
						.addClass('treegrid-expander-expanded');

					children.show();
				} else {
					$target
						.removeClass('treegrid-expander-expanded')
						.addClass('treegrid-expander-collapsed');

					reverseHide($table, $row);
				}
			});
		}

		$columnName.prepend('' +
			'<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>' +
			'');
	});

	// Reverse hide all elements
	reverseHide = function (table, element) {
		var
			$element = $(element),
			id = $element.data('id'),
			children = table.find('tr[data-parent="' + id + '"]');

		if (children.length) {
			children.each(function (i, e) {
				reverseHide(table, e);
			});

			$element
				.find('.treegrid-expander-expanded')
				.removeClass('treegrid-expander-expanded')
				.addClass('treegrid-expander-collapsed');

			children.hide();
		}
	};
});

$('#property_by_main').selectize();
$('#reason_cancel').selectize();
$('#id_PDG').selectize();

// $('select[name="hk_province"]').selectize();
// $('select[name="hk_district"]').selectize();
$('select[name="hk_ward"]').selectize({
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
// $('select[name="ns_province"]').selectize();
// $('select[name="ns_district"]').selectize();
$('select[name="ns_ward"]').selectize({
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

$('select[name="hk_province"]').selectize({
	create: false,
	valueField: 'id',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}

});

$('select[name="hk_district"]').selectize({
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
$('select[name="ns_province"]').selectize({
	create: false,
	valueField: 'id',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('select[name="ns_district"]').selectize({
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

$('#cskh').selectize({
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
$('#selectize_area').selectize({
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
$('#selectize_store').selectize({
	create: false,
	valueField: 'code_address_store',
	labelField: 'name',
	searchField: 'name',
	maxItems: 100,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
// $('#status_pgd').selectize({
//  create: false,
//  valueField: 'status_pgd',
//  labelField: 'name',
//  searchField: 'name',
//  maxItems: 100,
//  sortField: {
// 	 field: 'name',
// 	 direction: 'asc'
//  }
// });
$("select[name='status']").on("change", function () {
	var val = parseInt($(this).val());
	var temp = $("#temp_" + val).html();
	$(".div-temp").remove();
	$(".div-temp-9").remove();
	$(".div-temp-9-2").remove();
	if (temp !== undefined && temp !== "") {
		$(this).closest(".form-group").after(temp);
	}
});

function changeLevel9(thiz) {
	var val = parseInt($(thiz).val());
	var temp = $("#temp_9_" + val).html();
	$(".div-temp-9").remove();
	$(".div-temp-9-2").remove();
	if (temp !== undefined && temp !== "") {
		$(thiz).closest(".form-group").after(temp);
	}
}

function changeLevel9_2(thiz) {
	var val = parseInt($(thiz).val());
	var temp = $("#temp_9_2_" + val).html();
	$(".div-temp-9-2").remove();
	if (temp !== undefined && temp !== "") {
		$(thiz).closest(".form-group").after(temp);
	}
}

$(".btn-save").on("click", function () {
	var phoneNumber = $("#phone_number").val();
	var type_finance = parseInt($("#type_finance").val());
	var call = parseInt($("#call").val());
	var status = parseInt($("#status").val());
	var reason1 = "";
	var reason2 = "";
	var reason3 = "";
	if ($("#reason_1").val() !== undefined) reason1 = parseInt($("#reason_1").val());
	if ($("#reason_2").val() !== undefined) reason2 = parseInt($("#reason_2").val());
	if ($("#reason_3").val() !== undefined) reason3 = parseInt($("#reason_3").val());
	$.ajax({
		url: _url.process_update_lead,
		method: "POST",
		data: {
			id: $("#id").val(),
			phone_number: phoneNumber,
			type_finance: type_finance,
			call: call,
			status: status,
			reason_1: reason1,
			reason_2: reason2,
			reason_3: reason3
		},
		success: function (data) {
			if (data.data.status !== 200) {
				alert(data.data.message);
			} else {
				window.location.href = _url.base_url + '/lead';
			}
		},
		error: function (error) {
			console.log(error)
		}
	});
});

function showRecording(id) {

	$.ajax({
		url: _url.base_url + 'lead_custom/showRecordingInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			$('#tbody_recording').empty();
			$('#tbody_recording').append(result.html);

			$('#tab006_recording').modal('show');
		}
	});
}

function showLeadLog(id) {
	$.ajax({
		url: _url.base_url + 'lead_custom/showLeadLogInfo/' + id,
		type: "GET",
		dataType: "JSON",
		success: function (result) {
			$('#tbody_lead_log').empty();
			$('#tbody_lead_log').append(result.html);

			$('#tab001_lead_log').modal('show');
		}
	});
}

function return_cskh(id) {
	$.ajax({
		url: _url.base_url + 'lead_custom/return_cskh?id=' + id,
		type: "GET",
		dateType: "JSON",
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			console.log(data);
			$(".theloading").hide();
			if (data.res) {
				$('#successModal').modal('show');
				$('.msg_success').text(data.message);
				location.reload();
			} else {
				$('#errorModal').modal('show');
				$('.msg_error').text(data.message);
			}
		}
	});
}
function showModal_chage_cvkd(id) {

	$.ajax({
		url: _url.base_url + 'lead_custom/showCvkdChage/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
           $('.lead_id_auto').val(result.data._id.$oid);
           $('#auto_fullname').text(result.data.fullname);
           $('#auto_email').text(result.data.email);
           $('#auto_cvkd').text(result.data.cvkd);
           $('#auto_status_sale').text(result.data.status_sale);
           $('#auto_status_pgd').text(result.data.status_pgd);
           $('#auto_reason_process').text(result.data.reason_process);
			updata_drop_box(result.data.data_cvkd, 'cvkd_auto', result.data.cvkd);		
          $('#chage_cvkd_Modal').modal('show');
		}
	});
}
function updata_drop_box(check = null, type, text) {
	
	$('[name="' + type + '"]').empty();
		check.forEach(function(item, index, array) {
			if(text!=item)
           $('[name="' + type + '"]').append('<option value="'+item+'"  selected>' + item + ' </option>');
         })
			
}
$(".approve_submit_change").click(function (event) {
	event.preventDefault();
	
	var id = $(".lead_id_auto").val();
	var cvkd = $("#cvkd_auto").val();
	var note = $("textarea[name='note_auto']").val();


	var formData = new FormData();
	formData.append('id', id);
	formData.append('cvkd', cvkd);
	formData.append('note', note);
	

	$.ajax({
		url: _url.base_url + 'lead_custom/save_chage_cvkd',
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
			if (data.status != 200) {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			} else {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url +'lead_custom/list_transfe_office';
				}, 2000);
			}
		
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

function showModal(id) {

	$.ajax({
		url: _url.base_url + 'lead_custom/showLeadInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="_id"]').val(result.data._id.$oid);
			$('[name="phone_number"]').val(result.data.phone_number);
			$('[name="fullname"]').val(result.data.fullname);
			$('[name="address"]').val(result.data.address);
			$('[name="debt"]').val(result.data.debt);
			$('[name="email"]').val(result.data.email);
			$('[name="identify_lead"]').val(result.data.identify_lead);
			$('[name="dob_lead"]').val(result.data.dob_lead);
			$('[name="type_finance"]').val(result.data.type_finance);
			check_drop_box(result.data.source, 'source', 'Chọn nguồn');
			check_drop_box(result.data.type_finance, 'type_finance', 'Chọn sản phẩm vay');
			check_drop_box(result.data.hk_province, 'hk_province', 'Chọn tỉnh/thành');
			check_drop_box(result.data.ns_province, 'ns_province', 'Chọn tỉnh/thành');
			$('select[name="hk_province"]').data('selectize').setValue(result.data.hk_province);
			$('select[name="ns_province"]').data('selectize').setValue(result.data.ns_province);
			check_drop_box(result.data.status_pgd, 'status_pgd', 'Chọn trạng thái PGD');
			check_drop_box(result.data.reason_cancel_pgd, 'reason_cancel_pgd', 'Chọn lý do hủy PGD');
			check_drop_box(result.data.reason_return, 'reason_return', 'Chọn lý do PGD trả về');
			check_drop_box(result.data.reason_process, 'reason_process', 'Chọn lý do PGD đang xử lý');
			let status_pgd_checked = $('#status_pgd').val();
			if (status_pgd_checked == 8) {
				$('#reason_return').show();
				$('#reason_cancel_pgd').hide();
				$('#reason_process').hide();
			} else if (status_pgd_checked == 16) {
				$('#reason_return').hide();
				$('#reason_process').hide();
				$('#reason_cancel_pgd').show();
			} else if (status_pgd_checked == 17) {
				$('#reason_return').hide();
				$('#reason_cancel_pgd').hide();
				$('#reason_process').show();
			} else {
				$('#reason_return').hide();
				$('#reason_cancel_pgd').hide();
				$('#reason_process').hide();
			}

			check_selectize(result.data.property_id, 'property_by_main', 'Chọn nhãn hiệu đời xe');
			check_drop_box(result.data.loan_time, 'loan_time', 'Chọn thời hạn vay');
			check_drop_box(result.data.type_repay, 'type_repay', 'Chọn hình thức trả lãi');
			check_drop_box(result.data.sim_chinh_chu, 'sim_chinh_chu', 'Chọn sim chính chủ');
			check_drop_box(result.data.type_finance, 'type_finance', 'Chọn sản phẩm vay');

			get_district_by_province(result.data.hk_province, result.data.hk_district, type = 'hk_district');
			get_district_by_province(result.data.ns_province, result.data.ns_district, type = 'ns_district');

			$('select[name="hk_district"]').data('selectize').setValue(result.data.hk_district);
			$('select[name="ns_district"]').data('selectize').setValue(result.data.ns_district);

			setTimeout(function () {
				get_ward_by_district(result.data.hk_district, result.data.hk_ward, type = 'hk_ward');
				get_ward_by_district(result.data.ns_district, result.data.ns_ward, type = 'ns_ward');
				$('select[name="hk_ward"]').data('selectize').setValue(result.data.hk_ward);
				$('select[name="ns_ward"]').data('selectize').setValue(result.data.ns_ward);
			}, 3000);
			check_drop_box(result.data.obj, 'obj', 'Chọn đối tượng');
			check_drop_box(result.data.status_sale, 'status_sale', 'Mới');
			// check_drop_box(result.data.id_PDG, 'id_PDG', 'Chọn phòng GD');
			// check_drop_box(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
			check_selectize(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
			check_selectize(result.data.id_PDG, 'id_PDG', 'Chọn lý do');
			$('[name="com"]').val(result.data.com);
			$('[name="com_address"]').val(result.data.com_address);
			$('[name="position"]').val(result.data.position);
			$('[name="time_work"]').val(result.data.time_work);
			check_radio(result.data.contract_work, ['#has_contract_work', '#no_contract_work']);
			$('[name="other_contract"]').val(result.data.other_contract);
			check_radio(result.data.salary_pay, ['#salary_pay_mon', '#salary_pay_card']);
			$('[name="income"]').val(result.data.income);
			$('[name="loan_amount"]').val(result.data.loan_amount);
			$('[name="amout_repay"]').val(result.data.amout_repay);
			$('[name="time_support"]').val(result.data.time_support);
			$('[name="other_income"]').val(result.data.other_income);
			$('[name="address_support"]').val(result.data.address_support);
			$('[name="tls_note"]').val(result.data.tls_note);
			$('[name="pgd_note"]').val(result.data.pgd_note);

			check_radio(result.data.workplace_evaluation, ['#has_workplace_evaluation', '#no_workplace_evaluation']);
			check_radio(result.data.vehicle_registration, ['#has_vehicle_registration', '#no_vehicle_registration']);
			$('input').removeAttr("readonly");
			$('select').removeAttr("disabled");
			$('textarea').removeAttr("readonly");
			$('#status_pgd').prop('disabled', true);
			$('#reason_return').prop('disabled', true);
			$('#reason_cancel_pgd').prop('disabled', true);
			$('#reason_process').prop('disabled', true);
			$('#pgd_note').prop('disabled', true);
			$('.form-control').parent().removeClass('has-error');
			$('[name="utm_source"]').val(result.data.utm_source);
			$('[name="utm_campaign"]').val(result.data.utm_campaign);
			check_radio(result.data.qualified, ['#has_qualified', '#no_qualified']);
			$('.help-block').empty();
			if (result.data.status_sale == "19") {
				$('.btnSave').hide();
			} else {
				$('.btnSave').show();
			}
			$('[name="thoi_gian_khach_hen"]').val(result.data.thoi_gian_khach_hen);

			$('#tbody_lead_log_modal').empty();
			$('#tbody_lead_log_modal').append(result.html);

			$('#tab001_noteModal').modal('show');

		}
	});
}

function call_for_customer(phone_number, contract_id, type) {
	console.log(phone_number);
	if (phone_number == undefined || phone_number == '') {
		alert("Không có số");
	} else {

		if (type == "customer") {
			$(".title_modal_approve").text("Gọi cho khách hàng");
		}
		if (type == "rel1") {
			$(".title_modal_approve").text("Gọi cho tham chiếu 1");
		}
		if (type == "rel2") {
			$(".title_modal_approve").text("Gọi cho tham chiếu 2");
		}
		$("#number").val(phone_number);
		$(".contract_id").val(contract_id);
		$("#approve_call").modal("show");
	}
}

function showModal_office(id) {

	$.ajax({
		url: _url.base_url + 'lead_custom/showLeadInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="_id"]').val(result.data._id.$oid);
			$('[name="phone_number"]').val(result.data.phone_number);
			$('[name="fullname"]').val(result.data.fullname);
			$('[name="address"]').val(result.data.address);
			$('[name="debt"]').val(result.data.debt);
			$('[name="email"]').val(result.data.email);
			$('[name="identify_lead"]').val(result.data.identify_lead);
			$('[name="dob_lead"]').val(result.data.dob_lead);
			$('#status_pgd_old').val(result.data.status_pgd);
			check_drop_box(result.data.source, 'source', 'Chọn nguồn');
			check_drop_box(result.data.type_finance, 'type_finance', 'Chọn sản phẩm vay');
			check_selectize(result.data.property_id, 'property_by_main', 'Chọn nhãn hiệu đời xe');
			check_drop_box(result.data.loan_time, 'loan_time', 'Chọn thời hạn vay');
			check_drop_box(result.data.type_repay, 'type_repay', 'Chọn hình thức trả lãi');
			check_drop_box(result.data.hk_province, 'hk_province', 'Chọn tỉnh/thành');
			check_drop_box(result.data.ns_province, 'ns_province', 'Chọn tỉnh/thành');
			$('select[name="hk_province"]').data('selectize').setValue(result.data.hk_province);
			$('select[name="ns_province"]').data('selectize').setValue(result.data.ns_province);
			check_drop_box(result.data.status_pgd, 'status_pgd', 'Chọn trạng thái lead PGD');
			$('.note_trang_thai_pgd').html(note_trang_thai_pgd(result.data.status_pgd));
			check_drop_box(result.data.reason_cancel_pgd, 'reason_cancel_pgd', 'Chọn lý do hủy PGD');
			check_drop_box(result.data.reason_return, 'reason_return', 'Chọn lý do PGD trả về');
			check_drop_box(result.data.reason_process, 'reason_process', 'Chọn lý do PGD đang xử lý');
			let status_pgd_checked = $('#status_pgd').val();
			if (status_pgd_checked == 8) {
				$('#reason_return').show();
				$('#reason_cancel_pgd').hide();
				$('#reason_process').hide();
			} else if (status_pgd_checked == 16) {
				$('#reason_return').hide();
				$('#reason_process').hide();
				$('#reason_cancel_pgd').show();
			} else if (status_pgd_checked == 17) {
				$('#reason_return').hide();
				$('#reason_cancel_pgd').hide();
				$('#reason_process').show();
			} else {
				$('#reason_return').hide();
				$('#reason_cancel_pgd').hide();
				$('#reason_process').hide();
			}
			check_selectize(result.data.property_id, 'property_by_main', 'Chọn nhãn hiệu đời xe');
			check_drop_box(result.data.loan_time, 'loan_time', 'Chọn thời hạn vay');
			check_drop_box(result.data.type_repay, 'type_repay', 'Chọn hình thức trả lãi');

			get_district_by_province(result.data.hk_province, result.data.hk_district, type = 'hk_district');
			get_district_by_province(result.data.ns_province, result.data.ns_district, type = 'ns_district');

			$('select[name="hk_district"]').data('selectize').setValue(result.data.hk_district);
			$('select[name="ns_district"]').data('selectize').setValue(result.data.ns_district);

			setTimeout(function () {
				get_ward_by_district(result.data.hk_district, result.data.hk_ward, type = 'hk_ward');
				get_ward_by_district(result.data.ns_district, result.data.ns_ward, type = 'ns_ward');
				$('select[name="hk_ward"]').data('selectize').setValue(result.data.hk_ward);
				$('select[name="ns_ward"]').data('selectize').setValue(result.data.ns_ward);
			}, 3000);
			check_drop_box(result.data.obj, 'obj', 'Chọn đối tượng');
			$("#obj").prop('disabled', true);
			check_drop_box(result.data.status_sale, 'status_sale', 'Mới');
			// check_drop_box(result.data.id_PDG, 'id_PDG', 'Chọn phòng GD');
			check_selectize(result.data.id_PDG, 'id_PDG', 'Chọn lý do');
			// check_drop_box(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
			check_selectize(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
			$('[name="com"]').val(result.data.com);
			$('[name="com_address"]').val(result.data.com_address);
			$('[name="position"]').val(result.data.position);
			$('[name="time_work"]').val(result.data.time_work);
			check_radio(result.data.contract_work, ['#has_contract_work', '#no_contract_work']);
			$('[name="other_contract"]').val(result.data.other_contract);
			check_radio(result.data.salary_pay, ['#salary_pay_mon', '#salary_pay_card']);
			$('[name="income"]').val(result.data.income);
			$('[name="loan_amount"]').val(result.data.loan_amount);
			$('[name="amout_repay"]').val(result.data.amout_repay);
			$('[name="time_support"]').val(result.data.time_support);
			$('[name="other_income"]').val(result.data.other_income);
			$('[name="address_support"]').val(result.data.address_support);
			$('[name="tls_note"]').val(result.data.tls_note);
			$('[name="pgd_note"]').val(result.data.pgd_note);
			check_radio(result.data.workplace_evaluation, ['#has_workplace_evaluation', '#no_workplace_evaluation']);
			check_radio(result.data.vehicle_registration, ['#has_vehicle_registration', '#no_vehicle_registration']);
			// $('input').removeAttr("readonly");
			// $('select').removeAttr("disabled");
			// $('textarea').removeAttr("readonly");

			$('#obj select').prop('disabled', true);
			$('#source').prop('disabled', true);
			$('#status_sale').prop('disabled', true);
			$('#tls_note').prop('disabled', true);
			$('#reason_cancel').prop('disabled', true);
			$('[name="qualified"]').prop('disabled', true);

			$('.form-control').parent().removeClass('has-error');
			$('[name="utm_source"]').val(result.data.utm_source);
			$('[name="utm_campaign"]').val(result.data.utm_campaign);
			check_radio(result.data.qualified, ['#has_qualified', '#no_qualified']);
			$('.help-block').empty();
			if (result.data.status_sale == "19") {
				$('.btnSave').hide();
			}
			$('#tab001_noteModal_office').modal('show');
		}
	});
}

$('#status_pgd').on('change', function () {

	let status_pgd_checked = $('#status_pgd').val();
	$('.note_trang_thai_pgd').html(note_trang_thai_pgd(status_pgd_checked));
	if (status_pgd_checked == 8) {
		$('#reason_return').show();
		$('#reason_cancel_pgd').hide();
		$('#reason_process').hide();
	} else if (status_pgd_checked == 16) {
		$('#reason_return').hide();
		$('#reason_process').hide();
		$('#reason_cancel_pgd').show();
	} else if (status_pgd_checked == 17) {
		$('#reason_return').hide();
		$('#reason_cancel_pgd').hide();
		$('#reason_process').show();
	} else {
		$('#reason_return').hide();
		$('#reason_cancel_pgd').hide();
		$('#reason_process').hide();
	}
});
function note_trang_thai_pgd(status_pgd_checked) {
	let note_trang_thai_pgd = "";
	if(status_pgd_checked<=27 && status_pgd_checked>=19)
	{
		note_trang_thai_pgd = "Dùng trong trường hợp gọi khách hàng không nghe máy";
	}else if(status_pgd_checked==28)
	{
        note_trang_thai_pgd = "Đã liên hện được nhưng KH còn phân vân hoặc chần chừ chưa chốt chắc chắn.";
	
	}else if(status_pgd_checked==29)
	{
		note_trang_thai_pgd = "Dùng trong trường hợp TLS chuyển lead IH về nhưng trước đó PGD đã tạo HĐ cho KH trên CPN rồi";
	}else if(status_pgd_checked==30)
	{
		note_trang_thai_pgd = "Đã liên hệ được, chờ KH gửi giấy tờ hoặc bổ sung các giấy tờ còn thiếu cho PGD";
	}else if(status_pgd_checked==31)
	{
		note_trang_thai_pgd = "Đã liên hệ được, KH hẹn lịch ghé PGD";
	}else if(status_pgd_checked==32)
	{
		note_trang_thai_pgd = "Chỉ áp dụng trong mùa dịch Covid 19, sau khi hết cách ly chăm sóc tiếp";
	}else if(status_pgd_checked==8)
	{
		note_trang_thai_pgd = "Chỉ chọn trạng thái này nếu sau 3 ngày  vẫn không thể liên hệ được với KH ( không nghe máy/ thuê bao/ CG thất bại…) hoặc kh Hẹn ra PGD nhưng không đến hoặc chuyển sang PGD khác hỗ trợ hoặc KH báo nhầm máy không phải người đăng ký vay";
	} else if(status_pgd_checked==16)
	{
		note_trang_thai_pgd = "Các trường hợp không thoả mãn điều kiện SP, hoặc các trường hợp KH từ chối mà CVKD không thể thuyết phục nữa.";
	} else if (status_pgd_checked == 33) {
		note_trang_thai_pgd = "Lead chuyển về PGD nhưng chưa liên hệ được: không nghe máy, thuê bao, sai số, cuộc gọi thất bại, tắt máy ngang, máy bận....";
	} else if (status_pgd_checked == 34) {
		note_trang_thai_pgd = "Đã liên hệ được nhưng chưa chốt được lịch hẹn sẽ ra PGD cụ thể với KH";
	} else if (status_pgd_checked == 35) {
		note_trang_thai_pgd = "KH đã đặt lịch hẹn nhưng chưa đến PGD";
	} else if (status_pgd_checked == 36) {
		note_trang_thai_pgd = "KH đề nghị được hỗ trợ tận nhà";
	} else if (status_pgd_checked == 37) {
		note_trang_thai_pgd = "Đã liên hệ được nhưng KH báo bận hoặc chưa tiện trao đổi, hẹn lịch gọi lại sau";
	} else if (status_pgd_checked == 38) {
		note_trang_thai_pgd = "HĐ đang trong trạng thái chờ thẩm định";
	} else if (status_pgd_checked == 39) {
		note_trang_thai_pgd = "HĐ đang trong trạng thái chờ duyệt";
	} else if (status_pgd_checked == 40) {
		note_trang_thai_pgd = "HĐ đang chờ giải ngân";
	}
    return note_trang_thai_pgd;
}
$('[name="hk_province"]').on('change', function (event) {
	event.preventDefault();
	let hk_district = $("select[name='hk_district']").val();
	let province_id = $("select[name='hk_province']").val();
	console.log(hk_district + '-1-' + province_id);
	// if(!isEmpty(hk_district))
	get_district_by_province(province_id, hk_district, 'hk_district');
});

$('[name="ns_province"]').on('change', function (event) {
	event.preventDefault();
	let ns_district = $("select[name='ns_district']").val();
	let province_id = $("[name='ns_province']").val();
	console.log(ns_district + '-2-' + province_id);
	//   if(!isEmpty(ns_district))
	get_district_by_province(province_id, ns_district, 'ns_district');
});

$('[name="hk_district"]').on('change', function (event) {
	event.preventDefault();
	let hk_ward = $("select[name='hk_ward']").val();
	let district_id = $("[name='hk_district']").val();
	console.log(hk_ward + '-3-' + district_id);
	//  if(!isEmpty(hk_ward))
	get_ward_by_district(district_id, hk_ward, 'hk_ward');
});

$('[name="ns_district"]').on('change', function (event) {
	event.preventDefault();
	let ns_ward = $("select[name='ns_ward']").val();
	let district_id = $("[name='ns_district']").val();
	console.log(ns_ward + '-4-' + district_id);
	//if(!isEmpty(ns_ward))
	get_ward_by_district(district_id, ns_ward, 'ns_ward');
});
$('#addlead').on('click', function () {
	$('#modal_form').modal('show');
});

function isEmpty(str) {
	return (!str || 0 === str.length);
}

function detail(id) {
	$.ajax({
		url: _url.base_url + 'lead_custom/showLeadInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {

			$('[name="_id"]').val(result.data._id.$oid);
			$('[name="phone_number"]').val(result.data.phone_number);
			$('[name="fullname"]').val(result.data.fullname);
			$('[name="address"]').val(result.data.address);
			$('[name="debt"]').val(result.data.debt);
			$('[name="email"]').val(result.data.email);
			check_drop_box(result.data.source, 'source', 'Chọn nguồn');
			check_drop_box(result.data.type_finance, 'type_finance', 'Chọn sản phẩm vay');
			check_drop_box(result.data.hk_province, 'hk_province', 'Chọn tỉnh/thành');
			check_drop_box(result.data.ns_province, 'ns_province', 'Chọn tỉnh/thành');

			check_drop_box(result.data.status_pgd, 'status_pgd', 'Chọn trạng thái lead PGD');
			check_drop_box(result.data.reason_cancel_pgd, 'reason_cancel_pgd', 'Chọn lý do hủy PGD');
			check_drop_box(result.data.reason_return, 'reason_return', 'Chọn lý do PGD trả về');
			check_drop_box(result.data.reason_process, 'reason_process', 'Chọn lý do PGD đang xử lý');

			check_drop_box(result.data.property_id, 'property_id', 'Chọn nhãn hiệu đời xe');
			check_drop_box(result.data.loan_time, 'loan_time', 'Chọn thời hạn vay');
			check_drop_box(result.data.type_repay, 'type_repay', 'Chọn hình thức trả lãi');
			get_district_by_province(result.data.hk_province, result.data.hk_district, type = 'hk_district');
			get_district_by_province(result.data.ns_province, result.data.ns_district, type = 'ns_district');
			get_ward_by_district(result.data.hk_district, result.data.hk_ward, type = 'hk_ward');
			get_ward_by_district(result.data.ns_district, result.data.ns_ward, type = 'ns_ward');
			check_drop_box(result.data.obj, 'obj', 'Chọn đối tượng');
			check_drop_box(result.data.status_sale, 'status_sale', 'Mới');
			check_drop_box(result.data.id_PDG, 'id_PDG', 'Chọn phòng GD');
			check_drop_box(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
			$('[name="com"]').val(result.data.com);
			$('[name="com_address"]').val(result.data.com_address);
			$('[name="position"]').val(result.data.position);
			$('[name="time_work"]').val(result.data.time_work);
			check_radio(result.data.contract_work, ['#has_contract_work', '#no_contract_work']);
			$('[name="other_contract"]').val(result.data.other_contract);
			check_radio(result.data.salary_pay, ['#salary_pay_mon', '#salary_pay_card']);
			$('[name="income"]').val(result.data.income);
			$('[name="loan_amount"]').val(result.data.loan_amount);
			$('[name="amout_repay"]').val(result.data.amout_repay);
			$('[name="time_support"]').val(result.data.time_support);
			$('[name="other_income"]').val(result.data.other_income);
			$('[name="address_support"]').val(result.data.address_support);
			$('[name="tls_note"]').val(result.data.tls_note);
			$('[name="pgd_note"]').val(result.data.pgd_note);
			check_radio(result.data.workplace_evaluation, ['#has_workplace_evaluation', '#no_workplace_evaluation']);
			check_radio(result.data.vehicle_registration, ['#has_vehicle_registration', '#no_vehicle_registration']);
			$('#modal_form input').attr('readonly', 'readonly');
			$('#modal_form textarea').attr('readonly', 'readonly');
			$('#modal_form select').prop('disabled', true);
			$('.form-control').parent().removeClass('has-error');
			$('[name="utm_source"]').val(result.data.utm_source);
			$('[name="utm_campaign"]').val(result.data.utm_campaign);
			check_radio(result.data.qualified, ['#has_qualified', '#no_qualified']);
			$('.help-block').empty();
			$('#modal_form').modal('show');
		}
	});
}

function new_contract(id) {
	$.ajax({
		url: _url.base_url + 'lead_custom/showLeadInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var type_property;
			
			if (result.data.type_finance != undefined) {
				if (result.data.type_finance == "1" || result.data.type_finance == "3") {
					type_property = "5db7e6bfd6612bceec515b76"; //oto
				} else if (result.data.type_finance == "2" || result.data.type_finance == "4") {
					type_property = "5db7e6b4d6612b173e0728a4"; //xe may
				}
			}
			check_drop_box_by_poperty(type_property, 'type_property', result.data.property_id);


		}
	});
}

function delete_lead(id) {
	Swal.fire({
		title: 'Hủy Lead?',
		text: "Bạn chắc chắn muốn hủy lead",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: _url.base_url + 'lead_custom/lead_delete?_id=' + id,
				type: "GET",
				dateType: "JSON",
				success: function (result) {
					Swal.fire(
						'Deleted!',
						'Your file has been deleted.',
						'success'
					).then((result) => {
						if (result.value) {
							window.location.reload();
						}
					})
				}
			});
		}
	});
}


function change_pgd(t) {
	var id = $(t).data('id');
	var idPDG = $(t).data('idpdg');
	$('[name="id_clead"]').val(id);
	$('[name="id_PDG_clead"]').val(idPDG);

}

$(".btnSave").click(function (event) {
	event.preventDefault();
	// var parent = $(this).closest('.modal-content');
	var _id = $("input[name='_id']").val();
	var fullname = $("#ho_va_ten").val();
	console.log(fullname)
	var email = $("input[name='email']").val();
	var identify_lead = $("input[name='identify_lead']").val();
	var dob_lead = $("input[name='dob_lead']").val();
	var address = $("input[name='address']").val();
	var type_finance = $("select[name='type_finance']").val();
	var hk_province = $("select[name='hk_province']").val();
	var hk_district = $("select[name='hk_district']").val();
	var hk_ward = $("select[name='hk_ward']").val();
	var ns_province = $("select[name='ns_province']").val();
	var ns_district = $("select[name='ns_district']").val();
	var ns_ward = $("select[name='ns_ward']").val();
	var obj = $("select[name='obj']").val();
	var com = $("input[name='com']").val();
	var com_address = $("input[name='com_address']").val();
	var position = $("input[name='position']").val();
	var time_work = $("input[name='time_work']").val();
	var contract_work = $("input[name='contract_work']:checked").val();
	var other_contract = $("input[name='other_contract']").val();
	var salary_pay = $("input[name='salary_pay']:checked").val();
	var income = $("input[name='income']").val();
	var other_income = $("input[name='other_income']").val();
	var workplace_evaluation = $("input[name='workplace_evaluation']:checked").val();
	var vehicle_registration = $("input[name='vehicle_registration']:checked").val();
	var property_id = $("select[name='property_id']").val();
	var status_pgd = $("select[name='status_pgd']").val();
	var reason_return = $("select[name='reason_return']").val();
	var reason_cancel_pgd = $("select[name='reason_cancel_pgd']").val();
	var reason_process = $("select[name='reason_process']").val();
	var sim_chinh_chu = $("select[name='sim_chinh_chu']").val();


	var loan_amount = $("input[name='loan_amount']").val();
	var loan_time = $("select[name='loan_time']").val();
	var type_repay = $("select[name='type_repay']").val();
	var amout_repay = $("input[name='amout_repay']").val();
	var status_sale = $("select[name='status_sale']").val();
	var reason_cancel = $("select[name='reason_cancel']").val();
	var id_PDG = $("select[name='id_PDG']").val();
	var time_support = $("input[name='time_support']").val();
	var address_support = $("input[name='address_support']").val();
	var utm_source = $("input[name='utm_source']").val();
	var source = $("select[name='source']").val();
	var utm_campaign = $("input[name='utm_campaign']").val();
	var debt = $("input[name='debt']").val();
	var qualified = $("input[name='qualified']:checked").val();
	var tls_note = $("textarea[name='tls_note']").val();
	var pgd_note = $("textarea[name='pgd_note']").val();


	var thoi_gian_khach_hen = $("input[name='thoi_gian_khach_hen']").val();

	var formData = new FormData();
	formData.append('_id', _id);
	formData.append('fullname', fullname);
	formData.append('email', email);
	formData.append('identify_lead', identify_lead);
	formData.append('dob_lead', dob_lead);
	formData.append('address', address);
	formData.append('type_finance', type_finance);
	formData.append('hk_province', hk_province);
	formData.append('hk_district', hk_district);
	formData.append('hk_ward', hk_ward);
	formData.append('ns_province', ns_province);
	formData.append('ns_district', ns_district);
	formData.append('ns_ward', ns_ward);
	formData.append('obj', obj);
	formData.append('com', com);
	formData.append('com_address', com_address);
	formData.append('position', position);
	formData.append('time_work', time_work);
	formData.append('contract_work', contract_work);
	formData.append('other_contract', other_contract);
	formData.append('salary_pay', salary_pay);
	formData.append('income', income);
	formData.append('other_income', other_income);
	formData.append('workplace_evaluation', workplace_evaluation);
	formData.append('vehicle_registration', vehicle_registration);
	formData.append('property_id', property_id);
	formData.append('loan_amount', loan_amount);
	formData.append('loan_time', loan_time);
	formData.append('type_repay', type_repay);
	formData.append('amout_repay', amout_repay);
	formData.append('status_sale', status_sale);
	formData.append('status_pgd', status_pgd);
	formData.append('reason_return', reason_return);
	formData.append('reason_cancel_pgd', reason_cancel_pgd);
	formData.append('reason_process', reason_process);
	formData.append('sim_chinh_chu', sim_chinh_chu);


	formData.append('reason_cancel', reason_cancel);
	formData.append('id_PDG', id_PDG);
	formData.append('time_support', time_support);
	formData.append('address_support', address_support);
	formData.append('utm_campaign', utm_campaign);
	formData.append('utm_source', utm_source);
	formData.append('source', source);
	formData.append('qualified', qualified);
	formData.append('debt', debt);
	formData.append('tls_note', tls_note);
	formData.append('pgd_note', pgd_note);

	formData.append('thoi_gian_khach_hen', thoi_gian_khach_hen);


	$.ajax({
		url: _url.base_url + 'lead_custom/save_lead',
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
			if (data.status == 200) {
				$("#div_success1").css("display", "block");
				$("#div_success2").css("display", "block");
				$(".div_success").text(data.msg);
				window.scrollTo(0, 0);
				setTimeout(function () {
					$("#div_success1").css("display", "none");
					$("#div_success2").css("display", "none");
				}, 3000);

			} else {

				$("#div_error1").css("display", "block");
				$("#div_error2").css("display", "block");
				$(".div_error").text(data.msg);
				window.scrollTo(0, 0);
				setTimeout(function () {
					$("#div_error1").css("display", "none");
					$("#div_error2").css("display", "none");
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

$(".btnSaveOffice").click(function (event) {
	event.preventDefault();
	var parent = $(this).closest('.modal-body ');
	var _id = $("input[name='_id']").val();
	var fullname = parent.find(("input[name='fullname']")).val();
	var email = $("input[name='email']").val();
	var identify_lead = $("input[name='identify_lead']").val();
	var dob_lead = $("input[name='dob_lead']").val();
	var address = $("input[name='address']").val();
	var type_finance = $("select[name='type_finance']").val();
	var hk_province = parent.find(("select[name='hk_province']")).val();
	var hk_district = parent.find(("select[name='hk_district']")).val();
	var hk_ward = parent.find(("select[name='hk_ward']")).val();
	var ns_province = parent.find(("select[name='ns_province']")).val();
	var ns_district = parent.find(("select[name='ns_district']")).val();
	var ns_ward = parent.find(("select[name='ns_ward']")).val();
	var obj = $("select[name='obj']").val();
	var com = $("input[name='com']").val();
	var com_address = $("input[name='com_address']").val();
	var position = $("input[name='position']").val();
	var time_work = $("input[name='time_work']").val();
	var contract_work = $("input[name='contract_work']:checked").val();
	var other_contract = $("input[name='other_contract']").val();
	var salary_pay = $("input[name='salary_pay']:checked").val();
	var income = $("input[name='income']").val();
	var other_income = $("input[name='other_income']").val();
	var workplace_evaluation = $("input[name='workplace_evaluation']:checked").val();
	var vehicle_registration = $("input[name='vehicle_registration']:checked").val();
	var property_id = $("select[name='property_id']").val();
	var status_pgd = $("select[name='status_pgd']").val();
	var reason_return = $("select[name='reason_return']").val();
	var reason_cancel_pgd = $("select[name='reason_cancel_pgd']").val();
	var reason_process = $("select[name='reason_process']").val();


	var loan_amount = $("input[name='loan_amount']").val();
	var loan_time = $("select[name='loan_time']").val();
	var type_repay = $("select[name='type_repay']").val();
	var amout_repay = $("input[name='amout_repay']").val();
	var status_sale = $("select[name='status_sale']").val();
	var reason_cancel = $("select[name='reason_cancel']").val();
	var id_PDG = $("select[name='id_PDG']").val();
	var time_support = $("input[name='time_support']").val();
	var address_support = $("input[name='address_support']").val();
	var utm_source = $("input[name='utm_source']").val();
	var source = $("select[name='source']").val();
	var utm_campaign = $("input[name='utm_campaign']").val();
	var debt = $("input[name='debt']").val();
	var qualified = $("input[name='qualified']:checked").val();
	var tls_note = $("textarea[name='tls_note']").val();
	var pgd_note = $("textarea[name='pgd_note']").val();

	var formData = new FormData();
	formData.append('_id', _id);
	formData.append('fullname', fullname);
	formData.append('email', email);
	formData.append('identify_lead', identify_lead);
	formData.append('dob_lead', dob_lead);
	formData.append('address', address);
	formData.append('type_finance', type_finance);
	formData.append('hk_province', hk_province);
	formData.append('hk_district', hk_district);
	formData.append('hk_ward', hk_ward);
	formData.append('ns_province', ns_province);
	formData.append('ns_district', ns_district);
	formData.append('ns_ward', ns_ward);
	formData.append('obj', obj);
	formData.append('com', com);
	formData.append('com_address', com_address);
	formData.append('position', position);
	formData.append('time_work', time_work);
	formData.append('contract_work', contract_work);
	formData.append('other_contract', other_contract);
	formData.append('salary_pay', salary_pay);
	formData.append('income', income);
	formData.append('other_income', other_income);
	formData.append('workplace_evaluation', workplace_evaluation);
	formData.append('vehicle_registration', vehicle_registration);
	formData.append('property_id', property_id);
	formData.append('loan_amount', loan_amount);
	formData.append('loan_time', loan_time);
	formData.append('type_repay', type_repay);
	formData.append('amout_repay', amout_repay);
	formData.append('status_sale', status_sale);
	formData.append('status_pgd', status_pgd);
	formData.append('reason_return', reason_return);
	formData.append('reason_cancel_pgd', reason_cancel_pgd);
	formData.append('reason_process', reason_process);


	formData.append('reason_cancel', reason_cancel);
	formData.append('id_PDG', id_PDG);
	formData.append('time_support', time_support);
	formData.append('address_support', address_support);
	formData.append('utm_campaign', utm_campaign);
	formData.append('utm_source', utm_source);
	formData.append('source', source);
	formData.append('qualified', qualified);
	formData.append('debt', debt);
	formData.append('tls_note', tls_note);
	formData.append('pgd_note', pgd_note);

	$.ajax({
		url: _url.base_url + 'lead_custom/save_lead_office',
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
			if (data.status == 200) {
				$("#div_success1").css("display", "block");
				$("#div_success2").css("display", "block");
				$(".div_success").text(data.msg);
				window.scrollTo(0, 0);
				setTimeout(function () {
					$("#div_success1").css("display", "none");
					$("#div_success2").css("display", "none");
				}, 3000);

			} else {

				$("#div_error1").css("display", "block");
				$("#div_error2").css("display", "block");
				$(".div_error").text(data.msg);
				window.scrollTo(0, 0);
				setTimeout(function () {
					$("#div_error1").css("display", "none");
					$("#div_error2").css("display", "none");
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});


$(".modal_cskh").click(function (event) {
	event.preventDefault();

	$("input[name='customer_fullname']").val("");
	$("input[name='customer_phone']").val("");


});
$(".change_pgd_submit").click(function (event) {
	event.preventDefault();
	var _id = $("input[name='id_clead']").val();
	var id_PDG = $("input[name='id_PDG_clead']").val();

	var formData = new FormData();
	formData.append('_id', _id);
	formData.append('id_PDG', id_PDG);


	$.ajax({
		url: _url.base_url + 'lead_custom/change_pgd',
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
			if (data.status == 200) {
				$('#successModal').modal('show');
				$('.msg_success').text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + 'lead_custom';
				}, 3000);
			} else {

				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});


$('[name="customer_source"]').on('change', function (event) {
	event.preventDefault();
	let check_source = $("select[name='customer_source']").val();
	console.log(check_source);
	if (check_source == 11){
		$('#show_hide_customer_phone_introduce').show();
	} else {
		$('#show_hide_customer_phone_introduce').hide();
		$('#customer_phone_introduce').val("");
	}
});

$("#customer_btnSave").click(function (event) {
	event.preventDefault();

	var customer_fullname = $("input[name='customer_fullname']").val();
	var customer_phone = $("input[name='customer_phone']").val();
	var customer_gender = $("input[name='customer_gender']:checked").val();
	var customer_source = $("select[name='customer_source']").val();
	var customer_phone_introduce = $("input[name='customer_phone_introduce']").val();
	var cskh = $("select[name='cskh_add']").val();

	var formData = new FormData();
	formData.append('customer_fullname', customer_fullname);
	formData.append('customer_phone', customer_phone);
	formData.append('customer_gender', customer_gender);
	formData.append('customer_source', customer_source);
	formData.append('customer_phone_introduce', customer_phone_introduce);
	formData.append('cskh', cskh);


	$.ajax({
		url: _url.base_url + 'lead_custom/do_insert_lead',
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
			if (data.status == 200) {
				$('#successModal').modal('show');
				$('.msg_success').text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + 'lead_custom';
				}, 3000);
			} else {

				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

$(".modal_PGD").click(function (event) {
	event.preventDefault();

	$("input[name='customer_fullname']").val();
	$("input[name='customer_phone']").val();
	$("input[name='customer_identity_card']").val();
	$("input[name='customer_card']").val();
	$("input[name='customer_gender']:checked").val();
	$("select[name='customer_source']").val();
	$("input[name='customer_phone_introduce']").val();


});

$("#change_source").change(function (event) {
	event.preventDefault();
	$('#11').hide();
	$('#' + $(this).val()).show();
})


$(".close-PGD").click(function (event) {
	event.preventDefault();

	$("input[name='customer_fullname']").val('');
	$("input[name='customer_phone']").val('');
	$("input[name='customer_identity_card']").val('');
	$("input[name='customer_card']").val('');
	$("input[name='customer_phone_introduce']").val('');

});

$("#customer_pgdSave").click(function (event) {

	event.preventDefault();

	var customer_fullname = $("input[name='customer_fullname']").val();
	var customer_phone = $("input[name='customer_phone']").val();
	var customer_identity_card = $("input[name='customer_identity_card']").val();
	var customer_card = $("input[name='customer_card']").val();
	var customer_gender = $("input[name='customer_gender']:checked").val();
	var customer_source = $("select[name='customer_source']").val();
	var customer_phone_introduce = $("input[name='customer_phone_introduce']").val();

	var formData = new FormData();
	formData.append('customer_fullname', customer_fullname);
	formData.append('customer_phone', customer_phone);
	formData.append('customer_identity_card', customer_identity_card);
	formData.append('customer_card', customer_card);
	formData.append('customer_gender', customer_gender);
	formData.append('customer_source', customer_source);
	formData.append('customer_phone_introduce', customer_phone_introduce);

	$.ajax({
		url: _url.base_url + 'lead_custom/pgd_insert_lead',
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
			if (data.status == 200) {
				$('#successModal').modal('show');
				$('.msg_success').text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + 'lead_custom/list_transfe_office';
				}, 3000);
			} else {
				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});


function change_cskh(t) {
	var id = $(t).data('id');
	var email_cskh = $(t).val();
	var formData = new FormData();
	formData.append('id', id);
	formData.append('cskh', email_cskh);


	$.ajax({
		url: _url.base_url + 'lead_custom/do_update_cskh_lead',
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
			if (data.status == 200) {


			} else {


			}
		},
		error: function (data) {
			console.log(data);
			$('#errorModal').modal('show');
			$('.msg_error').text(data.msg);
			setTimeout(function () {
				$('#errorModal').modal('hide');
			}, 3000);
		}
	});
}
function change_cskh_taivay(t) {
	var id = $(t).data('id');
	var email_cskh = $(t).val();
	var formData = new FormData();
	formData.append('id', id);
	formData.append('cskh', email_cskh);


	$.ajax({
		url: _url.base_url + 'lead_custom/do_update_cskh_lead_taivay',
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
			if (data.status == 200) {


			} else {


			}
		},
		error: function (data) {
			console.log(data);
			$('#errorModal').modal('show');
			$('.msg_error').text(data.msg);
			setTimeout(function () {
				$('#errorModal').modal('hide');
			}, 3000);
		}
	});
}
function take_cskh(t) {
	var id = $(t).data('id');
	var email_cskh = $(t).data('email');
	var formData = new FormData();
	formData.append('id', id);
	formData.append('cskh', email_cskh);


	$.ajax({
		url: _url.base_url + 'lead_custom/do_update_cskh_lead',
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
			console.log(data.status);
			if (data.status == "200") {

				//   $("#successModal").modal("show");
				// $(".msg_success").text(data.msg);

				$("#" + id).val(email_cskh);
			} else {

				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
}

function check_all_cskh(t) {
	var tab = $(t).data("tab");
	var email_cskh = $("#cskh_tab1").val();
	$('.datatablebutton input:checked').each(function (item) {
		$("#" + $(this).val()).val(email_cskh);
		update_cskh($(this).val(), email_cskh);

	});
	setTimeout(function () {
		window.location.href = _url.base_url + 'lead_custom?tab=' + tab;
	}, 2000);
}

function check_all_cskh_tab4(t){
	var tab = $(t).data("tab");
	var email_cskh = $("#cskh_tab4").val();

	$('#datatablebutton_tab4 input:checked').each(function (item) {
		console.log("for")
		$("#" + $(this).val()).val(email_cskh);
		update_cskh($(this).val(), email_cskh);

	});
	setTimeout(function () {
		window.location.href = _url.base_url + 'lead_custom?tab=' + tab;
	}, 2000);
}

function check_all_cskh_taivay(t) {
	var tab = $(t).data("tab");
	var email_cskh = $("#cskh_tab13").val();
	$('.datatablebutton13 input:checked').each(function (item) {
		$("#" + $(this).val()).val(email_cskh);
		update_cskh_taivay($(this).val(), email_cskh);

	});
	setTimeout(function () {
		window.location.href = _url.base_url + 'lead_custom?tab=' + tab;
	}, 2000);
}
function update_cskh(id, email_cskh) {

	var formData = new FormData();
	formData.append('id', id);
	formData.append('cskh', email_cskh);

	console.log(11111)
	$.ajax({
		url: _url.base_url + 'lead_custom/do_update_cskh_lead',
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
			if (data.status == 200) {


			} else {

			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
}
function update_cskh_taivay(id, email_cskh) {

	var formData = new FormData();
	formData.append('id', id);
	formData.append('cskh', email_cskh);


	$.ajax({
		url: _url.base_url + 'lead_custom/do_update_cskh_lead_taivay',
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
			if (data.status == 200) {


			} else {

			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
}

function check_radio(check = '', type) {
	if (check == '1') {
		$(type[0]).prop('checked', true);
	} else if (check == '2') {
		$(type[1]).prop('checked', true);
	} else {
		$(type[1]).prop('checked', true);
	}
}

function check_drop_box(check = null, type, text) {
	remove_old_data('.no_' + type);
	if (check != null && check != 0) {
		$('[name="' + type + '"]').val(check);
	} else {
		$('[name="' + type + '"]').append('<option value="" class="no_' + type + '" selected>-- ' + text + ' --</option>');
	}
}

function check_selectize(check = null, type, t) {

	$('#' + type).data('selectize').setValue(check);
}

function check_drop_box_by_poperty(check = null, type, text) {

	var id = check;
	var formData = {
		id: id
	};
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
				$('#selectize_property_by_main').data('selectize').setValue(text);

			} else {
				// $('#errorModal').modal('show');
				// $('.msg_error').text(data.message);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
}

function empty(e) {
	switch (e) {
		case "":
		case 0:
		case "0":
		case null:
		case false:
		case typeof (e) == "undefined":
			return true;
		default:
			return false;
	}
}

function get_district_by_province(province, district = null, type) {

	if (district == null) {
		$('[name="' + type + '"]').append('<option value="" class="' + type + '">-- Chọn quận/huyện --</option>');
	}
	$.ajax({
		url: _url.base_url + 'lead_custom/get_district_by_province/' + province,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			let districts = result.data;
			var selectClass = $('select[name="' + type + '"]').selectize();
			var selectizeClass = selectClass[0].selectize;
			selectizeClass.clear();
			selectizeClass.clearOptions();
			selectizeClass.load(function (callback) {
				callback(districts);
			});
			console.log(district);
			$('select[name="' + type + '"]').data('selectize').setValue(district);


		}
	});
}

function get_ward_by_district(district, ward = null, type) {

	if (ward == null) {
		$('[name="' + type + '"]').append('<option value="" class="' + type + '">-- Chọn xã/phường --</option>');
	}
	$.ajax({
		url: _url.base_url + 'lead_custom/get_ward_by_district/' + district,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			let wards = result.data;
			var selectClass = $('select[name="' + type + '"]').selectize();
			var selectizeClass = selectClass[0].selectize;
			selectizeClass.clear();
			selectizeClass.clearOptions();
			selectizeClass.load(function (callback) {
				callback(wards);
			});
			console.log(ward);


			$('select[name="' + type + '"]').data('selectize').setValue(ward);


		}
	});
}

function remove_old_data(oid) {
	$(oid).remove();
}

$(document).ready(function () {
	$('.custom-control-input').change(function () {
		var states = [];
		$('.custom-control-input').each(function () {
			if (!$(this).is(':checked')) states.push($(this).data('control-column'));
		});
		setSates(states);
	});

	// when we need to set the sate of the UI, loop through the checkboxes checking if their "data-control-column" are in the "states" array
	// if so, hide the specified column and uncheck the box
	function setSates(states) {
		if (states) {
			if (!$.isArray(states)) states = JSON.parse(states); // if sates came from localstorage it will be a string, convert it to an array
			$('.custom-control-input').each(function (i, e) {
				var column = $(this).data('control-column');
				if ($.inArray(column, states) == -1) {
					$(this).attr('checked', true);
					$('.hide-show-column th:nth-of-type(' + column + '), .hide-show-column td:nth-of-type(' + column + ')').show();
				} else {
					$(this).attr('checked', false);
					$('.hide-show-column th:nth-of-type(' + column + '), .hide-show-column td:nth-of-type(' + column + ')').hide();
				}
			});
			localStorage.setItem('states', JSON.stringify(states));
		}
	}

	// this will read and set the initial states when the page loads
	setSates(localStorage.getItem('states'));

});

function call_for_customer(phone_number) {
	console.log(phone_number);
	if (phone_number == undefined || phone_number == '') {
		alert("Không có số");
	} else {


		$(".title_modal_approve").text("Gọi cho khách hàng");


		$("#number").val(phone_number);

		$("#approve_call").modal("show");
	}
}

$(document).ready(function () {

	$("#cskh_btnSave").click(function (event) {

		event.preventDefault();

		if ($('#selectize_cskh_value').val() != "") {
			var list_cskh = JSON.parse($('#selectize_cskh_value').val());
		}

		var formData = new FormData();
		formData.append('list_cskh', list_cskh);

		$.ajax({
			url: _url.base_url + 'lead_custom/update_list_cskh',
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
				if (data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + 'lead_custom';
					}, 3000);
				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					setTimeout(function () {
						$('#errorModal').modal('hide');
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	});

	$("#cskh_btnSave_del").click(function (event) {

		event.preventDefault();

		if ($('#selectize_cskh_value_del').val() != "") {
			var list_cskh_del = JSON.parse($('#selectize_cskh_value_del').val());
		}

		var formData = new FormData();
		formData.append('list_cskh_del', list_cskh_del);

		$.ajax({
			url: _url.base_url + 'lead_custom/update_list_cskh_del',
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
				if (data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + 'lead_custom';
					}, 3000);
				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					setTimeout(function () {
						$('#errorModal').modal('hide');
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	});



});

$('#selectize_cskh').selectize({
	create: false,
	valueField: 'selectize_cskh',
	labelField: 'name',
	searchField: 'name',
	maxItems: 20,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('[name="selectize_cskh[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#selectize_cskh').val()
	var data = [];
	if (value != null) {
		data.push(value);
	}
	$('#selectize_cskh_value').val(JSON.stringify(data));
})


$('#selectize_cskh_del').selectize({
	create: false,
	valueField: 'selectize_cskh_del',
	labelField: 'name',
	searchField: 'name',
	maxItems: 20,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('[name="selectize_cskh_del[]"]').on('change', function (event) {
	event.preventDefault();
	var value1 = $('#selectize_cskh_del').val()
	var data1 = [];
	if (value1 != null) {
		data1.push(value1);
	}
	$('#selectize_cskh_value_del').val(JSON.stringify(data1));
})

function restoreLead(thiz) {
	var id_lead = $(thiz).data("id");
	var tab = $(thiz).data("tab");
	var formData = {
		id_lead: id_lead
	}
	console.log(formData);
	var confirm_restore_lead = confirm(`Khi bạn thực hiện "Khôi phục", mọi dữ liệu đều ở trạng thái đã lưu trước đó. Khôi phục không?`);
	if (confirm_restore_lead == true) {
		$.ajax({
			url: _url.base_url + 'lead_custom/restoreLead',
			type: "POST",
			data: formData,
			dataType: "JSON",
			beforeSend: function (response) {
				$(".theloading").show();
			},
			success: function (response) {
				console.log(response);
				if (response.status == 200) {
					toastr.success(response.msg, {
						timeOut: 3000,
					});
					setTimeout(function () {
						showModal(id_lead);
					}, 5000);
				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(response.msg);
					setTimeout(function () {
						$('#errorModal').modal('hide');
					}, 3000);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 1000);
			}
		});
	}

}

function showModal_taivay(id_contract,id) {

	$.ajax({
		url: _url.base_url + 'lead_custom/showLeadInfo_taivay/' + id_contract,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="_id"]').val(id);
			$('[name="phone_number"]').val(result.data.customer_infor.customer_phone_number);
			$('[name="fullname"]').val(result.data.customer_infor.customer_name);
			$('[name="address"]').val(result.data.current_address.current_stay+' - '+result.data.current_address.ward_name+' - '+result.data.current_address.district_name+' - '+result.data.current_address.province_name);

			$('[name="email"]').val(result.data.customer_infor.customer_email);
			$('[name="identify_lead"]').val(result.data.customer_infor.customer_identify);
			$('[name="dob_lead"]').val(result.data.customer_infor.customer_BOD);
			
			check_drop_box(result.data.source, 'source', 'Chọn nguồn');
			if (typeof result.data.loan_infor.loan_product != "undefined") {
			check_drop_box(result.data.loan_infor.loan_product.code, 'type_finance', 'Chọn sản phẩm vay');
		    }
			check_drop_box(result.data.hk_province, 'hk_province', 'Chọn tỉnh/thành');
			check_drop_box(result.data.ns_province, 'ns_province', 'Chọn tỉnh/thành');
			$('select[name="hk_province"]').data('selectize').setValue(result.data.houseHold_address.province);
			$('select[name="ns_province"]').data('selectize').setValue(result.data.current_address.province);
			// check_drop_box(result.data.status_pgd, 'status_pgd', 'Chọn trạng thái PGD');
			// check_drop_box(result.data.reason_cancel_pgd, 'reason_cancel_pgd', 'Chọn lý do hủy PGD');
			// check_drop_box(result.data.reason_return, 'reason_return', 'Chọn lý do PGD trả về');
			// check_drop_box(result.data.reason_process, 'reason_process', 'Chọn lý do PGD đang xử lý');
			// let status_pgd_checked = $('#status_pgd').val();
			// if (status_pgd_checked == 8) {
			// 	$('#reason_return').show();
			// 	$('#reason_cancel_pgd').hide();
			// 	$('#reason_process').hide();
			// } else if (status_pgd_checked == 16) {
			// 	$('#reason_return').hide();
			// 	$('#reason_process').hide();
			// 	$('#reason_cancel_pgd').show();
			// } else if (status_pgd_checked == 17) {
			// 	$('#reason_return').hide();
			// 	$('#reason_cancel_pgd').hide();
			// 	$('#reason_process').show();
			// } else {
			// 	$('#reason_return').hide();
			// 	$('#reason_cancel_pgd').hide();
			// 	$('#reason_process').hide();
			// }

			check_selectize(result.data.loan_infor.name_property.id, 'property_by_main', 'Chọn nhãn hiệu đời xe');
			check_drop_box(result.data.loan_infor.number_day_loan/30, 'loan_time', 'Chọn thời hạn vay');
			check_drop_box(result.data.loan_infor.type_interest, 'type_repay', 'Chọn hình thức trả lãi');
			//check_drop_box(result.data.sim_chinh_chu, 'sim_chinh_chu', 'Chọn sim chính chủ');
			//check_drop_box(result.data.type_finance, 'type_finance', 'Chọn sản phẩm vay');

			get_district_by_province(result.data.houseHold_address.province, result.data.houseHold_address.district, type = 'hk_district');
			get_district_by_province(result.data.current_address.province, result.data.current_address.district, type = 'ns_district');

			$('select[name="hk_district"]').data('selectize').setValue(result.data.houseHold_address.district);
			$('select[name="ns_district"]').data('selectize').setValue(result.data.current_address.district);

			setTimeout(function () {
				get_ward_by_district(result.data.houseHold_address.district, result.data.houseHold_address.ward, type = 'hk_ward');
				get_ward_by_district(result.data.current_address.district, result.data.current_address.ward, type = 'ns_ward');
				$('select[name="hk_ward"]').data('selectize').setValue(result.data.houseHold_address.ward);
				$('select[name="ns_ward"]').data('selectize').setValue(result.data.current_address.ward);
			}, 3000);

			//check_drop_box(result.data.obj, 'obj', 'Chọn đối tượng');
			//check_drop_box(result.data.status_sale, 'status_sale', 'Mới');
			// check_drop_box(result.data.id_PDG, 'id_PDG', 'Chọn phòng GD');
			// check_drop_box(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
			//check_selectize(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
			//check_selectize(result.data.id_PDG, 'id_PDG', 'Chọn lý do');
			$('[name="com"]').val(result.data.job_infor.name_company);
			$('[name="com_address"]').val(result.data.job_infor.address_company);
			$('[name="position"]').val(result.data.job_infor.job_position);
			
			// check_radio(result.data.contract_work, ['#has_contract_work', '#no_contract_work']);
			// $('[name="other_contract"]').val(result.data.other_contract);
			check_radio(result.data.job_infor.receive_salary_via, ['#salary_pay_mon', '#salary_pay_card']);
			$('[name="income"]').val(result.data.job_infor.salary);
			$('[name="loan_amount"]').val(result.data.loan_infor.amount_money);
			//$('[name="amout_repay"]').val(result.data.amout_repay);
		    $('[name="time_work"]').val(result.data.job_infor.work_year);
			check_radio(1, ['#has_qualified', '#no_qualified']);
			// $('#has_qualified').prop('disabled', true);
			// $('#no_qualified').prop('disabled', true);
			$('input').removeAttr("readonly");
			$('select').removeAttr("disabled");
			$('textarea').removeAttr("readonly");
			$('#status_pgd').prop('disabled', true);
			$('#reason_return').prop('disabled', true);
			$('#reason_cancel_pgd').prop('disabled', true);
			$('#reason_process').prop('disabled', true);
			$('#pgd_note').prop('disabled', true);
			$('.form-control').parent().removeClass('has-error');
			
			$('.help-block').empty();
			
				$('.btnSave').show();
			
			$('#tab001_noteModal').modal('show');

		}
	});
}

$('#back_delete').click(function (){

	if (confirm('Bạn chắc chắn xóa?')){

		$.ajax({
			url: _url.base_url + 'lead_custom/back_delete',
			type: "POST",
			dataType: "JSON",
			success: function (response) {
				console.log(response);
				if (response.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Thành công');

					setTimeout(function () {
						window.location.href = _url.base_url + 'lead_custom?tab=1';
					}, 3000);

				} else {
					$('#errorModal').modal('show');

					$('.msg_error').text(response.msg);

					setTimeout(function () {
						$('#errorModal').modal('hide');
					}, 3000);
				}
			},
			error: function (error) {
				$('#errorModal').modal('show');

				$('.msg_error').text("Không có dữ liệu");

				setTimeout(function () {
					window.location.href = _url.base_url + 'lead_custom?tab=1';
				}, 3000);
			}
		});



	}




});

const showModal_note = function (id, phone) {
	console.log("phone: " + phone);
	$.ajax({
		url: _url.base_url + 'lead_custom/showNote/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result.data.data);
			$('#tab0014_noteModal').modal('show');
			$("input[name='idMissCall']").val(result.data.data.id);
			$("input[name='name']").val(result.data.data.name);
			$("input[name='date']").val(result.data.data.date);
			$("#address").val(result.data.data.address);
			$("input[name='cmt']").val(result.data.data.cmt);
			$("textarea[name='noteMissedCall']").val(result.data.data.noteMissedCall);
			$("#number2").val(phone);
		}
	});
};

$(document).ready(function () {

	$(".btnSaveMissedCall").click(function (event) {
		event.preventDefault();
		var id = $("input[name='idMissCall']").val();
		var name = $("input[name='name']").val();
		var date = $("#date").val();
		var address = $("#address").val();
		var cmt = $("input[name='cmt']").val();
		var noteMissedCall = $("textarea[name='noteMissedCall']").val();
		var formData = new FormData();
		formData.append('id', id)
		formData.append('name', name)
		formData.append('date', date)
		formData.append('address', address)
		formData.append('cmt', cmt)
		formData.append('noteMissedCall', noteMissedCall)
		console.log(id, name, date, address);
		$.ajax({
			url: _url.base_url + 'lead_custom/saveMissedCall',
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
				$(".modal_missed_call").hide();
				if (data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.msg);
					window.scrollTo(0, 0);
					setTimeout(function () {
						window.location.reload();
					}, 500);
				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					window.scrollTo(0, 0);
					setTimeout(function () {
						window.location.reload();
					}, 500);
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		})
	})

});






