$('#investor').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	},
	dropdownParent: 'body'
});


$(document).ready(function () {
	$('#note_renewal').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		},
		dropdownParent: 'body'
	});

	$('#result_reminder').select2({
		placeholder: "Chọn",
		allowClear: true,
		dropdownParent: $('#approve_call')
	});

});
$('#province').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	},
	dropdownParent: 'body'
});

function note_thn(thiz) {
	let contract_id = $(thiz).data("id");
	let phone = $(thiz).data("phone");
	$(".contract_id").val(contract_id);
	$("#number").val(phone);
	$("#note_contract_v2").modal("show");
}

function sms_thn(thiz) {
	let contract_id = $(thiz).data("id");
	let money = $(thiz).data("money");
	let date = $(thiz).data("date");
	let mes_add = "";
	let time = $(thiz).data("time");

	
    if(time>=-5 && time<=-1)
    {
    $("#template").val('60b72056a51b0a227bf4526b');
	$("#content_sms").val("TienvaNgay: HD cua QK se den han thanh toan vao ngay "+date+". So tien can thanh toan: "+money+"VND. QK vui long TT dung han tranh phi phat. LH: 19006907");
   }else if(time==0){
   	$("#template").val('60b7202ea51b0a227bf4521c');
	$("#content_sms").val("TienvaNgay: QK da den han thanh toan so tien:"+money+"VND. QK vui long TT truoc "+date+" tranh phi phat. Huong dan TT https://rb.gy/lgbdb3 hoac LH 19006907");
    }
    $("#datelate").val(time);
    $("#date").val(date);
     $(".contract_id_sms").val(contract_id);
	$("#send_sms_debt").modal("show");
}

$(".send_sms_debt_submit").on("click", function () {
	var content_sms = $("#content_sms").val();
	var contract_id_sms = $(".contract_id_sms").val();
	var number_sms = $("#number_sms").val();
	var template = $("#template").val();

	var formData = {
		content: content_sms,
		contract_id: contract_id_sms,
		template: template
	};
	//Call ajax
	$("#send_sms_debt").modal("hide");
	$.ajax({
		url: _url.base_url + "accountant/do_send_sms",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (data.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);

			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				// setTimeout(function(){
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$(".note_contract_v2_submit").on("click", function () {
	var note = $(".contract_v2_note").val();
	var result_reminder = $(".result_reminder").val();
	var payment_date = $(".payment_date").val();
	var amount_payment_appointment = $(".amount_payment_appointment").val();
	var contractId = $(".contract_id").val();
	var formData = {
		note: note,
		payment_date: payment_date,
		amount_payment_appointment: amount_payment_appointment,
		result_reminder: result_reminder,
		contractId: contractId,
	};
	console.log(formData);
	//Call ajax
	$("#note_contract_v2_submit").modal("hide");
	$.ajax({
		url: _url.base_url + "accountant/doNoteReminder",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (data.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				// setTimeout(function(){
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});


function addNoteReminder(id,code_contract) {
	
			$("input[name='date_pay']").val('')
			$("input[name='money_pay']").val('')
			$("textarea[name='note']").val('')
			$('.tittle_code').text('Hợp đồng ' + code_contract)
			$("input[name='id_contract']").val(id)
		}
	
function show_popup_chageBH(id) {
	$.ajax({
		url: _url.base_url + "/debt_manager_app/showContractDebt?id=" + id,
		type: "GET",
		dataType: 'json',
		success: function (data) {
			let code_contract = typeof data.data.code_contract_disbursement == 'undefined' ? data.data.code_contract : data.data.code_contract_disbursement
			$('.tittle_code').empty()
			$("input[name='id_contract']").empty()
			$("input[name='date_pay']").val('')
			$("input[name='money_pay']").val('')
			$("textarea[name='note']").val('')
			$('.tittle_code').text('XÁC NHẬN TRẢ TIỀN BẢO HIỂM KHOẢN VAY ' + code_contract)
			$("input[name='id_contract']").val(id)
		}
	})
}
function show_popup_coppy_contract(id,code_contract) {
	
			$("#message_coppy_contract").html("Bạn có chắc chắn muốn coppy hợp đồng có mã phiếu ghi: "+code_contract+" thành hợp đồng mới ?");
			$("input[name='code_contract_coppy']").val(code_contract)
			$("input[name='id_contract_coppy']").val(id)
		}
$(document).ready(function () {
	$('.not_reminder_btnSave').click(function (event) {
		event.preventDefault();
		var id_contract = $("input[name='id_contract']").val()
		var date_pay = $("input[name='date_pay']").val()
		var money_pay = $("input[name='money_pay']").val()
		var note = $("textarea[name='note']").val()

		var formData = new FormData();
		formData.append('id_contract', id_contract);
		formData.append('date_pay', date_pay);
		formData.append('money_pay', money_pay);
		formData.append('note', note);

		$.ajax({
			url: _url.base_url + 'accountant/not_reminder',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$("#themgiaodienModal").hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				}

			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			}

		})
	});
	
	
	$('.coppy_contract_btnSave').click(function (event) {
		event.preventDefault();
		var code_contract = $("input[name='code_contract_coppy']").val();
		var id_contract = $("input[name='id_contract_coppy']").val()
		

		var formData = new FormData();
		formData.append('code_contract', code_contract);
    	$.ajax({
			url: _url.base_url + 'accountant/coppy_contract',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$("#modal_coppy_contract").hide();
				$(".theloading").show();

			},
			success: function (data) {
				$(".theloading").hide();
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					$( '.company_close' ).attr( 'target','_blank' );
					// $('.company_close').attr("href",_url.base_url + "pawn/search?code_contract="+data.code_contract_new);
					$('.company_close').attr("href",_url.base_url + "pawn/contract");
					$( '.company_close' ).html( 'Success' );

					setTimeout(function () {
						window.location.href = _url.base_url + 'pawn/contract';
					}, 1000);

					
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				}

			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			}

		})
	});

	$('#type_loan').change(function () {
		$('#type_property option').remove()
		var type_loan = $("select[name='type_loan']").val()
		if (type_loan == 'CC' || type_loan == 'DKX') {
			$('#type_property').append($('<option>', {value: 'XM', text: 'Xe máy'}));
			$('#type_property').append($('<option>', {value: 'OTO', text: 'Ô tô'}));
			$('#type_property').append($('<option>', {value: 'NĐ', text: 'Nhà đất'}));
		} else if (type_loan == 'TC') {
			$('#type_property').append($('<option>', {value: 'TC', text: 'Tín chấp'}));
		} else {
			$('#type_property').append($('<option>', {value: '', text: 'Tất cả'}));
		}

	})

})

function showModal_contract(id) {
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var property_infor = result.data.property_infor
			var name_person = result.data.name_person_seize;
			var license_plates = result.data.license_plates;
			var frame_number = result.data.frame_number;
			var engine_number = result.data.engine_number;
			var license_number = result.data.license_number;
			var model = result.data.model;

			var input_name_person = $('input[name="name_person_seize"]').val();
			var input_license_plates = $('input[name="license_plates"]');
			var input_frame_number = $('input[name="frame_number"]');
			var input_engine_number = $('input[name="engine_number"]');
			var input_license_number = $('input[name="license_number"]');
			var input_asset_model = $('input[name="asset_model"]');
			var input_number_km = $('input[name="number_km"]');
			var input_asset_branch = $('input[name="asset_branch"]');

			$('input[name="contract_id_liq"]').val(result.data._id.$oid);
			$('input[name="code_contract"]').val(result.data.code_contract);
			$('input[name="date_seize"]').val(result.data.date_seize);
			$('input[name="name_person_seize"]').val((name_person === undefined) ? input_name_person : name_person);
			$('#asset_name').val(result.data.loan_infor.name_property.text);

			$.each(property_infor, function (k, v) {
				if (v.slug == "bien-so-xe") {
					input_license_plates.val(v.value);
				} else if (license_plates != undefined) {
					input_license_plates.val(license_plates);
				}
				if (v.slug == "so-khung") {
					input_frame_number.val(v.value);
				} else if (frame_number != undefined) {
					input_frame_number.val(frame_number);
				}
				if (v.slug == "so-may") {
					input_engine_number.val(v.value);
				} else if (engine_number != undefined) {
					input_engine_number.val(engine_number);
				}
				if (v.slug == "so-dang-ky") {
					input_license_number.val(v.value);
				} else if (license_number != undefined) {
					input_license_number.val(license_number);
				}
				if (v.slug == "model") {
					input_asset_model.val(v.value);
				} else if (model != undefined) {
					input_asset_model.val(model);
				}
				if (v.slug == "so-km-da-di") {
					input_number_km.val(v.value);
				}
				if (v.slug == "nhan-hieu") {
					input_asset_branch.val(v.value);
				}
			});
			$('#createSeizeModal').modal('show');
		}
	});
}

$('.seize_vehicle_btnSave').click(function (event) {
	event.preventDefault();
	var _id = $("input[name='contract_id_liq']").val();
	var action = 'create';
	var status = 44;
	var parent = $(this).closest('.modal-body');
	var date_seize = $("input[name='date_seize']").val();
	var name_person_seize = $("input[name='name_person_seize']").val();
	var license_plates = $("input[name='license_plates']").val();
	var frame_number = $("input[name='frame_number']").val();
	var engine_number = $("input[name='engine_number']").val();
	var license_number = $("input[name='license_number']").val();
	var asset_name = $("input[name='asset_name']").val();
	var asset_branch = $("input[name='asset_branch']").val();
	var number_km = $("input[name='number_km']").val();
	var asset_model = $("input[name='asset_model']").val();
	var data_send_approve = $("input[name='data_send_approve']").val();
	var note_create_liqui = $("#note_create_liqui").val();
	var count = $("img[name='img_file']").length;
	var image_file = {};

	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type = 'img_liqui') {
				image_file[key] = data;
			}
		});
	}
	if (confirm('Xác nhận khởi tạo thanh lý tài sản đảm bảo ?')) {
		var formData = {
			_id: _id,
			action: action,
			status: status,
			date_seize: date_seize,
			name_person_seize: name_person_seize,
			license_plates: license_plates,
			frame_number: frame_number,
			engine_number: engine_number,
			license_number: license_number,
			asset_name: asset_name,
			asset_branch: asset_branch,
			number_km: number_km,
			asset_model: asset_model,
			data_send_approve: data_send_approve,
			image_file: image_file,
			note: note_create_liqui
		};
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: "POST",
			data: formData,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$("#loading").hide();
				if (data.status == 200) {
					$('.msg_success').text(data.msg);
					$('#createSeizeModal').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		});
	}
});

function tpthn_update_refer(id) {
	$('#debt_root_remain').empty();
	$('#price_suggest_bpdg_display').empty();
	$('#name_valuation_display').empty();
	$('#phone_valuation_display').empty();
	$('#date_effect_bpdg_display').empty();
	$('#note_bpdg_display').empty();
	$('#img_liquidation_thn_create_display').empty();
	$('#img_liquidation_bpdg_display').empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var liq = result.data.liquidation_info;
			var liq_bpdg = result.data.liquidation_info.bpdg;
			var nf = Intl.NumberFormat();
			var debt_remain_root = result.data.original_debt.du_no_goc_con_lai;
			var price_suggest_bpdg = liq_bpdg.price_suggest_bpdg;
			var date_effect_bpdg = new Date(liq_bpdg.date_effect_bpdg).format('d/m/Y');
			var html6 = "";
			var html2 = "";
			var html3 = "";
			var html4 = "";
			var html5 = "";
			html6 += "<p class='text-danger' style='padding-top: 8px'>" + numeral(debt_remain_root).format('0,0') + " VNĐ" + "</p>";
			html2 += "<p style='padding-top: 8px; color: black'>" + numeral(price_suggest_bpdg) .format('0,0') + " VNĐ" + "</p>";
			html3 += "<p style='padding-top: 8px; color: black'>" + liq_bpdg.name_valuation + "</p>";
			html4 += "<p style='padding-top: 8px; color: black'>" + liq_bpdg.phone_valuation + "</p>";
			html5 += "<p style='padding-top: 8px; color: black'>" + date_effect_bpdg + "</p>";
			$('#debt_root_remain').append(html6) ;
			$('#price_suggest_bpdg_display').append(html2);
			$('#name_valuation_display').append(html3);
			$('#phone_valuation_display').append(html4);
			$('#date_effect_bpdg_display').append(html5);
			$('#note_bpdg_display').val(liq_bpdg.note);
			$('.contract_id_liq').val(result.data._id.$oid);
			var html = "";
			var html1 = "";
			if (liq_bpdg.img_liquidation != "") {
				for (var j in liq.img_liquidation) {
					var loc = new URL(liq.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq.img_liquidation[j].file_type == 'image/png' || liq.img_liquidation[j].file_type == 'image/jpg' || liq.img_liquidation[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq.img_liquidation[j].path + "'>" + "</a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'audio/mp3' || liq.img_liquidation[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"' >" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none' name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"'>" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + liq.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}
			if (liq_bpdg.img_liquidation != "") {
				for (var j in liq_bpdg.img_liquidation) {
					var loc = new URL(liq_bpdg.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq_bpdg.img_liquidation[j].file_type == 'image/png' || liq_bpdg.img_liquidation[j].file_type == 'image/jpg' || liq_bpdg.img_liquidation[j].file_type == 'image/jpeg') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a href='" + liq_bpdg.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq_bpdg.img_liquidation[j].key + "' data-fileName='" + liq_bpdg.img_liquidation[j].file_name + "' data-fileType='" + liq_bpdg.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq_bpdg.img_liquidation[j].path + "'>" + "</a>";
						html1 += "</div>"
					}
					if (liq_bpdg.img_liquidation[j].file_type == 'audio/mp3' || liq_bpdg.img_liquidation[j].file_type == 'audio/mpeg') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"' >" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html1 += "</div>"
					}
					if (liq_bpdg.img_liquidation[j].file_type == 'video/mp4') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none' name='img_send_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html1 += "</div>"
					}
					if (liq_bpdg.img_liquidation[j].file_type == 'application/pdf') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a target='_blank' href='" + liq_bpdg.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq_bpdg.img_liquidation[j].key + "' data-fileName='" + liq_bpdg.img_liquidation[j].file_name + "' data-fileType='" + liq_bpdg.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq_bpdg.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html1 += "</div>"
					}
				}
			} else {
				html1 += '<td></td>'
			}
			$("#img_liquidation_thn_create_display").append(html);
			$("#img_liquidation_bpdg_display").append(html1);
			$('#UpdateEvaluation').modal('show');
		}
	});
}

$('#send_ceo_approve').click(function (event) {
	event.preventDefault();

	var _id = $("input[name='_id']").val();
	var parent = $(this).closest('.modal-body');
	// var code_contract = $("input[name='code_contract_suggest']").val();
	var debt_remain_root = $("input[name='debt_remain_root']").val().split(',').join('');
	var suggest_price = $("input[name='suggest_price']").val().split(',').join('');
	var name_buyer = $("input[name='name_buyer']").val();
	var phone_number_buyer = $("input[name='phone_number_buyer']").val();
	var status = $(".status_contract_suggest").val();
	var note_suggest = $(".note_suggest").val();
	debt_remain_root.split('.').join('');
	suggest_price.split('.').join('');
	var count = $("img[name='img_file']").length;
	var image_file = {};

	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'img_file') {
				image_file[key] = data;
			}
		});
	}
	if (confirm('Xác nhận gửi yêu cầu thanh lý tài sản lên CEO ?')) {
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			method: "POST",
			data: {
				_id: _id,
				// code_contract: code_contract,
				debt_remain_root: debt_remain_root,
				suggest_price: suggest_price,
				name_buyer: name_buyer,
				phone_number_buyer: phone_number_buyer,
				status: status,
				image_file: image_file,
				note: note_suggest
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text(data.msg);
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				$(".theloading").hide();

			}
		});
	}
});

$('.approve_liquidation_submit').on("click", function () {
	var note = $(".approve_note").val();
	var status = $(".status_approve").val();
	var id = $(".contract_id").val();

	var formData = {
		note: note,
		status: status,
		id: id,
	};

//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/approveContractLiquidation",
		type: "POST",
		data: formData,
		dataType: "json",
		beforeSend: function () {
			$(".theloading").hide();
		},
		success: function (data) {

		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	});
});

function tpthn_huy_yeu_cau(thiz) {
	$('.title_modal_approve').text("TP THN HỦY YÊU CẦU TẠO THANH LÝ TÀI SẢN");
	$(".approve_note").val();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve_liquidations").modal("show");
}

$('.cancel_approve_liquidation_submit').on("click", function () {
	var note = $(".note").val();
	var _id = $(".contract_id").val();
	var data_send_approve = $("#data_send_approve").val();
	
	if (confirm('Xác nhận hủy yêu cầu tạo thanh lý tài sản ?')) {
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			method: "POST",
			data: {
				_id: _id,
				note: note,
				data_send_approve: data_send_approve
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text(data.msg);
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				}

			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});
	}
});

function ceo_duyet_thanh_ly(id) {

	$("#uploads_img_file_liquidation").empty();
	$("#debt_remain_root_view_ceo").empty();
	$("#suggest_price_view_ceo").empty();

	$("#name_person_seize_view_ceo").empty();
	$("#name_buyer_ceo").empty();
	$("#phone_number_buyer_ceo").empty();
	$("#note_suggest").empty();

	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);
			var suggest_price_info = result.data.suggest_price_info;

			var debt_remain_root = suggest_price_info.debt_remain_root;
			var suggest_price = suggest_price_info.suggest_price;
			var name_person_seize = result.data.liquidation_info.name_person_seize;
			var name_buyer = suggest_price_info.name_buyer;
			var phone_number_buyer = suggest_price_info.phone_number_buyer;
			var note_suggest = result.data.note;

			var html1 = "";
			var html2 = "";
			var html3 = "";
			var html4 = "";
			var html5 = "";
			var html6 = "";
			html1 += "<p class='text-danger' style='padding-top: 8px'>" + numeral(debt_remain_root).format('0,0') + " VNĐ" + "</p>";
			html2 += "<p style='padding-top: 8px; color: black'>" + numeral(suggest_price).format('0,0') + " VNĐ" + "</p>";
			html3 += "<p style='padding-top: 8px; color: black'>" + name_person_seize + "</p>";
			html4 += "<p style='padding-top: 8px; color: black'>" + name_buyer + "</p>";
			html5 += "<p style='padding-top: 8px; color: black'>" + phone_number_buyer + "</p>";
			html6 += "<textarea style='padding-top: 8px; color: black' class='col-md-12 col-xs-12 form-control' rows='3' disabled>" + note_suggest + "</textarea>";
			$("#debt_remain_root_view_ceo").append(html1);
			$("#suggest_price_view_ceo").append(html2);
			$("#name_person_seize_view_ceo").append(html3);
			$("#name_buyer_ceo").append(html4);
			$("#phone_number_buyer_ceo").append(html5);
			$("#note_suggest").append(html6);
			$('input[name="id_contract_ceo_approve"]').val(result.data._id.$oid);
			$("input[name='note_ceo']").val();

			var html = "";
			if (suggest_price_info.image_liquidation_file != "") {
				for (var j in suggest_price_info.image_liquidation_file) {
					var loc = new URL(suggest_price_info.image_liquidation_file[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');

					if (suggest_price_info.image_liquidation_file[j].file_type == 'image/png' || suggest_price_info.image_liquidation_file[j].file_type == 'image/jpg' || suggest_price_info.image_liquidation_file[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + suggest_price_info.image_liquidation_file[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + suggest_price_info.image_liquidation_file[j].key + "' data-fileName='" + suggest_price_info.image_liquidation_file[j].file_name + "' data-fileType='" + suggest_price_info.image_liquidation_file[j].file_type + "' data-type='send_file' class='w-100' src='" + suggest_price_info.image_liquidation_file[j].path + "'></a>";
						html += "</div>"
					}
					if (suggest_price_info.image_liquidation_file[j].file_type == 'audio/mp3' || suggest_price_info.image_liquidation_file[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + suggest_price_info.image_liquidation_file[j].path + "' target='_blank'><span style='z-index: 9'>"+ suggest_price_info.image_liquidation_file[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ suggest_price_info.image_liquidation_file[j].key +"' data-fileName='"+ suggest_price_info.image_liquidation_file[j].file_name +"' data-fileType='"+ suggest_price_info.image_liquidation_file[j].file_type +"'  data-type='send_file' class='w-100' src='"+ suggest_price_info.image_liquidation_file[j].path +"' ></a>";
						html += "</div>"
					}
					if (suggest_price_info.image_liquidation_file[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + suggest_price_info.image_liquidation_file[j].path + "' target='_blank'><span style='z-index: 9'>"+ suggest_price_info.image_liquidation_file[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none' name='img_send_file' data-key='"+ suggest_price_info.image_liquidation_file[j].key +"' data-fileName='"+ suggest_price_info.image_liquidation_file[j].file_name +"' data-fileType='"+ suggest_price_info.image_liquidation_file[j].file_type +"'  data-type='send_file' class='w-100'></a>";
						html += "</div>"
					}
					if (suggest_price_info.image_liquidation_file[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + suggest_price_info.image_liquidation_file[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + suggest_price_info.image_liquidation_file[j].key + "' data-fileName='" + suggest_price_info.image_liquidation_file[j].file_name + "' data-fileType='" + suggest_price_info.image_liquidation_file[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + suggest_price_info.image_liquidation_file[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'></a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}

			$("#uploads_img_file_liquidation").append(html);
			$("#CEOApproveSuggestModal").modal("show");
		}
	});
}

$("#ceo_confirm").on("click", function () {
	var _id = $(".id_contract_ceo_approve").val();
	var status = $("input[name='confirm_liquidation']:checked").val();
	var note = $(".note_ceo").val();
	var data_send_approve = $(".data_send_approve").val();
	if (confirm('Bạn có chắc chắn xác nhận ?')) {
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			method: "POST",
			data: {
				_id: _id,
				status: status,
				note: note,
				data_send_approve: data_send_approve
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text(data.msg);
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				}

			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});
	}
});

function tpthn_xac_nhan_thanh_ly(thiz) {
	$('.title_modal_approve').text("TP THN XÁC NHẬN THANH LÝ TÀI SẢN");
	$(".status_confirm_contract").val();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#confirm_liquidations").modal("show");
}

$(".confirm_liquidations_submit").click(function () {
	var _id = $(".contract_id").val();
	var note = $(".note_confirm").val();
	var status = $(".status_confirm_contract").val();

	if (confirm('Bạn có chắc chắn muốn thanh lý tài sản này ?')) {
		$.ajax({
			url: _url.base_url + "accountant/approve_liquidations",
			method: "POST",
			data: {
				_id: _id,
				status: status,
				note: note
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text(data.msg);
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				}

			},
			error: function () {
				console.log(data)
				$(".theloading").hide();
			},
		});
	}
});

$('#phone_number_buyer').keyup(function (event) {
	// skip for arrow keys
	if (event.which >= 37 && event.which <= 40) return;
	// format number
	$(this).val(function (index, value) {
		return value
			.replace(/\D/g, "");
	});
});

$('#license_number').keyup(function (event) {
	// skip for arrow keys
	if (event.which >= 37 && event.which <= 40) return;
	// format number
	$(this).val(function (index, value) {
		return value
			.replace(/\D/g, "");
	});
});


$('#suggest_price').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#suggest_price_again').on('input', function (e) {
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


function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	if (confirm("Bạn có chắc chắn muốn xóa ảnh này ?")){
		$(thiz_).closest("div .block").remove();
		toastr.success("Xóa ảnh thành công!", {
			timeOut: 2000,
		});
	}
}
function show_popup_print_contract_loan(thiz) {
	$(".title_modal_approve_printed").text("In thông báo");

	let contract_id = $(thiz).data("id");

	$(".contract_id").val(contract_id);
	$(".printed_thong_bao").attr("href", _url.base_url + '/contract/printed_thong_bao?id=' + contract_id);
	$(".printed_thu_xac_nhan").attr("href", _url.base_url + '/contract/printed_thu_xac_nhan?id=' + contract_id);
	$(".printed_quyet_dinh").attr("href", _url.base_url + '/contract/printed_quyet_dinh?id=' + contract_id);
	$(".printed_thong_bao_no").attr("href", _url.base_url + '/contract/printed_thong_bao_no?id=' + contract_id);
	
	$('#print_contract').modal('show');
}

function show_modal_exemption(id) {
	$("#contract_append").empty();

	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);
			var html_code_contract = "";

			html_code_contract += "<p style='color: black'>" + result.data.code_contract_disbursement + "</p>";
			$("input[name='code_contract_append']").val(result.data.code_contract);
			$("input[name='contract_id_append']").val(result.data._id.$oid);
			$("input[name='store_id']").val(result.data.store.id);
			$("input[name='store_name']").val(result.data.store.name);
			$("input[name='store_address']").val(result.data.store.address);
			$("#contract_append").append(html_code_contract);

		},
		error: function (result) {
			console.log(result);
		}
	});
	$("#create_exemption_contract").modal('show');
}

$("#send_exemptions").click(function (event) {
	event.preventDefault();
	var amount_customer_suggest = $("input[name='amount_customer_suggest']").val().split(',').join('');
	var date_suggest = $("input[name='date_suggest']").val();
	var date_customer_sign = $("input[name='date_customer_sign']").val();
	var type_payment_exem = $("input[name='type_payment_exem']:checked").val();
	var note_suggest = $(".note_suggest_exemptions").val();
	var status_exemptions = $(".status_exemptions").val();
	var id_contract = $("#contract_id_append").val();
	var code_contract = $("input[name='code_contract_append']").val();
	var confirm_email = $("input[name='confirm_email']:checked").val();
	var is_exemption_paper = $("input[name='is_exemption_paper']:checked").val();
	var number_date_late = $("input[name='number_date_late']").val();
		amount_customer_suggest.split('.').join('');
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
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
	if (confirm("Xác nhận gửi đơn miễn giảm ?")) {
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
				note: note_suggest,
				status: status_exemptions,
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
					$('.msg_success').text("Tạo đơn miễn giảm thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "exemptions";
					}, 3000);
				} else {
					$(".theloading").hide();
					toastr.error(data.msg);
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	}

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
$('#amount_tp_thn_suggest').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

function tpthn_gui_lai_ceo(id) {
	$('#uploads_img_file_send_again').empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractPaymentInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);
			var nf = Intl.NumberFormat();
			var img_again = result.data1.suggest_price_info.image_liquidation_file;

			$('input[name="debt_remain_root_again"]').val(nf.format(Math.floor(result.data1.debt.tong_tien_goc_con))) ;
			$('input[name="contract_id_liquidation"]').val(id);
			$('input[name="code_contract_suggest_again"]').val(result.data1.code_contract);
			$('input[name="suggest_price_again"]').val(nf.format(Math.floor(result.data1.suggest_price_info.suggest_price)));
			$('input[name="name_buyer_again"]').val(result.data1.suggest_price_info.name_buyer);
			$('input[name="phone_number_buyer_again"]').val(result.data1.suggest_price_info.phone_number_buyer);
			$('textarea[name="note_suggest_again"]').val(result.data1.note);

			var html = "";
			if (img_again != "") {
				for (var j in img_again) {
					var loc = new URL(img_again[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');

					if (img_again[j].file_type == 'image/png' || img_again[j].file_type == 'image/jpg' || img_again[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + img_again[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='liquidation_asset' data-max-width='992' data-type='image' data-title='Ảnh tài sản thanh lý'><img name='img_file' data-key='" + img_again[j].key + "' data-fileName='" + img_again[j].file_name + "' data-fileType='" + img_again[j].file_type + "' data-type='image' class='w-100' src='" + img_again[j].path + "'></a>";
						html += "<button type='button' onclick='deleteImage(this)' data-id='"+ id +"' data-type='image' data-key='" + img_again[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
						html += "</div>"
					}
					if (img_again[j].file_type == 'audio/mp3' || img_again[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + img_again[j].path + "' target='_blank'><span style='z-index: 9'>"+ img_again[j].file_name +"</span><img style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_file' data-key='"+ img_again[j].key +"' data-fileName='"+ img_again[j].file_name +"' data-fileType='"+ img_again[j].file_type +"'  data-type='image' class='w-100' src='"+ img_again[j].path +"' ></a>";
						html += "</div>"
					}
					if (img_again[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + img_again[j].path + "' target='_blank'><span style='z-index: 9'>"+ img_again[j].file_name +"</span><img style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img name='img_file' data-key='"+ img_again[j].key +"' data-fileName='"+ img_again[j].file_name +"' data-fileType='"+ img_again[j].file_type +"'  data-type='image' class='w-100' src='" + img_again[j].path + "' ></a>";
						html += "</div>"
					}
					if (img_again[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + img_again[j].path + "'  data-max-width='992' data-type='image'><img name='img_file'  data-key='" + img_again[j].key + "' data-fileName='" + img_again[j].file_name + "' data-fileType='" + img_again[j].file_type + "' data-type='image' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + img_again[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'></a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}

			$("#uploads_img_file_send_again").append(html);
			$('#SendCeoAgain').modal('show');
		}
	});
}

$('#send_ceo_again').click(function (event) {
	event.preventDefault();

	var _id = $("input[name='contract_id_liquidation']").val();
	var parent = $(this).closest('.modal-body');
	// var code_contract = $("input[name='code_contract_suggest']").val();
	var debt_remain_root = $("input[name='debt_remain_root_again']").val().split(',').join('');
	var suggest_price = $("input[name='suggest_price_again']").val().split(',').join('');
	var name_buyer = $("input[name='name_buyer_again']").val();
	var phone_number_buyer = $("input[name='phone_number_buyer_again']").val();
	var status = $(".status_contract_suggest_again").val();
	var note_suggest = $(".note_suggest_again").val();
		debt_remain_root.split('.').join('');
		suggest_price.split('.').join('');
	var count = $("img[name='img_file']").length;
	var image_file = {};

	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			console.log(type);
			if (type == 'image') {
				image_file[key] = data;
			}
		});
	}
	console.log(image_file);
	if (confirm('Xác nhận gửi duyệt lại thanh lý tài sản ?')) {
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			method: "POST",
			data: {
				_id: _id,
				// code_contract: code_contract,
				debt_remain_root: debt_remain_root,
				suggest_price: suggest_price,
				name_buyer: name_buyer,
				phone_number_buyer: phone_number_buyer,
				status: status,
				image_file: image_file,
				note: note_suggest
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text(data.msg);
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "accountant/contract_v2";
					}, 2000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});
	}
});

function bp_dinh_gia_xu_ly(id) {
	$("#debt_remain_root_bpdg").empty();
	$("#date_seize_bpdg").empty();
	$("#name_person_seize_bpdg").empty();
	$("#frame_number_bpdg").empty();
	$("#engine_number_bpdg").empty();
	$("#license_plates_bpdg").empty();
	$("#license_number_bpdg").empty();
	$("#asset_name_bpdg").empty();
	$("#asset_branch_bpdg").empty();
	$("#asset_model_bpdg").empty();
	$("#number_km_bpdg").empty();
	$("#note_create_liq").empty();
	$("#img_create_liquidation").empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var liq = result.data.liquidation_info;
			var debt_remain_root = result.data.original_debt.du_no_goc_con_lai;
			var date_seize_bpdg = new Date(liq.date_seize).format('d/m/Y');
			var name_person_seize_bpdg = liq.name_person_seize;
			var frame_number_bpdg = liq.frame_number;
			var engine_number_bpdg = liq.engine_number;
			var license_plates_bpdg = liq.license_plates;
			var license_number_bpdg = liq.license_number;
			var asset_name_bpdg = liq.asset_name;
			var asset_branch_bpdg = liq.asset_branch;
			var asset_model_bpdg = liq.asset_model;
			var number_km_bpdg = liq.number_km;
			var note_create_liq = liq.note_create_liquidation;
			var html1 = "";
			var html2 = "";
			var html3 = "";
			var html4 = "";
			var html5 = "";
			var html6 = "";
			var html7 = "";
			var html8 = "";
			var html9 = "";
			var html10 = "";
			var html11 = "";
			var html12 = "";
			html1 += "<p class='text-danger' style='padding-top: 8px'>" + numeral(debt_remain_root).format('0,0') + " VNĐ" + "</p>";
			html2 += "<p style='padding-top: 8px; color: black'>" + date_seize_bpdg + "</p>";
			html3 += "<p style='padding-top: 8px; color: black'>" + name_person_seize_bpdg + "</p>";
			html4 += "<p style='padding-top: 8px; color: black'>" + frame_number_bpdg + "</p>";
			html5 += "<p style='padding-top: 8px; color: black'>" + engine_number_bpdg + "</p>";
			html6 += "<p style='padding-top: 8px; color: black'>" + license_plates_bpdg + "</p>";
			html7 += "<p style='padding-top: 8px; color: black'>" + license_number_bpdg + "</p>";
			html8 += "<p style='padding-top: 8px; color: black'>" + asset_name_bpdg + "</p>";
			html9 += "<p style='padding-top: 8px; color: black'>" + asset_branch_bpdg + "</p>";
			html10 += "<p style='padding-top: 8px; color: black'>" + asset_model_bpdg + "</p>";
			html11 += "<p style='padding-top: 8px; color: black'>" + number_km_bpdg + "</p>";
			html12 += "<textarea style='padding-top: 8px; color: black' class='col-md-12 col-xs-12 form-control' rows='3' disabled>" + note_create_liq + "</textarea>";
			$("#debt_remain_root_bpdg").append(html1);
			$("#date_seize_bpdg").append(html2);
			$("#name_person_seize_bpdg").append(html3);
			$("#frame_number_bpdg").append(html4);
			$("#engine_number_bpdg").append(html5);
			$("#license_plates_bpdg").append(html6);
			$("#license_number_bpdg").append(html7);
			$("#asset_name_bpdg").append(html8);
			$("#asset_branch_bpdg").append(html9);
			$("#asset_model_bpdg").append(html10);
			$("#number_km_bpdg").append(html11);
			$("#note_create_liq").append(html12);
			$('input[name="contract_id_liq"]').val(result.data._id.$oid);
			$("input[name='note_bpdg']").val();
			var html = "";
			if (liq.img_liquidation != "") {
				for (var j in liq.img_liquidation) {
					var loc = new URL(liq.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					console.log()
					if (liq.img_liquidation[j].file_type == 'image/png' || liq.img_liquidation[j].file_type == 'image/jpg' || liq.img_liquidation[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq.img_liquidation[j].path + "'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'audio/mp3' || liq.img_liquidation[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"' ></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none' name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + liq.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}
			$("#img_create_liquidation").append(html);
			$("#bpdg_processing_modal").modal("show");
		}
	});
}

$('.return_create_liq').click(function (event) {
	event.preventDefault();
	var contract_id = $("input[name='contract_id_liq']").val();
	var status_return = 45;
	var note_bpdg = $("#note_bpdg").val();
	var action = 'return';
	if(confirm("Xác nhận trả lại bộ phận quản lý hợp đồng vay ?")) {
		var formData = {
			_id: contract_id,
			action: action,
			status: status_return,
			note: note_bpdg,
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: 'POST',
			data: formData,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$("#bpdg_processing_modal").modal("hide");
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		})
	}
});

// Show lại thông tin gửi lại định giá tài sản thanh lý
function thn_tao_lai_thanh_ly(id) {
	$('#img_liquidation_update').empty();
	$('#note_create_liqui_update').empty();
	$('#date_seize_update').empty();
	$('#name_person_seize_update').empty();
	$('#license_plates_update').empty();
	$('#frame_number_update').empty();
	$('#engine_number_update').empty();
	$('#license_number_update').empty();
	$('#asset_name_update').empty();
	$('#asset_branch_update').empty();
	$('#asset_model_update').empty();
	$('#number_km_update').empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: 'GET',
		dateType: 'JSON',
		success: function (result) {
			var liq = result.data.liquidation_info;
			$('#date_seize_update').val(liq.date_seize);
			$('#name_person_seize_update').val(liq.name_person_seize);
			$('#license_plates_update').val(liq.license_plates);
			$('#frame_number_update').val(liq.frame_number);
			$('#engine_number_update').val(liq.engine_number);
			$('#license_number_update').val(liq.license_number);
			$('#asset_name_update').val(liq.asset_name);
			$('#asset_branch_update').val(liq.asset_branch);
			$('#asset_model_update').val(liq.asset_model);
			$('#number_km_update').val(liq.number_km);
			$('#note_create_liqui_update').val(liq.note_create_liquidation);
			$('.contract_id_liq').val(result.data._id.$oid);
			var html = "";
			if (liq.img_liquidation != "") {
				for (var j in liq.img_liquidation) {
					var loc = new URL(liq.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s')
					if (liq.img_liquidation[j].file_type == "image/png" || liq.img_liquidation[j].file_type == "image/jpg" || liq.img_liquidation[j].file_type == "image/jpeg") {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-src='" + liq.img_liquidation[j].path + "' data-group='thegallery' data-gallery='img_liquidation' data-max-width='992' data-type='img_liqui'><img data-type='img_liqui' data-filetype='" + liq.img_liquidation[j].file_type + "' data-filename='" + liq.img_liquidation[j].file_name + "' name='img_file' data-key='" + liq.img_liquidation[j].key + "' src='" + liq.img_liquidation[j].path + "'>" + "</a>";
						html +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html +=	"</div>";
					} else if (liq.img_liquidation[j].file_type == "audio/mp3" || liq.img_liquidation[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='img_liqui' class='w-100' src='"+ liq.img_liquidation[j].path +"' >" + liq.img_liquidation[j].file_name + "</a>";
						html +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html += "</div>"
					} else if (liq.img_liquidation[j].file_type == "video/mp4") {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none' name='img_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='img_liqui' class='w-100' src='"+ liq.img_liquidation[j].path +"'>" + liq.img_liquidation[j].file_name + "</a>";
						html +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html += "</div>"
					} else if (liq.img_liquidation[j].file_type == "application/pdf") {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + liq.img_liquidation[j].path + "' data-max-width='992' data-type='img_liqui'><img name='img_file' data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='img_liqui' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq.img_liquidation[j].file_name + "</a>";
						html +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html += "</div>"
					}
				}
			}
			$('#img_liquidation_update').append(html);
		},
		error: function (result) {

		}
	});
	$('#resendEvalution').modal('show');
}

// THN gửi lại yêu cầu định giá tài sản thanh lý
$('#resend_dgts').click(function (event) {
	event.preventDefault();
	var contract_id = $('.contract_id_liq').val();
	var action = 'resend';
	var status = 44;
	var date_seize_update = $('#date_seize_update').val();
	var name_person_seize_update = $('#name_person_seize_update').val();
	var license_plates_update = $('#license_plates_update').val();
	var frame_number_update = $('#frame_number_update').val();
	var engine_number_update = $('#engine_number_update').val();
	var license_number_update = $('#license_number_update').val();
	var asset_name_update = $('#asset_name_update').val();
	var asset_branch_update = $('#asset_branch_update').val();
	var asset_model_update = $('#asset_model_update').val();
	var number_km_update = $('#number_km_update').val();
	var note_create_liqui_update = $('#note_create_liqui_update').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'img_liqui') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận gửi lại yêu cầu định giá tài sản thanh lý ?")) {
		var formData = {
			_id: contract_id,
			action: action,
			status: status,
			date_seize: date_seize_update,
			name_person_seize: name_person_seize_update,
			license_plates: license_plates_update,
			frame_number: frame_number_update,
			engine_number: engine_number_update,
			license_number: license_number_update,
			asset_name: asset_name_update,
			asset_branch: asset_branch_update,
			asset_model: asset_model_update,
			number_km: number_km_update,
			note: note_create_liqui_update,
			image_file: image_file,
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: 'POST',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$("#resendEvalution").modal("hide");
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		})
	}

});

//BP Định giá duyệt định giá tài sản
$('#bpdg_approve').click(function (event) {
	event.preventDefault();
	var id_contract = $('.contract_id_liq').val();
	var action = 'approve';
	var status = 46;
	var name_valuation = $('#name_valuation').val();
	var phone_valuation = $('#phone_valuation').val();
	var price_suggest_bpdg = $('#price_suggest_bpdg').val();
	var date_effect_bpdg = $('#date_effect_bpdg').val();
	var note_bpdg = $('#note_bpdg').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'img_liqui') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận gửi thông tin định giá tài sản thanh lý ?")) {
		var formData = {
			_id: id_contract,
			action: action,
			status: status,
			name_valuation: name_valuation,
			phone_valuation: phone_valuation,
			price_suggest_bpdg: price_suggest_bpdg,
			date_effect_bpdg: date_effect_bpdg,
			image_file: image_file,
			note: note_bpdg
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$('.theloading').hide();
					$('#bpdg_processing_modal').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$('.theloading').hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$('.theloading').hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		})
	}
});

//TP THN cập nhật giá tham khảo (tài sản thanh lý)
$('#tpthn_update').click(function (event) {
	event.preventDefault();
	var contract_id = $('.contract_id_liq').val();
	var status = 47;
	var action = 'update_price';
	var price_suggest_thn = $('#price_suggest_thn').val();
	var note_thn_update = $('#note_thn_update').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			type = $(this).data('type');
			var data = {};
			data['file_type'] = $(this).attr("data-fileType");
			data['file_name'] = $(this).attr("data-fileName");
			data['path'] = $(this).attr("src");
			data['key'] = $(this).attr("data-key");
			var key = $(this).data("key");
			if (type == 'img_file') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận cập nhật định giá ?")) {
		var formData = {
			_id: contract_id,
			action: action,
			status: status,
			price_suggest_thn: price_suggest_thn,
			note: note_thn_update,
			image_file: image_file,
		};
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: 'POST',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('#UpdateEvaluation').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					})
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				})
			}
		})
	}


});

//TP THN duyệt thay CEO (tài sản thanh lý) (Show thông tin)
function tpthn_approve_rep(id) {
	$('#debt_root_remain_approve').empty();
	$('#price_suggest_bpdg_display_approve').empty();
	$('#name_valuation_display_approve').empty();
	$('#phone_valuation_display_approve').empty();
	$('#note_bpdg_display_approve').empty();
	$('#img_liquidation_thn_create_display_approve').empty();
	$('#img_liquidation_bpdg_display_approve').empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var liq = result.data.liquidation_info;
			var liq_bpdg = result.data.liquidation_info.bpdg;
			var nf = Intl.NumberFormat();
			$('#debt_root_remain_approve').val(nf.format(Math.floor(result.data.original_debt.du_no_goc_con_lai))) ;
			$('#price_suggest_bpdg_display_approve').val(nf.format(Math.floor(liq_bpdg.price_suggest_bpdg))) ;
			$('#name_valuation_display_approve').val(liq_bpdg.name_valuation);
			$('#phone_valuation_display_approve').val(liq_bpdg.phone_valuation);
			$('#note_bpdg_display_approve').val(liq_bpdg.note);
			$('.contract_id_liq').val(result.data._id.$oid);
			$('#price_suggest_thn_approve').val(nf.format(Math.floor(result.data.liquidation_info.thn.price_suggest_thn)));
			var html = "";
			var html1 = "";
			if (liq_bpdg.img_liquidation != "") {
				for (var j in liq.img_liquidation) {
					var loc = new URL(liq.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq.img_liquidation[j].file_type == 'image/png' || liq.img_liquidation[j].file_type == 'image/jpg' || liq.img_liquidation[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq.img_liquidation[j].path + "'>" + "</a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'audio/mp3' || liq.img_liquidation[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"' >" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none' name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"'>" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + liq.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}
			if (liq_bpdg.img_liquidation != "") {
				for (var j in liq_bpdg.img_liquidation) {
					var loc = new URL(liq_bpdg.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq_bpdg.img_liquidation[j].file_type == 'image/png' || liq_bpdg.img_liquidation[j].file_type == 'image/jpg' || liq_bpdg.img_liquidation[j].file_type == 'image/jpeg') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a href='" + liq_bpdg.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq_bpdg.img_liquidation[j].key + "' data-fileName='" + liq_bpdg.img_liquidation[j].file_name + "' data-fileType='" + liq_bpdg.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq_bpdg.img_liquidation[j].path + "'>" + "</a>";
						html1 += "</div>"
					}
					if (liq_bpdg.img_liquidation[j].file_type == 'audio/mp3' || liq_bpdg.img_liquidation[j].file_type == 'audio/mpeg') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"' >" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html1 += "</div>"
					}
					if (liq_bpdg.img_liquidation[j].file_type == 'video/mp4') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display: none' name='img_send_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html1 += "</div>"
					}
					if (liq_bpdg.img_liquidation[j].file_type == 'application/pdf') {
						html1 += "<div class='block'>";
						html1 += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html1 += "<a target='_blank' href='" + liq_bpdg.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq_bpdg.img_liquidation[j].key + "' data-fileName='" + liq_bpdg.img_liquidation[j].file_name + "' data-fileType='" + liq_bpdg.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq_bpdg.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html1 += "</div>"
					}
				}
			} else {
				html1 += '<td></td>'
			}
			$("#img_liquidation_thn_create_display_approve").append(html);
			$("#img_liquidation_bpdg_display_approve").append(html1);
			$('#ApproveInstate').modal('show');
		}
	});
}

//TP THN duyệt thay CEO (tài sản thanh lý) (Action duyệt)
$('#tpthn_approve_rep').click(function (event) {
	event.preventDefault();
	var id_contract = $('.contract_id_liq').val();
	var action = 'approve_instate_ceo';
	var status = 48;
	var price_suggest_thn_send_ceo = $('#price_suggest_thn_approve').val();
	var price_refer_ceo = $('#price_refer_ceo_approve').val();
	var note_thn_update = $('#note_thn_update_approve').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			type = $(this).data('type');
			var data = {};
			data['file_type'] = $(this).attr("data-fileType");
			data['file_name'] = $(this).attr("data-fileName");
			data['path'] = $(this).attr("src");
			data['key'] = $(this).attr("data-key");
			var key = $(this).data("key");
			if (type == 'img_file') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận duyệt tài sản thanh lý ?")) {
		var formData = {
			_id: id_contract,
			action: action,
			status: status,
			price_suggest_thn_send_ceo: price_suggest_thn_send_ceo,
			price_refer_ceo: price_refer_ceo,
			note: note_thn_update,
			image_file: image_file,
		};
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: 'POST',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('#ApproveInstate').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					})
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				})
			}
		})
	}
});

//TP THN trả về Bước 02 (tài sản thanh lý) (Action trả)
$('#tpthn_return').click(function (event) {
	event.preventDefault();
	var id_contract = $('.contract_id_liq').val();
	var action = 'return_bpdg';
	var status = 49;
	var price_refer_ceo = $('#price_suggest_thn_approve').val();
	var note_thn_update = $('#note_thn_update_approve').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			type = $(this).data('type');
			var data = {};
			data['file_type'] = $(this).attr("data-fileType");
			data['file_name'] = $(this).attr("data-fileName");
			data['path'] = $(this).attr("src");
			data['key'] = $(this).attr("data-key");
			var key = $(this).data("key");
			if (type == 'img_file') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận trả về bộ phận định giá ?")) {
		var formData = {
			_id: id_contract,
			action: action,
			status: status,
			price_refer_ceo: price_refer_ceo,
			note: note_thn_update,
			image_file: image_file,
		};
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: 'POST',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('#ApproveInstate').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					})
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				})
			}
		})
	}
});

//Show thông tin update BP Định giá lại tài sản thanh lý
function bp_dinh_gia_lai(id) {
	$("#debt_remain_root_bpdg_update").empty();
	$("#date_seize_bpdg_update").empty();
	$("#name_person_seize_bpdg_update").empty();
	$("#frame_number_bpdg_update").empty();
	$("#engine_number_bpdg_update").empty();
	$("#license_plates_bpdg_update").empty();
	$("#license_number_bpdg_update").empty();
	$("#note_create_liq_update").empty();
	$("#img_create_liquidation_update").empty();
	$("#img_thn_return").empty();
	$("#img_bpdg_update").empty();
	$("#name_valuation_update").empty();
	$("#phone_valuation_update").empty();
	$("#price_suggest_bpdg_update").empty();
	$("#note_bpdg_update").empty();
	$("#date_effect_bpdg_update").empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var liq = result.data.liquidation_info;
			var liq_thn = result.data.liquidation_info.thn;
			var liq_bpdg = result.data.liquidation_info.bpdg;
			var debt_remain_root = result.data.original_debt.du_no_goc_con_lai;
			var date_seize_bpdg = new Date(liq.date_seize).format('d/m/Y');
			var name_person_seize_bpdg = liq.name_person_seize;
			var frame_number_bpdg = liq.frame_number;
			var engine_number_bpdg = liq.engine_number;
			var license_plates_bpdg = liq.license_plates;
			var license_number_bpdg = liq.license_number;
			var note_create_liq = liq.note_create_liquidation;
			var html1 = "";
			var html2 = "";
			var html3 = "";
			var html4 = "";
			var html5 = "";
			var html6 = "";
			var html7 = "";
			var html8 = "";
			html1 += "<p class='text-danger' style='padding-top: 8px'>" + numeral(debt_remain_root).format('0,0') + " VNĐ" + "</p>";
			html2 += "<p style='padding-top: 8px; color: black'>" + date_seize_bpdg + "</p>";
			html3 += "<p style='padding-top: 8px; color: black'>" + name_person_seize_bpdg + "</p>";
			html4 += "<p style='padding-top: 8px; color: black'>" + frame_number_bpdg + "</p>";
			html5 += "<p style='padding-top: 8px; color: black'>" + engine_number_bpdg + "</p>";
			html6 += "<p style='padding-top: 8px; color: black'>" + license_plates_bpdg + "</p>";
			html7 += "<p style='padding-top: 8px; color: black'>" + license_number_bpdg + "</p>";
			html8 += "<textarea style='padding-top: 8px; color: black' class='col-md-12 col-xs-12 form-control' rows='3' disabled>" + note_create_liq + "</textarea>";
			$("#debt_remain_root_bpdg_update").append(html1);
			$("#date_seize_bpdg_update").append(html2);
			$("#name_person_seize_bpdg_update").append(html3);
			$("#frame_number_bpdg_update").append(html4);
			$("#engine_number_bpdg_update").append(html5);
			$("#license_plates_bpdg_update").append(html6);
			$("#license_number_bpdg_update").append(html7);
			$("#note_create_liq_update").append(html8);
			var nf = Intl.NumberFormat();
			$('input[name="contract_id_liq"]').val(result.data._id.$oid);
			$("input[name='note_bpdg_update']").val();
			$('input[name="name_valuation_update"]').val(liq.bpdg.name_valuation);
			$('input[name="phone_valuation_update"]').val(liq.bpdg.phone_valuation);
			$('input[name="date_effect_bpdg_update"]').val(liq.bpdg.date_effect_bpdg);
			$('input[name="price_suggest_bpdg_update"]').val(nf.format(Math.floor(liq.bpdg.price_suggest_bpdg)));
			$('#note_bpdg_update').val(liq.bpdg.note);
			var html = "";
			var html_img_thn = "";
			var html_img_bpdg = "";
			if (liq.img_liquidation != "") {
				for (var j in liq.img_liquidation) {
					var loc = new URL(liq.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq.img_liquidation[j].file_type == 'image/png' || liq.img_liquidation[j].file_type == 'image/jpg' || liq.img_liquidation[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq.img_liquidation[j].path + "'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'audio/mp3' || liq.img_liquidation[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"' ></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display: none' name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + liq.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq.img_liquidation[j].file_name + "</a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}
			if (liq_thn.image_from_email_ceo != "") {
				for (var j in liq_thn.image_from_email_ceo) {
					var loc = new URL(liq_thn.image_from_email_ceo[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq_thn.image_from_email_ceo[j].file_type == 'image/png' || liq_thn.image_from_email_ceo[j].file_type == 'image/jpg' || liq_thn.image_from_email_ceo[j].file_type == 'image/jpeg') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a href='" + liq_thn.image_from_email_ceo[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq_thn.image_from_email_ceo[j].key + "' data-fileName='" + liq_thn.image_from_email_ceo[j].file_name + "' data-fileType='" + liq_thn.image_from_email_ceo[j].file_type + "' data-type='send_file' class='w-100' src='" + liq_thn.image_from_email_ceo[j].path + "'></a>";
						html_img_thn += "</div>"
					}
					if (liq_thn.image_from_email_ceo[j].file_type == 'audio/mp3' || liq_thn.image_from_email_ceo[j].file_type == 'audio/mpeg') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a href='" + liq_thn.image_from_email_ceo[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_thn.image_from_email_ceo[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq_thn.image_from_email_ceo[j].key +"' data-fileName='"+ liq_thn.image_from_email_ceo[j].file_name +"' data-fileType='"+ liq_thn.image_from_email_ceo[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_thn.image_from_email_ceo[j].path +"' ></a>";
						html_img_thn += "</div>"
					}
					if (liq_thn.image_from_email_ceo[j].file_type == 'video/mp4') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a href='" + liq_thn.image_from_email_ceo[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_thn.image_from_email_ceo[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display: none' name='img_send_file' data-key='"+ liq_thn.image_from_email_ceo[j].key +"' data-fileName='"+ liq_thn.image_from_email_ceo[j].file_name +"' data-fileType='"+ liq_thn.image_from_email_ceo[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_thn.image_from_email_ceo[j].path +"'></a>";
						html_img_thn += "</div>"
					}
					if (liq_thn.image_from_email_ceo[j].file_type == 'application/pdf') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a target='_blank' href='" + liq_thn.image_from_email_ceo[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq_thn.image_from_email_ceo[j].key + "' data-fileName='" + liq_thn.image_from_email_ceo[j].file_name + "' data-fileType='" + liq_thn.image_from_email_ceo[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq_thn.image_from_email_ceo[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq_thn.image_from_email_ceo[j].file_name + "</a>";
						html_img_thn += "</div>"
					}
				}
			} else {
				html_img_thn += '<td></td>'
			}
			if (liq_bpdg.img_liquidation != "") {
				for (var j in liq_bpdg.img_liquidation) {
					var loc = new URL(liq_bpdg.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s')
					if (liq_bpdg.img_liquidation[j].file_type == "image/png" || liq_bpdg.img_liquidation[j].file_type == "image/jpg" || liq_bpdg.img_liquidation[j].file_type == "image/jpeg") {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-src='" + liq_bpdg.img_liquidation[j].path + "' data-group='thegallery' data-gallery='img_liquidation' data-max-width='992' data-type='img_liqui'><img data-type='img_liqui' data-filetype='" + liq_bpdg.img_liquidation[j].file_type + "' data-filename='" + liq_bpdg.img_liquidation[j].file_name + "' name='img_file' data-key='" + liq_bpdg.img_liquidation[j].key + "' src='" + liq_bpdg.img_liquidation[j].path + "'>" + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg +=	"</div>";
					} else if (liq_bpdg.img_liquidation[j].file_type == "audio/mp3" || liq_bpdg.img_liquidation[j].file_type == 'audio/mpeg') {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='img_liqui' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"' >" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg += "</div>"
					} else if (liq_bpdg.img_liquidation[j].file_type == "video/mp4") {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none;' name='img_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='img_liqui' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg += "</div>"
					} else if (liq_bpdg.img_liquidation[j].file_type == "application/pdf") {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a target='_blank' href='" + liq_bpdg.img_liquidation[j].path + "' data-max-width='992' data-type='img_liqui'><img name='img_file' data-key='" + liq_bpdg.img_liquidation[j].key + "' data-fileName='" + liq_bpdg.img_liquidation[j].file_name + "' data-fileType='" + liq_bpdg.img_liquidation[j].file_type + "' data-type='img_liqui' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq_bpdg.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg += "</div>"
					}
				}
			}
			$("#img_create_liquidation_update").append(html);
			$("#img_thn_return").append(html_img_thn);
			$("#img_bpdg_update").append(html_img_bpdg);
			$("#bpdg_update_modal").modal("show");
		}
	});
}

//Update thông tin BP Định giá gửi lại
$('#bpdg_approve_again').click(function (event) {
	event.preventDefault();
	var id_contract = $('.contract_id_liq').val();
	var action = 'resend';
	var status = 46;
	var name_valuation = $('#name_valuation_update').val();
	var phone_valuation = $('#phone_valuation_update').val();
	var price_suggest_bpdg = $('#price_suggest_bpdg_update').val();
	var date_effect_bpdg = $('#date_effect_bpdg_update').val();
	var note_bpdg = $('#note_bpdg_update').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'img_liqui') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận gửi lại thông tin định giá tài sản thanh lý ?")) {
		var formData = {
			_id: id_contract,
			action: action,
			status: status,
			name_valuation: name_valuation,
			phone_valuation: phone_valuation,
			price_suggest_bpdg: price_suggest_bpdg,
			date_effect_bpdg: date_effect_bpdg,
			image_file: image_file,
			note: note_bpdg
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();

			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('#ApproveInstate').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					})
				}
			},
			error: function (data) {
				$('.theloading').hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				})
			}
		})
	}
});

//THN bán tài sản thanh lý và nhập liệu
function tpthn_sell_asset_liquidation (id) {
	$('#price_ceo_approve').empty();
	$('#price_thn_send_ceo').empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: 'GET',
		dateType: 'JSON',
		success: function (result) {
			var liq = result.data.liquidation_info;
			var nf = Intl.NumberFormat();
			$('.contract_id_liq').val(result.data._id.$oid);
			$('#price_ceo_approve').val(nf.format(Math.floor(liq.thn.price_refer_ceo)));
			$('#price_thn_send_ceo').val(nf.format(Math.floor(liq.thn.price_suggest_thn_send_ceo)));
			$('#thn_sell_asset').modal('show');

		}
	})
}


$('#thn_update_sold').click(function (event) {
	event.preventDefault();
	var contract_id = $('.contract_id_liq').val();
	var status = 40;
	var action = 'sold';
	var name_buyer = $('#name_buyer_new').val();
	var phone_number_buyer = $('#phone_buyer_new').val();
	var price_real_sold = $('#price_real_sold').val();
	var fee_sold = $('#fee_sold').val();
	var date_sold = $('#date_sold').val();
	var note = $('#note_sold_asset').val();
	var image_file = {};
	var count = $("img[name='img_file']").length;
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == "img_liqui") {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận cập nhật thông tin bán tài sản thanh lý ?")) {
		var formData = {
			_id: contract_id,
			action: action,
			status: status,
			name_buyer: name_buyer,
			phone_number_buyer: phone_number_buyer,
			price_real_sold: price_real_sold,
			fee_sold: fee_sold,
			date_sold: date_sold,
			image_file: image_file,
			note: note
		};
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: 'POST',
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$('.theloading').hide();
					$('#thn_sell_asset').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$('.theloading').hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$('.theloading').hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		})
	}
});

$('.cancel_liquidation').click(function (event) {
	event.preventDefault();
	var contract_id = $("input[name='contract_id_liq']").val();
	var action = 'cancel';
	var status = 17;
	var note = $("textarea[name='note_cancel_liq']").val();
	if (confirm("Xác nhận Hủy thanh lý tài sản đảm bảo!")) {
		var formData = {
			_id: contract_id,
			action: action,
			status: status,
			note: note,
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status == 200) {
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		})
	}

});

// Edit input liquidation infor
$('.asset_name_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa tên tài sản?")) {
		$('#asset_name').prop('disabled', false);
	}
});
$('.asset_branch_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa tên nhãn hiệu?")) {
		$('#asset_branch').prop('disabled', false);
	}
});
$('.license_plates_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa biển số xe?")) {
		$('#license_plates').prop('disabled', false);
	}
});
$('.asset_model_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa model xe?")) {
		$('#asset_model').prop('disabled', false);
	}
});
$('.frame_number_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa số khung?")) {
		$('#frame_number').prop('disabled', false);
	}
});
$('.engine_number_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa số máy?")) {
		$('#engine_number').prop('disabled', false);
	}
});
$('.license_number_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa số đăng ký?")) {
		$('#license_number').prop('disabled', false);
	}
});
$('.number_km_event').on("click", function (event) {
	event.preventDefault();
	if (confirm("Xác nhận sửa số km đã đi?")) {
		$('#number_km').prop('disabled', false);
	}
});





$('#price_suggest_bpdg').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#price_suggest_bpdg').keyup(function (event) {
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

$('#price_suggest_thn').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#price_suggest_thn').keyup(function (event) {
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

$('#price_real_sold').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#price_real_sold').keyup(function (event) {
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

$('#fee_sold').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#fee_sold').keyup(function (event) {
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

$('#price_suggest_bpdg_update').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#price_suggest_bpdg_update').keyup(function (event) {
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
$('#price_refer_ceo_approve').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#price_refer_ceo_approve').keyup(function (event) {
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

