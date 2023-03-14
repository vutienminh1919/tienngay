$("#send_exemptions").click(function (event) {
	event.preventDefault();
	var amount_customer_suggest = $("input[name='amount_customer_suggest']").val().split(',').join('');
	var date_suggest = $("input[name='date_suggest']").val();
	var date_customer_sign = $("input[name='date_customer_sign']").val();
	var type_payment_exem = $("input[name='type_payment_exem']:checked").val();
	var confirm_email = $("input[name='confirm_email']:checked").val();
	var is_exemption_paper = $("input[name='is_exemption_paper']:checked").val();
	var note_suggest = $(".note_suggest_exemptions").val();
	var status_exemptions = $(".status_exemptions").val();
	var id_contract = $("input[name='contract_id']").val();
	var code_contract = $("input[name='code_contract']").val();
	var number_date_late = $("input[name='number_date_late']").val();
	amount_customer_suggest.split('.').join('');
	var count = $("img[name='img_contract']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_contract']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'create_img_ex') {
				image_file[key] = data;
			}

		});
	}
	if (confirm("Xác nhận gửi đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_contract: id_contract,
				code_contract: code_contract,
				store: getStoreInfor(),
				amount_customer_suggest: amount_customer_suggest,
				date_suggest: date_suggest,
				date_customer_sign: date_customer_sign,
				image_file: image_file,
				type_payment_exem: type_payment_exem,
				confirm_email: confirm_email,
				is_exemption_paper: is_exemption_paper,
				note: note_suggest,
				status: status_exemptions,
				number_date_late: number_date_late,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text("Tạo đơn miễn giảm thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	}

});

$("#cancel_create").click(function () {
	window.location.reload();
});
$(document).on("click", "#cancel_update", function (event) {
	window.location.reload();
});

function showModal_lead_thn(id) {
	$("#number_code_contract").empty();
	$("#amount_customer_suggest1").empty();
	$("#date_suggest_exemption").empty();
	$("#date_customer_sign1").empty();
	$("#type_suggest_exemption").empty();
	$("#image_exemption_profile").empty();
	$("#note_suggest_exemptions").empty();
	$("#confirm_email").empty();
	$("#is_exemption_paper").empty();
	$(".note_suggest_exemptions").empty();
	$(".note_tp_thn_input").empty();
	$(".note_lead_thn").empty();
	$(".number_date_late").empty();

	$.ajax({
		url: _url.base_url + 'exemptions/contractExemptionsInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);
			var image_exemption_profile = result.data.image_exemption_profile;
			var date_suggest_convert = new Date(result.data.date_suggest * 1000).format('d/m/Y');
			var start_date_effect_convert = new Date(result.data.start_date_effect * 1000).format('d/m/Y');
			var type_payment_exem = (result.data.type_payment_exem && result.data.type_payment_exem == 2) ? "Tất toán" : "Thanh toán";
			var confirm_email = (result.data.confirm_email && result.data.confirm_email == 2) ? "Không có" : "Có";
			var is_exemption_paper = (result.data.is_exemption_paper && result.data.is_exemption_paper == 2) ? "Không có" : "Có";
			if (result.data.number_date_late) {
				var number_date_late = result.data.number_date_late;
			}
			var html_code_contract = "";
			var html_amount = "";
			var html_date = "";
			var html_date_sign = "";
			var html_img = "";
			var html_type_payment_exem = "";
			var html_confirm_email = "";
			var html_is_exemption_paper = "";
			var html_note = "";
			var html_number_date_late = "";


			html_code_contract += "<p style='padding-top: 8px; color: black'>" + result.data.code_contract_disbursement + "</p>";
			html_amount += "<p class='text-danger' style='padding-top: 8px'>" + numeral(result.data.amount_customer_suggest).format('0,0') + " đồng" + "</p>";
			html_date += "<p style='padding-top: 8px; color: black'>" + date_suggest_convert + "</p>";
			html_date_sign += "<p style='padding-top: 8px; color: black'>" + start_date_effect_convert + "</p>";
			html_type_payment_exem += "<p style='padding-top: 8px; color: black'>" + type_payment_exem + "</p>";
			html_confirm_email += "<p style='padding-top: 8px; color: black'>" + confirm_email + "</p>";
			html_is_exemption_paper += "<p style='padding-top: 8px; color: black'>" + is_exemption_paper + "</p>";
			html_number_date_late += "<p style='padding-top: 8px; color: red;'>" + number_date_late + "</p>";
			html_note += "<textarea class='col-md-12 col-xs-12' style='color: black' rows='2' disabled>" + result.data.note + "</textarea>";
			if (image_exemption_profile != "") {
				for (var j in image_exemption_profile) {
					var profile_img = new URL(image_exemption_profile[j].path);
					const date_upload_img = new Date((profile_img.pathname).slice(16, 26) * 1000).format('d/m/Y H:i:s');

					if (image_exemption_profile[j].file_type == 'image/png' || image_exemption_profile[j].file_type == 'image/jpg' || image_exemption_profile[j].file_type == 'image/jpeg') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a class='magnifyitem' href='" + image_exemption_profile[j].path + "' data-magnify='gallery' data-group='thegallery' data-gallery='image_create_exemption' data-max-width='992' data-type='image' data-title='Hồ sơ miễn giảm'>" +
							"<img name='img_contract' data-key='" + image_exemption_profile[j].key + "' data-fileName='" + image_exemption_profile[j].file_name + "' data-fileType='" + image_exemption_profile[j].file_type + "' data-type='create_img_ex' class='w-100' src='" + image_exemption_profile[j].path + "'></a>";
						html_img += "</div>";
					}
					if (image_exemption_profile[j].file_type == 'audio/mp3' || image_exemption_profile[j].file_type == 'audio/mpeg') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'>" +
							"</a>";
						html_img += "</div>"
					}
					if (image_exemption_profile[j].file_type == 'video/mp4') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'>" +
							"</a>";
						html_img += "</div>"
					}
					if (image_exemption_profile[j].file_type == 'application/pdf') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" +
							"</a>";
						html_img += "</div>"
					}
				}

			} else {
				html_img += "<td></td>"
			}

			$("#number_code_contract").append(html_code_contract);
			$("#amount_customer_suggest1").append(html_amount);
			$("#date_suggest_exemption").append(html_date);
			$("#date_customer_sign1").append(html_date_sign);
			$("#type_suggest_exemption").append(html_type_payment_exem);
			$("#confirm_email").append(html_confirm_email);
			$("#is_exemption_paper").append(html_is_exemption_paper);
			$("#image_exemption_profile").append(html_img);
			$("#note_suggest_exemptions").append(html_note);
			$(".number_date_late").append(html_number_date_late);
			$("input[name='id_exemption_contract']").val(result.data._id.$oid);
			$("input[name='id_contract']").val(result.data.id_contract);
			$("input[name='code_contract']").val(result.data.code_contract);

			if (result.data.status == 1) {
				$("#tp_thn_process").hide();
				$("#qlcc_thn_process").hide();
			}
			$('#lead_thn_approve').modal('show');
		}
	});
}

$("#lead_return").click(function () {
	var status = 3;
	var id_exemption = $("input[name='id_exemption_contract']").val();
	var id_contract = $("input[name='id_contract']").val();
	var code_contract = $("input[name='code_contract']").val();
	var note_lead_thn = $(".note_lead_thn").val();
	var position = "lead";
	if (confirm("Xác nhận trả về đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_contract: id_contract,
				id_exemption: id_exemption,
				code_contract: code_contract,
				status: status,
				note_lead: note_lead_thn,
				position: position,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text("Trả về đơn miễn giảm thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		})
	}

});
$(document).on("click", "#update_exemptions", function (event) {

	// $("#update_exemptions").click(function () {
	var id_exemption = $("input[name='id_exemption']").val();
	var id_contract = $("input[name='id_contract']").val();
	var code_contract = $("input[name='code_contract']").val();
	var type_payment_exem = $("input[name='type_payment_exem']:checked").val();
	var confirm_email = $("input[name='confirm_email']:checked").val();
	var is_exemption_paper = $("input[name='is_exemption_paper']:checked").val();
	var amount_customer_suggest = $(".amount_customer_suggest").val();
		amount_customer_suggest.split('.').join('');
	var date_suggest = $(".date_suggest").val();
	var date_customer_sign = $("input[name='date_customer_sign']").val();
	var number_date_late = $("input[name='number_date_late']").val();
	var note_suggest_exemptions = $("#note_suggest_exemptions").val();
	var status_update = $(".status_update").val();

	var count = $("img[name='img_contract']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_contract']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'exemption_profile') {
				image_file[key] = data;
			}
		});
	}

	if (confirm("Xác nhận gửi lại đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_exemption: id_exemption,
				id_contract: id_contract,
				code_contract: code_contract,
				amount_customer_suggest: amount_customer_suggest,
				date_suggest: date_suggest,
				date_customer_sign: date_customer_sign,
				image_file: image_file,
				note: note_suggest_exemptions,
				status_update: status_update,
				type_payment_exem: type_payment_exem,
				confirm_email: confirm_email,
				is_exemption_paper: is_exemption_paper,
				number_date_late: number_date_late,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text("Gửi lại yêu cầu thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 2000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	}
});

$("#lead_cancel").click(function () {
	var id_exemption = $("input[name='id_exemption_contract']").val();
	var id_contract = $("input[name='id_contract']").val();
	var code_contract = $("input[name='code_contract']").val();
	var note_lead_thn = $(".note_lead_thn").val();
	var position = "lead";
	// Hủy
	var status = 2;
	if (confirm("Xác nhận Hủy đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_contract: id_contract,
				id_exemption: id_exemption,
				code_contract: code_contract,
				status: status,
				note_lead: note_lead_thn,
				position: position,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text("Hủy đơn miễn giảm thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 2000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		})
	}
});

// Khôi phục đơn miễn giảm
$("#restore_exemption_contract").click(function () {
	$('#hide_alert_cancel').hide();
	var id_exemption = $("input[name='id_exemption']").val();
	var id_contract = $("input[name='id_contract']").val();
	var code_contract = $("input[name='code_contract']").val();
	var type_payment_exem = $("input[name='type_payment_exem']:checked").val();

	var formData = {
		id_exemption: id_exemption,
		id_contract: id_contract,
		code_contract: code_contract,
		type_payment_exem: type_payment_exem
	};

	$.ajax({
		url: _url.base_url + 'exemptions/restore_exemption_contract',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			$("#loading").hide();
			if (data.status == 200) {
				console.log(data);
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					$("#successModal").modal("hide");
				}, 3000);
				$("#append_html").html('<div class="row" id="restore_exemption_contract_btn"><div class="col-md-12 col-xs-12 text-right"><button id="update_exemptions" class="btn btn-secondary">Hủy</button><button id="update_exemptions" class="btn btn-info">Gửi lại yêu cầu</button></div></div>');

			} else {
				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
				$('#update_exemptions').hide();
				setTimeout(function () {
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$("#loading").hide();
		}
	});

});

// Lead THN đồng ý duyệt
$("#lead_confirm").click(function () {
	var id_exemption = $("input[name='id_exemption_contract']").val();
	var id_contract = $("input[name='id_contract']").val();
	var code_contract = $("input[name='code_contract']").val();
	var status = 4;
	var position = "lead";
	var note_lead = $(".note_lead_thn").val();

	var formData = {
		id_exemption: id_exemption,
		id_contract: id_contract,
		code_contract: code_contract,
		position: position,
		status: status,
		note_lead: note_lead,
	};
	if (confirm("Xác nhận gửi lên TP QLHDV?")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status == 200) {
					console.log(data);
					$("#successModal").modal("show");
					$(".msg_success").text('Gửi yêu cầu lên trưởng phòng thành công!');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 2000);
				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					$('#update_exemptions').hide();
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	}
});


// TP THN xử lý
function tpthn_xu_ly(id) {

	$('#image_create_exemption').next().next().remove();
	$("#number_code_contract_modal_tp").empty();
	$("#amount_customer_suggest_modal_tp").empty();
	$("#date_suggest_exemption_modal_tp").empty();
	$("#date_customer_sign_modal_tp").empty();
	$("#type_suggest_exemption_modal_tp").empty();
	$("#confirm_email_tp").empty();
	$("#is_exemption_paper_tp").empty();
	$("#image_exemption_profile_modal_tp").empty();
	$("#note_suggest_exemptions_modal_tp").empty();
	$(".note_lead_append_modal_tp").empty();
	$(".note_tp_thn_modal_tp").empty();
	$("#note_lead_append_modal_tp").empty();
	$(".number_date_late").empty();

	$.ajax({
		url: _url.base_url + 'exemptions/contractExemptionsInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			if (result.data.status == 5) {
				$("#tp_return").prop('disabled', true)
				$("#tp_confirm").prop('disabled', true)
			}
			var image_exemption_profile = result.data.image_exemption_profile;
			var date_suggest_convert = new Date(result.data.date_suggest * 1000).format('d/m/Y');
			var date_customer_sign_convert = new Date(result.data.start_date_effect * 1000).format('d/m/Y');
			var type_payment_exem = (result.data.type_payment_exem && result.data.type_payment_exem == 2) ? "Tất toán" : "Thanh toán";
			var confirm_email = (result.data.confirm_email && result.data.confirm_email == 2) ? "Không có" : "Có";
			var is_exemption_paper = (result.data.is_exemption_paper && result.data.is_exemption_paper == 2) ? "Không có" : "Có";
			if (result.data.number_date_late) {
				var number_date_late = result.data.number_date_late;
			}
			var html_code_contract = "";
			var html_amount = "";
			var html_date = "";
			var html_date_sign = "";
			var html_img = "";
			var html_note = "";
			var html_type_payment_exem = "";
			var html_confirm_email = "";
			var html_is_exemption_paper = "";
			var html_note_lead = "";
			var html_number_date_late = "";


			html_code_contract += "<p style='padding-top: 8px; color: black'>" + result.data.code_contract_disbursement + "</p>";
			html_amount += "<p class='text-danger' style='padding-top: 8px'>" + numeral(result.data.amount_customer_suggest).format('0,0') + " đồng" + "</p>";
			html_date += "<p style='padding-top: 8px; color: black'>" + date_suggest_convert + "</p>";
			html_date_sign += "<p style='padding-top: 8px; color: black'>" + date_customer_sign_convert + "</p>";
			html_type_payment_exem += "<p style='padding-top: 8px; color: black'>" + type_payment_exem + "</p>";
			html_confirm_email += "<p style='padding-top: 8px; color: black'>" + confirm_email + "</p>";
			html_is_exemption_paper += "<p style='padding-top: 8px; color: black'>" + is_exemption_paper + "</p>";
			html_note += "<textarea class='col-md-12 col-xs-12' style='color: black' rows='2' disabled>" + result.data.note + "</textarea>";
			html_note_lead += "<textarea class='col-md-12 col-xs-12' style='color: black' rows='2' disabled>" + result.data.note_lead + "</textarea>";
			html_number_date_late += "<p style='padding-top: 8px; color: red;'>" + number_date_late + "</p>";
			if (image_exemption_profile != "") {
				for (var j in image_exemption_profile) {
					var profile_img = new URL(image_exemption_profile[j].path);
					const date_upload_img = new Date((profile_img.pathname).slice(16, 26) * 1000).format('d/m/Y H:i:s');

					if (image_exemption_profile[j].file_type == 'image/png' || image_exemption_profile[j].file_type == 'image/jpg' || image_exemption_profile[j].file_type == 'image/jpeg') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a class='magnifyitem' href='" + image_exemption_profile[j].path + "' data-magnify='gallery' data-group='thegallery' data-gallery='image_create_exemption' data-max-width='992' data-type='image' data-title='Hồ sơ miễn giảm'>" +
							"<img name='img_contract' data-key='" + image_exemption_profile[j].key + "' data-fileName='" + image_exemption_profile[j].file_name + "' data-fileType='" + image_exemption_profile[j].file_type + "' data-type='create_img_ex' class='w-100' src='" + image_exemption_profile[j].path + "'></a>";
						html_img += '<button type="button" onclick="deleteImage(this)" data-type="create_img_ex" data-key="' + image_exemption_profile[j].key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						html_img += "</div>";
					}
					if (image_exemption_profile[j].file_type == 'audio/mp3' || image_exemption_profile[j].file_type == 'audio/mpeg') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'>" +
							"</a>";
						html_img += '<button type="button" onclick="deleteImage(this)" data-type="create_img_ex" data-key="' + image_exemption_profile[j].key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						html_img += "</div>"
					}
					if (image_exemption_profile[j].file_type == 'video/mp4') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'>" +
							"</a>";
						html_img += '<button type="button" onclick="deleteImage(this)" data-type="create_img_ex" data-key="' + image_exemption_profile[j].key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						html_img += "</div>"
					}
					if (image_exemption_profile[j].file_type == 'application/pdf') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" +
							"</a>";
						html_img += '<button type="button" onclick="deleteImage(this)" data-type="create_img_ex" data-key="' + image_exemption_profile[j].key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						html_img += "</div>"
					}
				}

			} else {
				html_img += "<td></td>"
			}

			$("#number_code_contract_modal_tp").append(html_code_contract);
			$("#amount_customer_suggest_modal_tp").append(html_amount);
			$("#date_suggest_exemption_modal_tp").append(html_date);
			$("#date_customer_sign_modal_tp").append(html_date_sign);
			$("#type_suggest_exemption_modal_tp").append(html_type_payment_exem);
			$("#confirm_email_tp").append(html_confirm_email);
			$("#is_exemption_paper_tp").append(html_is_exemption_paper);
			$("#image_exemption_profile_modal_tp").append(html_img);
			$("#note_suggest_exemptions_modal_tp").append(html_note);
			$("#note_lead_append_modal_tp").append(html_note_lead);
			$(".number_date_late").append(html_number_date_late);
			$("input[name='id_exemption_contract_modal_tp']").val(result.data._id.$oid);
			$("input[name='id_contract_modal_tp']").val(result.data.id_contract);
			$("input[name='code_contract_modal_tp']").val(result.data.code_contract);
			$("input[name='amount_tp_thn_suggest_modal_tp']").val(numeral(result.data.amount_tp_thn_suggest).format('0,0'));
			$(".note_tp_thn_modal_tp").val(result.data.note_tp_thn);
			var user_receive_cc = [];

			$(".checkbox_email_high").prop("checked", true);

			$(".checkbox_email_cc:checked").each(function () {
				user_receive_cc.push($(this).val());
			});
			$('#tp_thn_approve').modal('show');
		}
	});
}

// TP THN trả về đơn miễn giảm
$("#tp_return").click(function () {
	var status = 8;
	var id_exemption = $("input[name='id_exemption_contract_modal_tp']").val();
	var id_contract = $("input[name='id_contract_modal_tp']").val();
	var code_contract = $("input[name='code_contract_modal_tp']").val();
	var note_tp_thn = $(".note_tp_thn_modal_tp").val();
	var position = "tp";
	if (confirm("Xác nhận trả về đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_exemption: id_exemption,
				id_contract: id_contract,
				code_contract: code_contract,
				status: status,
				note_tp_thn: note_tp_thn,
				position: position,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text('Trả về đơn miễn giảm thành công!');
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		})
	}
});
// TP THN Hủy đơn miễn giảm
$("#tp_cancel").click(function () {
	var status = 2;
	var id_exemption = $("input[name='id_exemption_contract_modal_tp']").val();
	var id_contract = $("input[name='id_contract_modal_tp']").val();
	var code_contract = $("input[name='code_contract_modal_tp']").val();
	var note_tp_thn = $(".note_tp_thn_modal_tp").val();
	var position = "tp";
	if (confirm("Xác nhận hủy đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_exemption: id_exemption,
				id_contract: id_contract,
				code_contract: code_contract,
				status: status,
				note_tp_thn: note_tp_thn,
				position: position,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text('Hủy đơn miễn giảm thành công!');
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		})
	}
});
// TP THN đồng ý duyệt
$("#tp_confirm").click(function () {
	var id_exemption = $("input[name='id_exemption_contract_modal_tp']").val();
	var id_contract = $("input[name='id_contract_modal_tp']").val();
	var code_contract = $("input[name='code_contract_modal_tp']").val();
	var amount_tp_thn_suggest = $("#amount_tp_thn_suggest_modal_tp").val().split(',').join('');
	amount_tp_thn_suggest.split('.').join('');
	var note_tp_thn = $("#note_tp_thn_modal_tp").val();
	var status = 5;
	var count = $("img[name='img_contract']").length;
	var image_selector = $("img[name='img_contract']");
	var image_file = {};
	if (count > 0) {
		image_selector.each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'create_img_ex') {
				image_file[key] = data;
			}
		});
	}
	var formData = {
		id_exemption: id_exemption,
		id_contract: id_contract,
		code_contract: code_contract,
		image_file: image_file,
		amount_tp_thn_suggest: amount_tp_thn_suggest,
		note_tp_thn: note_tp_thn,
		status: status,
	};
	if (confirm("Xác nhận duyệt đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				$("#loading").hide();
				if (data.status == 200) {
					console.log(data);
					$(".theloading").hide();
					$(".alert-danger").css('display', 'none');
					$("#successModal").modal("show");
					$(".msg_success").text('Duyệt đơn miễn giảm thành công!');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".alert-danger").css('display', 'block');
					$(".alert-danger").text(data.msg);
				}
			},
			error: function (data) {
				console.log(data);
				$("#loading").hide();
			}
		});
	}
});


// TP THN gửi lên cao
$("#confirm_send").click(function (event) {
	event.preventDefault();
	if (confirm('Xác nhận gửi lên cấp cao?')) {
		var user_receive_approve = $('input[name="user_receive_approve"]:checked').val();

		var user_receive_cc = [];
		$(".checkbox_email_cc:checked").each(function () {
			console.log($(this).val());

			user_receive_cc.push($(this).val());
		});
		var id_contract = $("input[name='id_contract_modal_tp']").val();
		var id_exemption = $("input[name='id_exemption_contract_modal_tp']").val();
		var code_contract = $("input[name='code_contract_modal_tp']").val();
		var amount_tp_thn_suggest = $("input[name='amount_tp_thn_suggest_modal_tp']").val();
		var note_tp_thn = $(".note_tp_thn_modal_tp").val();
		var status = 6;
		var count = $("img[name='img_contract']").length;
		var image_selector = $("img[name='img_contract']");
		var image_file = {};
		if (count > 0) {
			image_selector.each(function () {
				var data = {};
				type = $(this).data('type');
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				data['key'] = $(this).attr('data-key');
				var key = $(this).data('key');
				if (type == 'create_img_ex') {
					image_file[key] = data;
				}
			});
		}
		var store = $("select[name='store']").val()
		var formData = {
			id_exemption: id_exemption,
			id_contract: id_contract,
			code_contract: code_contract,
			image_file: image_file,
			amount_tp_thn_suggest: amount_tp_thn_suggest,
			note_tp_thn: note_tp_thn,
			status: status,
			user_receive_approve: user_receive_approve,
			user_receive_cc: user_receive_cc,
		};
		// var formData = new FormData();
		//
		// formData.append('id_contract', id_contract);
		// formData.append('id_exemption', id_exemption);
		// formData.append('code_contract', code_contract);
		// formData.append('image_file', image_file);
		// formData.append('amount_tp_thn_suggest', amount_tp_thn_suggest);
		// formData.append('note_tp_thn', note_tp_thn);
		// formData.append('user_receive_approve', user_receive_approve);
		// formData.append('user_receive_cc', user_receive_cc);
		// formData.append('status', status);
		console.log(formData);
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			type: "POST",
			data: formData,
			dataType: 'json',
			// processData: false,
			// contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				console.log(data)
				if (data.status == 200) {
					$(".theloading").hide();
					$(".alert-danger").css('display','none');
					$('.msg_success').text("Gửi lên quản lý cấp cao thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".alert-danger").css('display', 'block');
					$(".alert-danger").text(data.msg);
				}
			},
			error: function () {
				$(".theloading").hide();
				$(".alert-danger").css('display', 'block');
				$(".alert-danger").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
			}
		});
	}
});

// QLCC xử lý
function qlcc_xu_ly(id) {
	$("#number_code_contract_modal_qlcc").empty();
	$("#amount_customer_suggest_modal_qlcc").empty();
	$(".amount_customer_suggest").empty();
	$("#date_suggest_exemption_modal_qlcc").empty();
	$("#image_exemption_profile_modal_qlcc").empty();
	$("#note_suggest_exemptions_modal_qlcc").empty();
	$(".note_suggest_exemptions").empty();
	$(".note_tp_thn_modal_qlcc").empty();
	$(".note_qlcc").empty();
	$("#note_lead_append_modal_qlcc").empty();
	$("#amount_tp_suggest").empty();

	$.ajax({
		url: _url.base_url + 'exemptions/contractExemptionsInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);
			var image_exemption_profile = result.data.image_exemption_profile;
			var date_suggest_convert = new Date(result.data.date_suggest * 1000).format('d/m/Y')

			var html_code_contract = "";
			var html_amount = "";
			var html_amount_tp = "";
			var html_date = "";
			var html_img = "";
			var html_note = "";
			var html_note_lead = "";


			html_code_contract += "<p style='padding-top: 8px; color: black'>" + result.data.code_contract_disbursement + "</p>";
			html_amount += "<p class='text-danger' style='padding-top: 8px'>" + numeral(result.data.amount_customer_suggest).format('0,0') + " đồng" + "</p>";
			html_amount_tp += "<p class='text-danger' style='padding-top: 8px'>" + numeral(result.data.amount_tp_thn_suggest).format('0,0') + " đồng" + "</p>";
			html_date += "<p style='padding-top: 8px; color: black'>" + date_suggest_convert + "</p>";
			html_note += "<textarea class='col-md-12 col-xs-12' style='color: black' rows='2' disabled>" + result.data.note + "</textarea>";
			html_note_lead += "<textarea class='col-md-12 col-xs-12' style='color: black' rows='2' disabled>" + result.data.note_lead + "</textarea>";
			if (image_exemption_profile != "") {
				for (var j in image_exemption_profile) {
					var profile_img = new URL(image_exemption_profile[j].path);
					const date_upload_img = new Date((profile_img.pathname).slice(16, 26) * 1000).format('d/m/Y H:i:s');

					if (image_exemption_profile[j].file_type == 'image/png' || image_exemption_profile[j].file_type == 'image/jpg' || image_exemption_profile[j].file_type == 'image/jpeg') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a class='magnifyitem' href='" + image_exemption_profile[j].path + "' data-magnify='gallery' data-group='thegallery' data-gallery='image_create_exemption' data-max-width='992' data-type='image' data-title='Hồ sơ miễn giảm'>" +
							"<img name='img_contract' data-key='" + image_exemption_profile[j].key + "' data-fileName='" + image_exemption_profile[j].file_name + "' data-fileType='" + image_exemption_profile[j].file_type + "' data-type='create_img_ex' class='w-100' src='" + image_exemption_profile[j].path + "'></a>";
						html_img += "</div>";
					}
					if (image_exemption_profile[j].file_type == 'audio/mp3' || image_exemption_profile[j].file_type == 'audio/mpeg') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'>" +
							"<img name='img_contract' data-key='" + image_exemption_profile[j].key + "' data-fileName='" + image_exemption_profile[j].file_name + "' data-fileType='" + image_exemption_profile[j].file_type + "'  data-type='create_img_ex' class='w-100' src='" + image_exemption_profile[j].path + "' ></a>";
						html_img += "</div>"
					}
					if (image_exemption_profile[j].file_type == 'video/mp4') {
						html_img += "<div class='block'>";
						html_img += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img += "<a href='" + image_exemption_profile[j].path + "' target='_blank'><span style='z-index: 9'>" + image_exemption_profile[j].file_name + "</span>" +
							"<img name='img_contract' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'>" +
							"<img name='img_contract' data-key='" + image_exemption_profile[j].key + "' data-fileName='" + image_exemption_profile[j].file_name + "' data-fileType='" + image_exemption_profile[j].file_type + "'  data-type='create_img_ex' class='w-100' src='" + image_exemption_profile[j].path + "' ></a>";
						html_img += "</div>"
					}
				}

			} else {
				html_img += "<td></td>"
			}

			$("#number_code_contract_modal_qlcc").append(html_code_contract);
			$("#amount_customer_suggest_modal_qlcc").append(html_amount);
			$(".amount_customer_suggest").append(html_amount);
			$("#amount_tp_suggest").append(html_amount_tp);
			$("#date_suggest_exemption_modal_qlcc").append(html_date);
			$("#image_exemption_profile_modal_qlcc").append(html_img);
			$("#note_suggest_exemptions_modal_qlcc").append(html_note);
			$(".note_suggest_exemptions").append(html_note);
			$("#note_lead_append_modal_qlcc").append(html_note_lead);
			$("input[name='id_exemption_contract_modal_qlcc']").val(result.data._id.$oid);
			$("input[name='id_contract_modal_qlcc']").val(result.data.id_contract);
			$("input[name='code_contract_modal_qlcc']").val(result.data.code_contract);
			$(".note_tp_thn_modal_qlcc").val(result.data.note_tp_thn);
			$("textarea[name='note_tp_thn_modal_qlcc']").prop('disabled', true);
			$('#qlcc_approve').modal('show');
		}
	});
}

// QLCC không chấp nhận
$("#qlcc_cancel").click(function () {
	var status = 9;
	var id_contract = $("input[name='id_contract_modal_qlcc']").val();
	var id_exemption = $("input[name='id_exemption_contract_modal_qlcc']").val();
	var code_contract = $("input[name='code_contract_modal_qlcc']").val();
	var note_qlcc = $(".note_qlcc").val();
	var position = "qlcc";
	if (confirm("Xác nhận trả về đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_contract: id_contract,
				id_exemption: id_exemption,
				code_contract: code_contract,
				status: status,
				note_qlcc: note_qlcc,
				position: position,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text('Trả về đơn miễn giảm thành công!');
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		})
	}
});

// QLCC đồng ý duyệt
$("#qlcc_confirm").click(function () {
	var id_contract = $("input[name='id_contract_modal_qlcc']").val();
	var id_exemption = $("input[name='id_exemption_contract_modal_qlcc']").val();
	var code_contract = $("input[name='code_contract_modal_qlcc']").val();
	var note_qlcc = $(".note_qlcc").val();
	var status = 7;
	var position = "qlcc";

	if (confirm("Xác nhận duyệt đơn miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'exemptions/approve_exemptions',
			method: "POST",
			data: {
				id_contract: id_contract,
				id_exemption: id_exemption,
				code_contract: code_contract,
				status: status,
				note_qlcc: note_qlcc,
				position: position,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text("Duyệt đơn miễn giảm thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		})
	}
});


$('input[type=file]').change(function () {
	var contain = $(this).data("contain");
	var title = $(this).data("title");
	var type = $(this).data("type");
	var contractId = $("#contract_id").val();
	$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
		//$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
		allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4", "pdf"],
		allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif","application/pdf"],
		maxFileSize: 20000000, //10MB,
		multiple: true,
		limit: 10,
		start: function (file) {
			fileType = file.type;
			fileName = file.name;
			//upload started
			this.block = $('<div class="block"></div>');
			this.progressBar = $('<div class="progressBar"></div>');
			this.block.append(this.progressBar);
			$('#' + contain).append(this.block);
		},
		data: {
			'type_img': type,
			'contract_id': contractId
		},
		progress: function (progress) {
			//received progress
			this.progressBar.width(progress + "%");
		},
		success: function (data) {
			//upload successful
			this.progressBar.remove();
			if (data.code == 200) {
				var profile_img = new URL(data.path);
				const date_upload_img = new Date((profile_img.pathname).slice(16, 26) * 1000).format('d/m/Y H:i:s');
				// Video Mp4
				if (fileType == 'video/mp4') {
					var item = "";
					item += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="avatar-file"><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_contract"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				}
				// Mp3
				else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
					var item = "";
					item += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="avatar-file"><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_contract"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				}
				// Pdf
				else if (fileType == 'application/pdf') {
					var item = "";
					item += '<a  href="'+ data.path +'" target="_blank"><span style="z-index: 9">'+ fileName +'</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="avatar-file"><img style="display:none" data-type="'+ type +'" data-fileType="'+ fileType +'"  data-fileName="'+ fileName +'" name="img_contract"  data-key="'+ data.key +'" src="'+ data.path +'" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="'+ contractId +'" data-type="'+ type +'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				}
				// Image
				else {
					var item = "";
					item += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
					item += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" data-gallery="' + contain + '" data-max-width="992" data-type="image" data-title="' + title + '">';
					item += '<img data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_contract"  data-key="' + data.key + '" src="' + data.path + '" />';
					item += '</a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				}
				var data = $('<div ></div>').html(item);
				this.block.append(data);
			} else {
				//our application returned an error
				var error = data.msg;
				this.block.remove();
				alert(error);
			}
		},
		error: function (error) {
			var msg = error.msg;
			this.block.remove();
			alert("File không đúng định dạng");
		}
	});
});

function getStoreInfor() {
	var StoreInfor = {};
	var id = $("input[name='store_id']").val();
	// var id = $("#stores :selected").val();
	var address = $("input[name='store_address']").val();
	var name = $("input[name='store_name']").val();
	StoreInfor['id'] = id;
	StoreInfor['name'] = name;
	StoreInfor['address'] = address;
	return StoreInfor;
}

$('#amount_customer_suggest').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('#amount_tp_thn_suggest_modal_tp').on('input', function (e) {
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

$('.amount_customer_suggest').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.amount_customer_suggest').keyup(function (event) {
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


var hash = window.location.hash;
hash && $('ul.nav a[href="' + hash + '"]').tab('show');

$('.nav-pills a').click(function (e) {
	$(this).tab('show');
	var scrollmem = $('body').scrollTop();
	window.location.hash = this.hash;
	$('html,body').scrollTop(scrollmem);
});

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	if (confirm("Bạn có chắc chắn muốn xóa ảnh này ?")) {
		$(thiz_).closest("div .block").remove();
		toastr.success("Xóa ảnh thành công!", {
			timeOut: 2000,
		});
	}
}

$(document).ready(function () {
	$('#select_all_exemption').click(function () {
		if (this.checked) {
			$('.checkbox_process_exemp').each(function () {
				this.checked = true;
			})
		} else {
			$('.checkbox_process_exemp').each(function () {
				this.checked = false;
			})
		}
	})

	$('.checkbox_process_exemp').click(function () {
		if (!this.checked) {
			$('#select_all_exemption').prop('checked', false)
		}
	});

	$('#check_all_exem').click(function () {
		if (this.checked) {
			$('.checkbox_process_detail').each(function () {
				this.checked = true;
			});
		} else {
			$('.checkbox_process_detail').each(function () {
				this.checked = false;
			});
		}
	});

	$('.checkbox_process_detail').click(function () {
		$('#check_all_exem').prop('checked', false);
	});

	$('#select_all_exemp').click(function () {
		if (this.checked) {
			$('.check_id_exemption ').each(function () {
				this.checked = true;
			})
		} else {
			$('.check_id_exemption ').each(function () {
				this.checked = false;
			})
		}
	});

	$('#id_exemp_checkbox').click(function () {
		if (!this.checked) {
			$('#select_all_exemp').prop('checked', false);
		}
	});

	// $('#id_exemp_checkbox').click(function () {
	// 	$('.select_all_exemp').prop('checked', false);
	// });


})

// function approve_profile_exemption(thiz) {
// 	$('#select_all_exemption').prop('checked', false)
// 	let option = $('#choose_option').val();
// 	$('#table_exemption input:checked').each(function () {
// 		update_profile_exemption($(this).val(), option);
// 	});
// }
//
// function update_profile_exemption(id, option) {
// 	let formData = {
// 		exemption_id: id,
// 		option: option
// 	}
// 	console.log(formData)
// 	$.ajax({
// 		url: _url.base_url + 'Exemptions/update_profile_exemption',
// 		type: 'POST',
// 		data: formData,
// 		dataType: 'JSON',
// 		beforeSend: function () {
// 			$('.theloading').show()
// 		},
// 		success: function(response) {
// 			$('.theloading').hide();
// 			if (response.status == 200) {
// 				toastr.success(response.msg);
// 			} else {
// 				toastr.error(response.msg);
// 			}
// 		},
// 		error: function(response) {
// 			$('.theloading').hide();
// 			toastr.error('Cập nhật thất bại. Liên hệ IT để được hỗ trợ!');
// 		}
// 	})
// }

function create_profile_exemption(thiz) {
	$('#select_all_exemption').prop('checked', false);
	if (confirm("Xác nhận tạo Hồ sơ miễn giảm!")) {
		let profile = [];
		$('#table_exemption input:checked').each(function () {
			profile.push($(this).val());
		});

		$.ajax({
			url: _url.base_url + 'Exemptions/create_profile_exemption',
			type: 'POST',
			dataType: 'JSON',
			data: {
				profile: profile
			},
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				console.log(response)
				if (response.status == 200) {
					toastr.success(response.msg);
					if (response.redirect == 1) {
						setTimeout(function () {
							window.location.href = _url.base_url + 'Exemptions/profile_exemption?tab=profile_exception';
						}, 2000);
					} else if (response.redirect == 2) {
						setTimeout(function () {
							window.location.href = _url.base_url + 'Exemptions/profile_exemption?tab=profile_asset';
						}, 2000);
					} else {
						setTimeout(function () {
							window.location.href = _url.base_url + 'Exemptions/profile_exemption?tab=profile_normal';
						}, 2000);
					}
				} else {
					toastr.error(response.msg);
				}
			},
			error: function (response) {
				$('.theloading').hide();
				toastr.error('Cập nhật thất bại. Liên hệ IT để được hỗ trợ !');
			}
		})
	}
}

$('#submit_profile').click(function (event) {
	event.preventDefault();
	let code_ref = $('#code_ref').val();
	let type_send = $('#type_send').val();
	let type_exception = $('#type_exception').val();
	let postal_code = $("input[name='postal_code']").val();
	let img_file = {};
	let count = $("img[name='img_contract']").length;
	if (count > 0) {
		$("img[name='img_contract']").each(function () {
			let data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			let key = $(this).data('key');
			if (type == 'profile') {
				img_file[key] = data;
			}
		});
	}
	let formData = {
		code_ref: code_ref,
		postal_code: postal_code,
		type_send: type_send,
		img_profile: img_file,
		type_exception: type_exception
	}
	console.log(formData)
	if (confirm('Xác nhận gửi hồ sơ miễn giảm?')) {
		$.ajax({
			url: _url.base_url + 'Exemptions/send_profile',
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					toastr.success(response.msg);
					if (response.redirect == 1) {
						setTimeout(function () {
							window.location.href = _url.base_url + 'Exemptions/profile_exemption?tab=profile_exception';
						}, 2000);
					} else if (response.redirect == 2) {
						setTimeout(function () {
							window.location.href = _url.base_url + 'Exemptions/profile_exemption?tab=profile_asset';
						}, 2000);
					} else {
						setTimeout(function () {
							window.location.href = _url.base_url + 'Exemptions/profile_exemption?tab=profile_normal';
						}, 2000);
					}
				} else {
					toastr.error(response.msg);
				}
			},
			error: function (response) {
				$('.theloading').hide();
			}
		})
	}
});

function choose_all_status(thiz) {
	let status = $('#choose_status_exemp').val();
	$('.select_all_status option').each(function () {
		$('.select_all_status option:selected').removeAttr('selected');
		$('.select_all_status').val(status)
			.find("option[value="+ status +"]").attr('selected', true);
	});
}

function save_status_profile(thiz) {
	let profile_status = $('#profile_status').val();
	let code_ref = $('#profile_code_ref').val();
	$('.select_all_status option:selected').each(function () {
		let status = $(this).val();
		let exemption_id = $(this).data('id');
		save_status_profiles(status, exemption_id, profile_status, code_ref);
	});
}

function save_status_profiles(status, exemption_id, profile_status, code_ref) {
	$.ajax({
		url: _url.base_url + 'Exemptions/save_profile',
		type: 'post',
		data: {
			status: status,
			exemption_id: exemption_id,
			profile_status: profile_status,
			code_ref: code_ref
		},
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			if (response.status == 200) {
				toastr.success(response.msg);
			} else {
				toastr.error(response.msg);
			}
		},
		error: function (response) {
			$('.theloading').hide();
			toastr.error('Quá trình lưu dữ liệu xảy ra lỗi! Vui lòng liên hệ IT!');
		}
	});
}

//Đồng bộ trạng thái HSMG cha với các ĐMG con
function sync_profile_exemption(thiz) {
	let code_ref = $('#profile_code_ref').val();
	$.ajax({
		url:_url.base_url + 'Exemptions/sync_profile',
		type: 'post',
		data: {code_ref: code_ref},
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			if (response.status == 200) {
				toastr.success(response.msg);
				setTimeout(function () {
					window.location.reload();
				}, 2000)
			} else {
				toastr.error(response.msg);
			}
		},
		error: function (response) {
			$('.theloading').hide();
		}
	});
}

function close_profile(thiz) {
	let code_ref = $(thiz).data('coderef');
	$.ajax({
		url:_url.base_url + 'Exemptions/close_profile',
		type: 'post',
		data: {code_ref: code_ref},
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			if (response.status == 200) {
				toastr.success(response.msg);
			} else {
				toastr.error(response.msg);
			}
		},
		error: function (response) {
			$('.theloading').hide();
		}
	});
}

//Tra ve ho so mien giam
$('#return_profile').click(function (event) {
	event.preventDefault();
	$('#check_all_exem').prop('checked', false);

	if (confirm('Xác nhận trả lại hồ sơ miễn giảm!')) {
		let profile = [];
		let status = 5;
		let type_profile = 'TRA';
		let profile_note = $('#profile_notes').val();
		let profile_old_id = $('#profile_old_id').val();
		let store_id = $('#store_id_return').val();
		$('#table_detail_exemption input:checked').each(function () {
			profile.push($(this).val());
		});
		let formData = {
			profile: profile,
			status: status,
			type_profile: type_profile,
			profile_note: profile_note,
			profile_old_id: profile_old_id,
			store_id: store_id
		}
		$.ajax({
			url: _url.base_url + 'Exemptions/create_profile_exemption',
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response. status == 200) {
					toastr.success(response.msg);
				} else {
					toastr.error(response.msg);
				}
			},
			error: function (response) {
				$('.theloading').hide();
				toastr.error('Quá trình cập nhật xảy ra lỗi! Vui lòng liên hệ IT.');
			}
		})

	}
});

$('#complete_profile').click(function () {
	$('#check_all_exem').prop('checked', false);
	let profile_note = $('#profile_notes').val();
	let profile_old_id = $('#profile_old_id').val();
	let status = 4;
	let profile = [];
	$('#table_detail_exemption input:checked').each(function () {
		profile.push($(this).val());
	});
	let formData = {
		status: status,
		profile: profile,
		profile_old_id: profile_old_id,
		profile_note: profile_note
	}
	if (confirm("Xác nhận hoàn tất lưu hồ sơ miễn giảm!")) {
		$.ajax({
			url: _url.base_url + 'Exemptions/complete_profile',
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					toastr.success(response.msg);
				} else {
					toastr.error(response.msg);
				}
			},
			error: function (response) {
				$('.theloading').hide();
				toastr.error('Quá trình cập nhật xảy ra lỗi! Vui lòng liên hệ IT!');
			}
		})
	}

});

function change_exemption_status(thiz) {
	let exemption_id = $(thiz).data('id');
	let exemption_status = $(thiz).val();
	let profile_status = $('#profile_status').val();
	let profile_code_ref = $('#profile_code_ref').val();
	let formData = {
		exemption_id: exemption_id,
		exemption_status: exemption_status,
		profile_status: profile_status,
		profile_code_ref: profile_code_ref
	}
	if (confirm('Xác nhận đổi trạng thái?')) {
		$.ajax({
			url: _url.base_url + 'Exemptions/update_exemption_spa',
			type: 'post',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					toastr.success(response.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
				}
			},
			error: function(response) {
				$('.theloading').hide();
				toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
			}

		});
	}

}

function change_one_email_confirm(thiz) {
	let exemption_id = $(thiz).data('id');
	let confirm_email = $(thiz).val();
	let type_change = 1; //1: change infor confirm_email, 2: change infor is_exemption_paper
	let formData = {
		exemption_id: exemption_id,
		confirm_email: confirm_email,
		type_change: type_change
	}
	if (confirm('Xác nhận đổi trạng thái?')) {
		$.ajax({
			url: _url.base_url + 'Exemptions/change_email_confirm',
			type: 'post',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					toastr.success(response.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
				}
			},
			error: function(response) {
				$('.theloading').hide();
				toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
			}
		});
	}
}

function change_one_exemption_paper(thiz) {
	let exemption_id = $(thiz).data('id');
	let is_exemption_paper = $(thiz).val();
	let type_change = 2; //1: change infor confirm_email, 2: change infor is_exemption_paper
	let formData = {
		exemption_id: exemption_id,
		is_exemption_paper: is_exemption_paper,
		type_change: type_change
	}
	if (confirm('Xác nhận đổi trạng thái?')) {
		$.ajax({
			url: _url.base_url + 'Exemptions/change_email_confirm',
			type: 'post',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					toastr.success(response.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
				}
			},
			error: function(response) {
				$('.theloading').hide();
				toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
			}
		});
	}
}

function change_one_bbbgx(thiz) {
	let exemption_id = $(thiz).data('id');
	let bbbgx = $(thiz).val();
	let type_change = 3; //1: change infor confirm_email, 2: change infor is_exemption_paper, 3: change infor bbbgx
	let formData = {
		exemption_id: exemption_id,
		bbbgx: bbbgx,
		type_change: type_change
	}
	if (confirm('Xác nhận đổi trạng thái?')) {
		$.ajax({
			url: _url.base_url + 'Exemptions/change_email_confirm',
			type: 'post',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					toastr.success(response.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
				}
			},
			error: function(response) {
				$('.theloading').hide();
				toastr.error('Quá trình cập nhập xảy ra lỗi, vui lòng liên hệ IT!');
			}
		});
	}
}

function choose_all_email(thiz) {
	let choose_option_email = $('#choose_option_email').val();
	console.log(choose_option_email)
	if (choose_option_email != 0) {
		let confirm_email = 1;
		if (choose_option_email == 1) {
			confirm_email = 1;
			confirm_email_text = "Có";
		} else if (choose_option_email == 2) {
			confirm_email = 2;
			confirm_email_text = "Không có";
		}
		$('.choose_email_confirm option').each(function () {
			$('.choose_email_confirm option:selected').removeAttr('selected');
			$(".choose_email_confirm").val(confirm_email)
				.find("option[value="+ confirm_email +"]").attr('selected', true)
		});
	}
}

function save_is_email(thiz) {
	let choose_option_email = $('#choose_option_email').val();
	if (choose_option_email != undefined) {
		$('.choose_email_confirm option:selected').each(function () {
			let exemption_id = $(this).data('id');
			let confirm_email = $(this).val();
			let type_change = 1;
			save_all_email(confirm_email, exemption_id, type_change);
		});
	}
}

function save_all_email(confirm_email, exemption_id, type_change) {
	let formData = {
			confirm_email: confirm_email,
			type_change: type_change,
			exemption_id: exemption_id
	};
	console.log(formData);
	$.ajax({
		url: _url.base_url + 'Exemptions/change_email_confirm',
		type: 'post',
		data: formData,
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			if (response.status == 200) {
				toastr.success(response.msg);
			} else {
				toastr.error(response.msg);
			}
		},
		error: function (response) {
			$('.theloading').hide();
			toastr.error('Quá trình lưu dữ liệu xảy ra lỗi! Vui lòng liên hệ IT!');
		}
	});
}

function choose_all_paper(thiz) {
	let choose_option_paper = $('#choose_option_paper').val();
	if (choose_option_paper != 0) {
		let is_paper = 1;
		if (choose_option_paper == 1) {
			is_paper = 1;
			is_paper_text = "Có";
		} else if (choose_option_paper == 2) {
			is_paper = 2;
			is_paper_text = "Không có";
		}
		$('.choose_is_paper option').each(function () {
			$('.choose_is_paper option:selected').removeAttr('selected');
			$(".choose_is_paper").val(is_paper)
				.find("option[value=" + is_paper +"]").attr('selected', true);
		});
	}
}

function save_is_paper(thiz) {
	let choose_option_paper = $('#choose_option_paper').val();
	if (choose_option_paper != undefined) {
		$('.choose_is_paper option:selected').each(function () {
			let exemption_id = $(this).attr('data-id');
			let is_exemption_paper = $(this).val();
			let type_change = 2;
			save_all_paper(is_exemption_paper, exemption_id, type_change);
		});
	}
}

function save_all_paper(is_exemption_paper, exemption_id, type_change) {
	let formData = {
			is_exemption_paper: is_exemption_paper,
			type_change: type_change,
			exemption_id: exemption_id
	};
	console.log(formData)
	$.ajax({
		url: _url.base_url + 'Exemptions/change_email_confirm',
		type: 'post',
		data: formData,
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			if (response.status == 200) {
				toastr.success(response.msg);
			} else {
				toastr.error(response.msg);
			}
		},
		error: function (response) {
			$('.theloading').hide();
			toastr.error('Quá trình lưu dữ liệu xảy ra lỗi! Vui lòng liên hệ IT!');
		}
	});
}

function choose_all_bbbgx(thiz) {
	let choose_option_bbbgx = $('#choose_option_bbbgx').val();
	if (choose_option_bbbgx != 0) {
		let bbbgx = 1;
		if (choose_option_bbbgx == 1) {
			bbbgx = 1;
		} else if (choose_option_bbbgx == 2) {
			bbbgx = 2;
		}
		$('.choose_is_bbbgx option').each(function () {
			$('.choose_is_bbbgx option:selected').removeAttr('selected');
			$(".choose_is_bbbgx").val(bbbgx)
				.find("option[value="+ bbbgx +"]").attr('selected', true)
		});
	}
}

function save_is_bbbgx(thiz) {
	let choose_option_bbbgx = $('#choose_option_bbbgx').val();
	if (choose_option_bbbgx != undefined) {
		$('.choose_is_bbbgx option:selected').each(function () {
			let exemption_id = $(this).data('id');
			let bbbgx = $(this).val();
			let type_change = 3;
			save_all_bbbgx(bbbgx, exemption_id, type_change);
		});
	}
}

function save_all_bbbgx(bbbgx, exemption_id, type_change) {
	let formData = {
		bbbgx: bbbgx,
		type_change: type_change,
		exemption_id: exemption_id
	};
	console.log(formData);
	$.ajax({
		url: _url.base_url + 'Exemptions/change_email_confirm',
		type: 'post',
		data: formData,
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			if (response.status == 200) {
				toastr.success(response.msg);
			} else {
				toastr.error(response.msg);
			}
		},
		error: function (response) {
			$('.theloading').hide();
			toastr.error('Quá trình lưu dữ liệu xảy ra lỗi! Vui lòng liên hệ IT!');
		}
	});
}

function kt_complete_profile(thiz) {
	let code_ref = $(thiz).data('coderef');
	$('#code_ref').val(code_ref);
	$('#complete_profile_exemption').modal('show');
}

$('#complete_profile_exemptions').click(function (event) {
	event.preventDefault();
	let code_ref = $('#code_ref').val();
	let status = $('.status_complete').val();
	let note = $('.complete_note').val();
	let formData = {
		code_ref: code_ref,
		status: status,
		note: note
	}
	console.log(formData);
	if (confirm("Xác nhận hoàn tất hồ sơ miễn giảm?")) {
		$.ajax({
			url: _url.base_url + 'Exemptions/complete_profile_exemptions',
			type: 'post',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				$('#complete_profile_exemption').modal('hide');
				if (response.status == 200) {
					toastr.success(response.msg);
					setTimeout(function() {
						window.location.reload();
					}, 2000)
				} else {
					toastr.error(response.msg);
				}
			},
			error: function (response) {
				$('.theloading').hide();
				toastr.error('Quá trình lưu dữ liệu xảy ra lỗi! Vui lòng liên hệ IT!');
			}
		});
	}
});

function history_exemption(id) {
	$.ajax({
		url: _url.base_url + 'Exemptions/get_log_exemption/' + id,
		type: 'GET',
		dataType: 'JSON',
		success: function (response) {
			console.log(response.html)
			$('#tbody_exemption_log').empty();
			if (response.html != "") {
				$('#tbody_exemption_log').append(response.html);
			} else {
				let html = '';
				html = '<tr style="text-align: center; color: red">' + '<td colspan="10">Chưa có lịch sử xử lý</td>'+'</tr>';
				$('#tbody_exemption_log').append(html);
			}
			$('#exemption_log_modal').modal('show');
		}
	})
}

function history_profile(id_profile) {
	$.ajax({
		url: _url.base_url + 'Exemptions/get_log_profile/' + id_profile,
		type: 'GET',
		dataType: 'JSON',
		success: function (response) {
			console.log(response.html)
			$('#tbody_profile_log').empty();
			if (response.html != "") {
				$('#tbody_profile_log').append(response.html);
			} else {
				let html = '';
				html = '<tr style="text-align: center; color: red">' + '<td colspan="10">Chưa có lịch sử xử lý</td>'+'</tr>';
				$('#tbody_profile_log').append(html);
			}
			$('#profile_log_modal').modal('show');
		}
	})
}

//Gỡ ĐMG khỏi HSMG khi HSMG đang ở trạng thái Chờ
function remove_exemption(thiz) {
	let id_exemption = $(thiz).data('id');
	let code_ref = $(thiz).data('coderef');
	if (confirm('Xác nhận gỡ bỏ đơn miễn giảm?')) {
		$.ajax({
			url: _url.base_url + 'Exemptions/remove_exemption',
			type: 'POST',
			data: {
				id_exemption: id_exemption,
				code_ref: code_ref
			},
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					$(thiz).closest("tr").remove();
					toastr.success(response.msg);
				}
			},
			error: function () {

			}
		})
	}
}

function addmore_exemption(thiz) {
	//Get exemption selected
	let exemptionIds = [];
	let domain_profile = $('#domain_profile').val();
	let type_send = $('#type_send').val();
	let type_exception = $('#type_exception').val();
	if ($('#table_detail_exemption tbody').find("tr").length > 0) {
		$('#table_detail_exemption tbody').find("tr").each(function () {
			let exemptionId = $(this).find('#exemptions_id').val();
			exemptionIds.push(exemptionId);
		});
	}
	//Get exemption from DB except exemption-selected
	$.ajax({
		method: 'POST',
		url: _url.base_url + 'Exemptions/get_exemptions',
		data: {
			exemption_ids: JSON.stringify(exemptionIds),
			domain_profile: domain_profile,
			type_send: type_send,
			type_exception: type_exception
		},
		success: function (response) {
			$('#tbl_add_exemption').DataTable().destroy();
			$('#tbl_add_exemption').DataTable({
				"info": false,
				data: response.data,
				columns: [
					{data: 'id', visible: false},
					{data: 'code_contract'},
					{data: 'code_contract_disbursement'},
					{data: 'customer_name'},
					{data: 'status_profile'},
					{data: 'type_send'},
					/* CHECKBOX */
					{
						mRender: function (data, type, row) {
							return '<input type="checkbox" id="id_exemp_checkbox" class="check_id_exemption" name="check_id_exemption" value="' + row.id + '" >'
						}
					}
				]
			});
		},
		error: function () {

		}
	});
	$('#addmore_exemption').modal('show');
}

function saveModalExemption(thiz) {
	let arrExemptions = [];
	let arrExemptionsIds = [];
	let code_ref = $('#profile_code_ref').val();
	$('#tbl_add_exemption').DataTable().rows().iterator('row', function (context, index) {
		let section = {};
		let id = $(this.row(index).data())[0].id;
		let node = $(this.row(index).node());
		let isChecked = $(node).closest("tr").find("input[type='checkbox']").prop("checked");
		if (isChecked) {
			$(node).closest("tr").find("td").each(function () {
				if ($(this).index() == 0) section['code_contract'] = $(this).html();
				if ($(this).index() == 1) section['code_contract_disbursement'] = $(this).html();
				if ($(this).index() == 2) section['customer_name'] = $(this).html();
				if ($(this).index() == 3) section['status_profile'] = $(this).html();
				if ($(this).index() == 4) section['type_send'] = $(this).html();
			});
			section['id'] = id;
			arrExemptions.push(section);
			arrExemptionsIds.push(id);
		}
	});
	let formData = {
		code_ref: code_ref,
		exemption_ids: arrExemptionsIds,
	}
	if (confirm('Xác nhận thêm đơn miễn giảm?')) {
		$.ajax({
			method: "POST",
			url: _url.base_url + 'Exemptions/addmore_exemption',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				$('#addmore_exemption').modal('hide');
				if (response.status == 200) {
					toastr.success('Thêm đơn thành công!')
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				}
			},
			error: function () {

			}
		})
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








