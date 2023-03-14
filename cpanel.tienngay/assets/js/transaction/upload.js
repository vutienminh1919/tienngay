function check_all_kt(t) {
	var check = $("#combox_check").val();
	$('.datatablebutton input:checked').each(function (item) {
		$("#" + $(this).val()).val(check);
		update_kt($(this).val(), check);

	});

	// setTimeout(function(){
	// 	window.location.href = _url.base_url + 'transaction/list_kt?tab='+$('input[name="tab"]').val();
	// }, 2000);
}

function update_kt(id, check) {
	var status = 2;
	if (check == "duyet")
		status = 1

	if (check == "huyduyet")
		status = 3
	var code_transaction_bank = $("#code_transaction_bank-" + id).val();
	var note = $("#note-" + id).val();
	var bank = $("#bank-" + id).val();
	var formData = {
		status: status,
		transaction_id: id,
		note: note,
		approve_note: note,
		code_transaction_bank: code_transaction_bank,
		bank: bank,
		gach_no: 1
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approve",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				//$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text("Thành công");

			} else {
				//$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	});
}

function getFloat(val) {
	var val = val.replace(/,/g, "");
	return parseFloat(val);
}

$(".submit_transaction_img").on("click", function (event) {
	event.preventDefault();
	var transactionId = $("#transaction_id").val();
	var count = $("textarea[name='description_img']").length;
	console.log(count);
	// var arrDescription = [];
	var expertise = {};
	var img_transaction = $("img[name='img_transaction']").length;
	if (img_transaction > 0) {
		$("img[name='img_transaction']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['description'] = "";
			var key = $(this).data('key');
			expertise[key] = data;
		});
	}

	if (count > 0) {
		$("textarea[name='description_img']").each(function () {
			var data = {};
			var key_tera = $(this).data('key');
			console.log(key_tera);
			data['key'] = $(this).data('key');
			data['description'] = $(this).val();
			expertise[key_tera]['description'] = $(this).val();
			// arrDescription.push(data);
		});
	}
	console.log(expertise);
	var formData = {
		transactionId: transactionId,
		expertise: expertise,
		// arrDescription: arrDescription
	};
	$.ajax({
		url: _url.base_url + '/transaction/updateDescriptionImage',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (response) {
			if (response.status == 200) {
				$("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				console.log(response);
				if (response.type == 3 || response.type == 4) {
					setTimeout(function () {
						window.location.href = _url.base_url + "transaction?tab=wait";
					}, 2000);
				} else if (response.type == 7) {
					setTimeout(function () {
						window.location.href = _url.base_url + "heyU?tab=transaction";
					}, 2000);
				} else if (response.type == 8) {
					setTimeout(function () {
						window.location.href = _url.base_url + "mic_tnds?tab=transaction";
					}, 2000);
				} else if (response.type == 10) {
					setTimeout(function () {
						window.location.href = _url.base_url + "vbi_tnds?tab=transaction";
					}, 2000);
				} else if (response.type == 11) {
					setTimeout(function () {
						window.location.href = _url.base_url + "baoHiemVbi/utv?tab=transaction";
					}, 2000);
				} else if (response.type == 12) {
					setTimeout(function () {
						window.location.href = _url.base_url + "baoHiemVbi/sxh?tab=transaction";
					}, 2000);
				} else if (response.type == 13) {
					setTimeout(function () {
						window.location.href = _url.base_url + "gic_easy?tab=transaction";
					}, 2000);
				} else if (response.type == 14) {
					setTimeout(function () {
						window.location.href = _url.base_url + "gic_plt?tab=transaction";
					}, 2000);
				} else if (response.type == 15) {
					setTimeout(function () {
						window.location.href = _url.base_url + "pti_vta?tab=transaction";
					}, 2000);
				} else if (response.type == 1) {
					setTimeout(function () {
						window.location.href = _url.base_url + "transaction/getBillingUtilities?tab=transaction";
					}, 2000);
				} else {
					setTimeout(function () {
						window.location.href = _url.base_url + "heyU?tab=transaction";
					}, 2000);
				}

			} else {
				$("#approve_disbursement").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
				// setTimeout(function(){ 
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function (data) {
			$("#loading").hide();
		}
	});

});

// $('input[type=file]').change(function(){

// 	var transactionId = $("#transaction_id").val();
// 	var count = $("img[name='img_transaction']").length;
// 	var expertise = {};
// 	if(count > 0) {
// 		$("img[name='img_transaction']").each(function() {
// 			var data = {};
// 			type = $(this).data('type');
// 			data['file_type'] = $(this).attr('data-fileType');
// 			data['file_name'] = $(this).attr('data-fileName');
// 			data['path'] = $(this).attr('src');
// 			data['description'] = "";
// 			var key = $(this).data('key');
// 			if(type == 'expertise'){
// 				expertise[key] = data;
// 			}
// 		});
// 	}
// 	var formData = {
// 		transactionId: transactionId,
// 		expertise: expertise,
// 	};
// 	console.log(formData);
// 	$.ajax({
// 		url :  _url.base_url + '/transaction/doUpload',
// 		type: "POST",
// 		data : formData,
// 		dataType : 'json',
// 		beforeSend: function(){$(".theloading").show();},
// 		success: function(data) {
// 			$(".theloading").hide();
// 			if (data.code == 200) {
// 				// $("#successModal").modal("show");
// 				// $(".msg_success").text(data.msg);
// 				// setTimeout(function(){
// 				// 	window.location.href =  _url.base_url + "transaction";
// 				// }, 2000);
// 			} else {
// 				$("#errorModal").modal("show");
// 				$(".msg_error").text(data.msg);
// 			}
// 		},
// 		error: function(data) {
// 			$(".theloading").hide();
// 		}
// 	});

// });

$('input[type=file]').change(function () {
	var contain = $(this).data("contain");
	var title = $(this).data("title");
	var type = $(this).data("type");
	var transactionId = $("#transaction_id").val();
	$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
		//$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
		allowedExts: ["jpg", "jpeg", "jpe", "png", "gif","pdf"],
		allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif","application/pdf"],
		maxFileSize: 10000000, //10MB,
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
			'transaction_id': transactionId
		},
		progress: function (progress) {
			//received progress
			this.progressBar.width(progress + "%");
		},
		success: function (data) {
			//upload successful
			this.progressBar.remove();
			if (data.code == 200) {

				var content = "";
                if(contain=='uploads_expertise' && fileType != 'application/pdf')
                {
				content += '<img id="pdf" data-type="' + type + '"  data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_transaction"  data-key="' + data.key + '" src="' + data.path + '" /><button type="button" onclick="deleteImage(this)" data-id="' + transactionId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"><textarea rows="6" data-key="' + data.key + '" name="description_img" ></textarea></div>';
			    }else{
			    content += '<img  data-type="' + type + '"  data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_transaction"  data-key="' + data.key + '" src="' + data.path + '" /><button type="button" onclick="deleteImage(this)" data-id="' + transactionId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"></div>';
			    }
			 if(fileType == 'application/pdf') {
					var content = "";
				 content += '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_transaction"  data-key="'+data.key+'" src="'+data.path+'" /></a><div class="description"><textarea rows="6" data-key="' + data.key + '" name="description_img" ></textarea></div>';
				 content += '<button type="button" onclick="deleteImage(this)" data-id="'+transactionId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';

				}


				var data = $('<div ></div>').html(content);
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
			alert(msg);
		}
	});
});

function duyet_viewImg(thiz) {
	let id = $(thiz).data("id");
	let bank = $(thiz).data("bank");
	let code_transaction_bank = $(thiz).data("code_transaction_bank");
	let note = $(thiz).data("note");
	$(".transaction_id").val(id);
	$(".bank").val(bank);
	$(".code_transaction_bank").val(code_transaction_bank);
	$(".note").val(note);

	$("#duyet_viewImg").modal("show");
}

function huy_viewImg(thiz) {
	let id = $(thiz).data("id");
	let bank = $(thiz).data("bank");
	let code_transaction_bank = $(thiz).data("code_transaction_bank");
	let note = $(thiz).data("note");
	$(".transaction_id").val(id);
	$(".bank").val(bank);
	$(".code_transaction_bank").val(code_transaction_bank);
	$(".note").val(note);
	$(".reason-list").remove();
	$("#huy_viewImg").find(".text-right").before(cancelReason);
	$("#huy_viewImg").modal("show");
}

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var res = confirm("Bạn có chắc chắn muốn xóa ảnh này ?");
	if (res == true) {
		$(thiz_).closest("div .block").remove();
		toastr.success("Xóa ảnh thành công", {
			timeOut: 2000
		});
	}
}

function ktduyetgiaodich(thiz) {

	$(".status_approve").val(1);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_approve").val(transaction_id);
	$("#bank_input").val($(thiz).data("bank"));
	$("#code_transaction_bank_input").val($(thiz).data("code"));
	$(".reason-list").remove();
	$("#approve_transaction").modal("show");
}

function ktduyetphieuthu(thiz){
	$(".modal-title-approve").text("BẠN CÓ CHẮC MUỐN DUYỆT PHIẾU THU NÀY?");
	$(".status_approve").val(5);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_approve").val(transaction_id);
	$("#approve_transaction_ksnb").modal("show");
}

function kthuygiaodich_ksnb(thiz){
	$(".modal-title-approve").text("BẠN CÓ CHẮC MUỐN HỦY PHIẾU THU NÀY?");
	$(".status_approve").val(3);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_approve").val(transaction_id);
	$("#approve_transaction_ksnb").modal("show");
}


function kthuygiaodich(thiz) {
	$(".modal-title-approve").text("Hủy giao dịch");
	$(".status_approve").val(3);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_approve").val(transaction_id);
	$(".reason-list").remove();
	$("#cancel_transaction").find(".text-right").before(cancelReason);
	$("#cancel_transaction").modal("show");
}

function kttrave(thiz) {
	$(".modal-title-approve").text("Trả về phòng giao dịch");
	$(".status_return").val(11);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_return").val(transaction_id);
	$(".reason-list").remove();
	$("#return_transaction").find(".text-right").before(returnReason);
	$("#return_transaction").modal("show");
}

function ktduyetgiaodichheyu(thiz) {
	$(".modal-title-approve").text("Duyệt giao dịch HeyU");
	$(".status_approve_heyu").val(1);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_approve_heyu").val(transaction_id);
	$("#approve_transaction_heyu").modal("show");
}

function kttraveheyu(thiz) {
	$(".modal-title-approve").text("Trả về phòng giao dịch HeyU");
	$(".status_return_heyu").val(11);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_return_heyu").val(transaction_id);
	$(".reason-list").remove();
	$("#return_transaction_heyu").find(".text-right").before(returnReason);
	$("#return_transaction_heyu").modal("show");
}
function kthuyheyu(thiz) {
	$(".modal-title-approve").text("Hủy giao dịch HeyU");
	$(".status_cancel_heyu").val(3);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_cancel_heyu").val(transaction_id);
	$(".reason-list").remove();
	$("#cancel_transaction_heyu").find(".text-right").before(cancelReason);
	$("#cancel_transaction_heyu").modal("show");
}

function ktduyetgiaodichgiahan(thiz) {
	// $(".modal-title-approve").text("Duyệt giao dịch");
	$(".status_approve1").val(1);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_approve1").val(transaction_id);
	$(".reason-list").remove();
	$("#approve_transaction1").modal("show");
}

function kthuygiaodichgiahan(thiz) {
	$(".modal-title-approve").text("Hủy giao dịch");
	$(".status_approve1").val(3);
	let transaction_id = $(thiz).data("id");
	$(".transaction_id_approve1").val(transaction_id);
	$(".reason-list").remove();
	$("#approve_transaction1").find(".text-right").before(cancelReason);
	$("#approve_transaction1").modal("show");
}


$(".btn_duyet_viewImg").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $("#duyet_viewImg .code_transaction_bank").val();
	var bank = $("#duyet_viewImg .bank").val();
	var note = $("#duyet_viewImg .note").val();
	var combox_check = $("#duyet_viewImg .combox_check").val();
	var url = "";
	var id = $("#duyet_viewImg .transaction_id").val();
	var status = 0;
	status = 1;
	url = _url.base_url + 'transaction/list_kt?tab=all';

	// if (combox_check == "huyduyet") {
	// 	status = 3;
	// 	url = _url.base_url + 'transaction/list_kt?tab=all';
	// }
	if (code_transaction_bank == "" || code_transaction_bank == undefined) {
		alert("Mã GD ngân hàng không thể trống");
		return false;
	}
	if (bank == "" || bank == undefined) {
		alert("Ngân hàng không thể trống");
		return false;
	}

	var formData = {
		note: note,
		approve_note: note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approve",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = url;
				}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
$(".btn_huy_viewImg").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $("#huy_viewImg .code_transaction_bank").val();
	var bank = $("#huy_viewImg .bank").val();
	var note = $("#huy_viewImg .note").val();
	var combox_check = $("#huy_viewImg .combox_check").val();
	var url = "";
	var id = $("#huy_viewImg .transaction_id").val();
	var status = 0;
	status = 3;
	url = _url.base_url + 'transaction/list_kt?tab=all';
	if (code_transaction_bank == "" || code_transaction_bank == undefined) {
		alert("Mã GD ngân hàng không thể trống");
		return false;
	}
	if (bank == "" || bank == undefined) {
		alert("Ngân hàng không thể trống");
		return false;
	}
	let reasons = [];
	if ($(modal).find('input[name="reason"]').length > 0) {
		// Kiểm tra có input lý do không ? Nếu có thì check require input
		let reasonsEl = $(modal).find('input[name="reason"]:checked');
		reasonsEl.each(function() {
		   reasons.push(this.value);
		});
		if (reasons.length < 1) {
			alert("Lý do chưa được chọn");
			return false;
		}
	}

	var formData = {
		note: note,
		approve_note: note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank,
		reasons: reasons
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/cancel_transaction",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = url;
				}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
$(".submit_send_approve_cc").on("click", function () {
	$(".warning_send_gh_cc").hide();
	let contract_id = $("input[name='contract_id']").val();

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_cc",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#cc_ma_hop_dong").empty();
				$("#cc_ma_hop_dong").append("<a target='_blank' href='"+_url.base_url + "/pawn/detail?id=" + contract_id+"#hoat_dong'>"+data.data.code_contract_disbursement+"</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_cc").text("Gửi trưởng phòng giao dịch duyệt cơ cấu");
				$(".status_approve_cc").val(23);
				$('.cancel_submit_cc').hide();
				$('.return_submit_cc').hide();
				$("#amount_money_cc").val(numeral(data.transactions.data.amount_cc).format('0,0'));
				$("#amount_debt_cc").val(numeral(data.tien_phai_tra).format('0,0'));
				$(".amount_debt_cc").val(numeral(data.tien_phai_tra).format('0,0'));
				 $(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id+'#hoat_dong');
				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#cocauhopdongModal").modal("show");
});
$(".submit_send_approve_gh").on("click", function () {
	$(".warning_send_gh_cc").hide();
	let contract_id = $("input[name='contract_id']").val();

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='"+_url.base_url + "/pawn/detail?id=" + contract_id+"#hoat_dong'>"+data.data.code_contract_disbursement+"</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_gh").text("Gửi TPGD duyệt gia hạn");
				$(".status_approve_gh").val(21);
				$(".error_code_contract").hide();
				$('.cancel_submit_gh').hide();
				$('.return_submit_gh').hide();
				 $(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id+'#hoat_dong');
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);


				$("#number_day_loan_gh option").each(function () {
					console.log($(this).val());
					if ($(this).val() > (data.data.loan_infor.number_day_loan / 30)) {
						$(this).remove();
					}
				});
				$("#giahanhopdongModal").modal("show");
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	})
});
$(".approve_submit_gh").on("click", function () {
	var note = $("#approve_note_gh").val();
	var status = $(".status_approve_gh").val();
	var contractId = $(".contract_id_gh").val();
	var exception = $("#exception_gh").val();

	var number_day_loan = $("#number_day_loan_gh").val();
	var count = $("img[name='img_transaction']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_transaction']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			var key = $(this).data('key');
			if (type == 'img_file') {
				image_file[key] = data;
			}
		});
	}

	var formData = {
		note: note,
		status: status,
		contractId: contractId,
		exception: exception,
		image_file: image_file,
		number_day_loan: number_day_loan,

	};
	var link = "";
	if (status == 21 || status == 25 || status == 29 || status == 11) {
		link = _url.base_url + "pawn/request_exten";
	} else if (status == 33) {
		link = _url.base_url + "accountant/approve_gia_han";
	}
	//Call ajax
	$("#approve").modal("hide");
	$("#extension").modal("hide");
	$.ajax({
		url: link,
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
				setTimeout(function(){
					window.location.href = _url.base_url+'pawn/contract_giahan';
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
$(".approve_submit_cc").on("click", function () {
	var note = $("#approve_note_cc").val();
	var status = $(".status_approve_cc").val();
	var contractId = $(".contract_id_cc").val();
	var exception = $("#exception_cc").val();
    var type_interest = $("#type_interest_cc").val();
	var amount_money = getFloat($("#amount_money_cc").val());
	var number_day_loan = $("#number_day_loan_cc").val();
	var type_loan = $("#type_loan_cc").val();
	console.log(amount_money);
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			var key = $(this).data('key');
			if (type == 'img_file') {
				image_file[key] = data;
			}
		});
	}
		var link = "";
	if (status == 23 || status == 27 || status == 31 || status == 12) {
		link = _url.base_url + "pawn/request_exten";
	} else if (status == 34) {
		link = _url.base_url + "accountant/approve_co_cau";
	}


	var formData = {
		note: note,
		status: status,
		contractId: contractId,
		exception: exception,
		image_file: image_file,
		amount_money: amount_money,
		number_day_loan: number_day_loan,
		type_loan: type_loan,
		type_interest: type_interest,


	};

	
	//Call ajax
	$("#approve").modal("hide");
	$("#extension").modal("hide");
	$.ajax({
		url: link,
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
				// $("#errorModal").modal("show");
				// $(".msg_error").text(data.msg);
				$(".text_waring_gh_cc").text(data.msg);
					$(".link_payment_gh_cc").text("");
					$(".link_payment_gh_cc").attr("href", '#');
					$(".warning_send_gh_cc").show();
				// setTimeout(function(){
				//     window.location.reload();
				// }, 10000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
$(".approve_submit").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $(modal).find("input[name='code_transaction_bank']").val();
	var bank = $(modal).find("input[name='bank']").val();
	var approve_note = $(".approve_note").val();
	var status = $(".status_approve").val();
	var id = $(".transaction_id_approve").val();

	if (code_transaction_bank == "" || code_transaction_bank == undefined) {
		alert("Mã GD ngân hàng không thể trống");
		return false;
	}
	if (bank == "" || bank == undefined) {
		alert("Ngân hàng không thể trống");
		return false;
	}

	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank
	};

	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approve",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#approve_transaction").hide();
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + 'transaction/list_kt?tab=all';
				}, 2000);
			} else {
				if (response.type == "bank_transaction") {
					$("#approve_transaction").modal("hide");
					$("#gachnoModal").modal("show");
				} else {
					$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
$(".gachno_approve_submit").on("click", function () {
	var modal = $('#approve_transaction .modal-body');
	console.log(modal);
	var code_transaction_bank = $(modal).find("input[name='code_transaction_bank']").val();
	var bank = $(modal).find("input[name='bank']").val();
	var approve_note = $(".approve_note").val();
	var status = $(".status_approve").val();
	var id = $(".transaction_id_approve").val();

	if (code_transaction_bank == "" || code_transaction_bank == undefined) {
		alert("Mã GD ngân hàng không thể trống");
		return false;
	}
	if (bank == "" || bank == undefined) {
		alert("Ngân hàng không thể trống");
		return false;
	}

	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank,
		gach_no: 1,
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approve",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + 'transaction/list_kt?tab=all';
				}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$(".approve_submit_ksnb").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $(modal).find("input[name='code_transaction_bank']").val();
	var bank = $(modal).find("input[name='bank']").val();
	var approve_note = $(".approve_note").val();
	var status = $(".status_approve").val();
	var id = $(".transaction_id_approve").val();

	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank
	};

	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approve",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text("Thành công");
				setTimeout(function () {
					window.location.href = _url.base_url + 'transaction/list_kt?tab=contract_ksnb';
				}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$(".approve_submit1").on("click", function () {
	var note = $(".approve_note1").val();
	var status = $(".status_approve1").val();
	var id = $(".transaction_id_approve1").val();
	var investor = $("#investor").val();
	var formData = {
		note: note,
		status: status,
		transaction_id: id,
		investor: investor
	};
	$("#approve_transaction").modal("hide");
	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approveExtension",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(response.data.message);
				setTimeout(function () {
					window.location.href = response.data.url;
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(response.data.message);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$(".return_transaction_submit").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var approve_note = $(".return_note").val();
	var status = $(".status_return").val();
	var id = $(".transaction_id_return").val();
	let reasons = [];
	if ($(modal).find('input[name="reason"]').length > 0) {
		// Kiểm tra có input lý do không ? Nếu có thì check require input
		let reasonsEl = $(modal).find('input[name="reason"]:checked');
		reasonsEl.each(function() {
		   reasons.push(this.value);
		});
		if (reasons.length < 1) {
			alert("Lý do chưa được chọn");
			return false;
		}
	}

	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		reasons:reasons
	};

	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/returnTransactionStore",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + "transaction/list_kt?tab=all";
					}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/list_kt?tab=all";
				}, 2000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$(".submit_send_approve_img").on("click", function (event) {

	event.preventDefault();
	$(".warning_send_gh_cc").hide();
	var transactionId = $("#transaction_id").val();
	var count = $("textarea[name='description_img']").length;
	console.log(count);
	// var arrDescription = [];
	var expertise = {};
	var img_transaction = $("img[name='img_transaction']").length;
	if (img_transaction > 0) {
		$("img[name='img_transaction']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['description'] = "";
			var key = $(this).data('key');
			expertise[key] = data;
		});
	}

	if (count > 0) {
		$("textarea[name='description_img']").each(function () {
			var data = {};
			var key_tera = $(this).data('key');
			console.log(key_tera);
			data['key'] = $(this).data('key');
			data['description'] = $(this).val();
			expertise[key_tera]['description'] = $(this).val();
			// arrDescription.push(data);
		});
	}

	var formData = {
		transactionId: transactionId,
		expertise: expertise,
		// arrDescription: arrDescription
	};
	if (confirm("Xác nhận gửi Kế toán duyệt!")) {
		$.ajax({
			url: _url.base_url + '/transaction/updateApproveImage',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (response) {
				if (response.status == 200) {
					$("#approve_disbursement").modal("hide");
					$("#successModal").modal("show");
					console.log(response);

					$(".msg_success").text(response.msg);

					if (response.data.type_payment == 1) {
						setTimeout(function () {
							window.location.href = _url.base_url + "transaction?tab=wait";
						}, 2000);
					} else if (response.data.type_payment == 2 || response.data.type_payment == 3) {
						setTimeout(function () {
							window.location.href = _url.base_url + "transaction/sendApprove?view=QLHDV&id=" + response.data._id.$oid;
						}, 2000);
					} else {
						if (response.type == 7) {
							setTimeout(function () {
								window.location.href = _url.base_url + "heyU/index?tab=transaction";
							}, 2000);
						} else if (response.type == 8) {
							setTimeout(function () {
								window.location.href = _url.base_url + "mic_tnds?tab=transaction";
							}, 2000);
						} else if (response.type == 10) {
							setTimeout(function () {
								window.location.href = _url.base_url + "vbi_tnds?tab=transaction";
							}, 2000);
						} else if (response.type == 11) {
							setTimeout(function () {
								window.location.href = _url.base_url + "baoHiemVbi/utv?tab=transaction";
							}, 2000);
						} else if (response.type == 12) {
							setTimeout(function () {
								window.location.href = _url.base_url + "baoHiemVbi/sxh?tab=transaction";
							}, 2000);
						} else {
							setTimeout(function () {
								window.location.href = _url.base_url + "transaction?tab=wait";
							}, 2000);
						}
					}

					if (response.data.status_ksnb == 1) {
						setTimeout(function () {
							window.location.href = _url.base_url + "contract_ksnb/list_transaction";
						}, 2000);
					}

				} else {
					$("#approve_disbursement").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (response) {
				$("#loading").hide();
			}
		});
	}
});

$(".heyu_approve_submit").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $(modal).find("input[name='code_transaction_bank']").val();
	var bank = $(modal).find("input[name='bank']").val();
	var approve_note = $(".approve_note_heyu").val();
	var status = $(".status_approve_heyu").val();
	var id = $(".transaction_id_approve_heyu").val();

	if (code_transaction_bank == "" || code_transaction_bank == undefined) {
		alert("Mã GD ngân hàng không thể trống");
		return false;
	}
	if (bank == "" || bank == undefined) {
		alert("Ngân hàng không thể trống");
		return false;
	}

	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank
	};

	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approveHeyU",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/approveTransactionHeyU?tab=all";
				}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/approveTransactionHeyU?tab=all";
				}, 2000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$(".heyu_return_submit").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var approve_note = $(".return_note_heyu").val();
	var status = $(".status_return_heyu").val();
	var id = $(".transaction_id_return_heyu").val();
	let reasons = [];
	if ($(modal).find('input[name="reason"]').length > 0) {
		// Kiểm tra có input lý do không ? Nếu có thì check require input
		let reasonsEl = $(modal).find('input[name="reason"]:checked');
		reasonsEl.each(function() {
		   reasons.push(this.value);
		});
		if (reasons.length < 1) {
			alert("Lý do chưa được chọn");
			return false;
		}
	}
	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		reasons : reasons
	};

	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approveHeyU",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/approveTransactionHeyU?tab=all";
				}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/approveTransactionHeyU?tab=all";
				}, 2000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
$(".heyu_cancel_submit").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $(modal).find("input[name='code_transaction_bank']").val();
	var bank = $(modal).find("input[name='bank']").val();
	var approve_note = $(".cancel_note_heyu").val();
	var status = $(".status_cancel_heyu").val();
	var id = $(".transaction_id_cancel_heyu").val();
	let reasons = [];
	if ($(modal).find('input[name="reason"]').length > 0) {
		// Kiểm tra có input lý do không ? Nếu có thì check require input
		let reasonsEl = $(modal).find('input[name="reason"]:checked');
		reasonsEl.each(function() {
		   reasons.push(this.value);
		});
		if (reasons.length < 1) {
			alert("Lý do chưa được chọn");
			return false;
		}
	}
	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank,
		reasons : reasons
	};

	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approveHeyU",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/approveTransactionHeyU?tab=all";
				}, 2000);
			} else {
				$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/approveTransactionHeyU?tab=all";
				}, 2000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
function check_all_heyu_kt(t) {
	var check = $("#combox_check_all").val();
	$('.datatablebutton input:checked').each(function (item) {
		$("#" + $(this).val()).val(check);
		update_heyu_kt($(this).val(), check);
	});
}

function update_heyu_kt(id, check) {
	var status = 2;
	if (check == "duyet")
		status = 1

	if (check == "ketoantrave")
		status = 11
	var code_transaction_bank = $("#code_transaction_bank-" + id).val();
	var note = $("#note-" + id).val();
	var bank = $("#bank-" + id).val();
	var formData = {
		status: status,
		transaction_id: id,
		note: note,
		code_transaction_bank: code_transaction_bank,
		bank: bank

	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/approveHeyU",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				//$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text("Thành công");
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/approveTransactionHeyU?tab=all";
				}, 2000);

			} else {
				//$("#approve_transaction").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(response.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	});
}

$('input[name="check_code_contract"]').click(function () {
	var code_contract = $("#code_contract_check").val();
	var code_transaction = $("#code_transaction_check").val();
	if ($(this).prop("checked") == true && (code_contract.length > 0 || code_transaction.length > 0)) {
		var formData = {
			code_contract: code_contract,
			code_transaction: code_transaction
		};
		$.ajax({
			url: _url.base_url + '/Ajax/checkTransaction',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
			console.log(data);
				if (data.res) {
					$("#checkTransaction").modal('show');
					$('#list_transaction_check').children().remove();
					let html = "";
					let content = data.data;
					for (var i = 0; i < content.length; i++) {
						let status = "không xác định";
						status = get_status_transaction(content[i].status);
						
						var note_array = content[i].note;
						var x;
						var note_tran = '';
						for (x in note_array) {
							note_tran += get_note_tran(Number(note_array[x]));
							console.log(note_tran);
						}
						const date = new Date(content[i].created_at*1000).format('d/m/Y H:i:s');
						var nf = Intl.NumberFormat();
						let key = i + 1;
						html += "<tr><td>" + key + "</td>";
						html += "<td>" + date.toLocaleString() + "</td>"
						html += "<td data-toggle='tooltip' data-placement='top' title='Click để xem chi tiết'><a target='_blank' href='" + _url.base_url + "transaction/viewImg_kt?id=" + content[i]._id.$oid + "'>" + content[i].code + "</a></td>"
						html += "<td>" + content[i].customer_name + "</td>"
						html += "<td>" + nf.format(content[i].total) + "</td>"
						html += "<td>" + content[i].store.name + "</td>"
						html += "<td>" + status + "</td>"
						html += "<td>" + note_tran + "</td>"
						html += "</tr>";
					}
					$("#list_transaction_check").append(html);
				} else {
					$("#checkTransactionFalse").modal('show');
				}
			},
			error: function (data) {
			}
		});
	}
});

function get_status_transaction($status)
{
	var status_tran="Chưa xác định";
	switch ($status) {
		case 1:
			status_tran = "Thành công";
			break;
		case 2:
			status_tran = "Chờ xác nhận";
			break;
		case 3:
			status_tran = "Đã hủy";
			break;
		case 4:
			status_tran = "Chưa gửi duyệt";
			break;
		case 11:
			status_tran = "Kế toán trả về";
			break;
	}
	return status_tran;
}
function get_note_tran($note_tran)
{
	var note_pgd="";
	switch ($note_tran) {
		case 1:
			note_pgd = " Thanh toán kỳ hợp đồng";
			break;
		case 2:
			note_pgd = " Thanh toán đủ kỳ";
			break;
		case 3:
			note_pgd = " Thanh toán đủ kỳ 1";
			break;
		case 4:
			note_pgd = " Thanh toán đủ kỳ 2";
			break;
		case 5:
			note_pgd = " Thanh toán đủ kỳ 3";
			break;
		case 6:
			note_pgd = " Thanh toán đủ kỳ 4";
			break;
		case 7:
			note_pgd = " Thanh toán đủ kỳ 5";
			break;
		case 8:
			note_pgd = " Thanh toán đủ kỳ 6";
			break;
		case 9:
			note_pgd = " Thanh toán đủ kỳ 7";
			break;
		case 10:
			note_pgd = " Thanh toán đủ kỳ 8";
			break;
		case 11:
			note_pgd = " Thanh toán đủ kỳ 9";
			break;
		case 12:
			note_pgd = " Thanh toán đủ kỳ 10";
			break;
		case 13:
			note_pgd = " Thanh toán đủ kỳ 11";
			break;
		case 14:
			note_pgd = " Thanh toán đủ kỳ 12";
			break;
		case 15:
			note_pgd = " Thanh toán đủ kỳ 13";
			break;
		case 16:
			note_pgd = " Thanh toán đủ kỳ 14";
			break;
		case 17:
			note_pgd = " Thanh toán đủ kỳ 15";
			break;
		case 18:
			note_pgd = " Thanh toán đủ kỳ 16";
			break;
		case 19:
			note_pgd = " Thanh toán đủ kỳ 17";
			break;
		case 20:
			note_pgd = " Thanh toán đủ kỳ 18";
			break;
		case 21:
			note_pgd = " Thanh toán đủ kỳ 19";
			break;
		case 22:
			note_pgd = " Thanh toán đủ kỳ 20";
			break;
		case 23:
			note_pgd = " Thanh toán đủ kỳ 21";
			break;
		case 24:
			note_pgd = " Thanh toán đủ kỳ 22";
			break;
		case 25:
			note_pgd = " Thanh toán đủ kỳ 23";
			break;
		case 26:
			note_pgd = " Thanh toán đủ kỳ 24";
			break;
		case 27:
			note_pgd = " Thanh toán một phần kỳ";
			break;
		case 28:
			note_pgd = " Thanh toán một phần kỳ 1";
			break;
		case 29:
			note_pgd =  " Thanh toán một phần kỳ 2";
			break;
		case 30:
			note_pgd =  " Thanh toán một phần kỳ 3";
			break;
		case 31:
			note_pgd =  " Thanh toán một phần kỳ 4";
			break;
		case 32:
			note_pgd =  " Thanh toán một phần kỳ 5";
			break;
		case 33:
			note_pgd =  " Thanh toán một phần kỳ 6";
			break;
		case 34:
			note_pgd =  " Thanh toán một phần kỳ 7";
			break;
		case 35:
			note_pgd =  " Thanh toán một phần kỳ 8";
			break;
		case 36:
			note_pgd =  " Thanh toán một phần kỳ 9";
			break;
		case 37:
			note_pgd =  " Thanh toán một phần kỳ 10";
			break;
		case 38:
			note_pgd =  " Thanh toán một phần kỳ 11";
			break;
		case 39:
			note_pgd =  " Thanh toán một phần kỳ 12";
			break;
		case 40:
			note_pgd =  " Thanh toán một phần kỳ 13";
			break;
		case 41:
			note_pgd =  " Thanh toán một phần kỳ 14";
			break;
		case 42:
			note_pgd =  " Thanh toán một phần kỳ 15";
			break;
		case 43:
			note_pgd =  " Thanh toán một phần kỳ 16";
			break;
		case 44:
			note_pgd =  " Thanh toán một phần kỳ 17";
			break;
		case 45:
			note_pgd =  " Thanh toán một phần kỳ 18";
			break;
		case 46:
			note_pgd =  " Thanh toán một phần kỳ 19";
			break;
		case 47:
			note_pgd =  " Thanh toán một phần kỳ 20";
			break;
		case 48:
			note_pgd =  " Thanh toán một phần kỳ 21";
			break;
		case 49:
			note_pgd =  " Thanh toán một phần kỳ 22";
			break;
		case 50:
			note_pgd = " Thanh toán một phần kỳ 23";
			break;
		case 51:
			note_pgd = " Thanh toán một phần kỳ 24";
			break;
		case 52:
			note_pgd = " Phí phạt chậm trả";
			break;
		case 53:
			note_pgd = " Chậm trả kỳ 1";
			break;
		case 54:
			note_pgd = " Chậm trả kỳ 2";
			break;
		case 55:
			note_pgd = " Chậm trả kỳ 3";
			break;
		case 56:
			note_pgd = " Chậm trả kỳ 4";
			break;
		case 57:
			note_pgd = " Chậm trả kỳ 5";
			break;
		case 58:
			note_pgd = " Chậm trả kỳ 6";
			break;
		case 59:
			note_pgd = " Chậm trả kỳ 7";
			break;
		case 60:
			note_pgd = " Chậm trả kỳ 8";
			break;
		case 61:
			note_pgd = " Chậm trả kỳ 9";
			break;
		case 62:
			note_pgd = " Chậm trả kỳ 10";
			break;
		case 63:
			note_pgd = " Chậm trả kỳ 11";
			break;
		case 64:
			note_pgd = " Chậm trả kỳ 12";
			break;
		case 65:
			note_pgd = " Chậm trả kỳ 13";
			break;
		case 66:
			note_pgd = " Chậm trả kỳ 14";
			break;
		case 67:
			note_pgd = " Chậm trả kỳ 15";
			break;
		case 68:
			note_pgd = " Chậm trả kỳ 16";
			break;
		case 69:
			note_pgd = " Chậm trả kỳ 17";
			break;
		case 70:
			note_pgd = " Chậm trả kỳ 18";
			break;
		case 71:
			note_pgd = " Chậm trả kỳ 19";
			break;
		case 72:
			note_pgd = " Chậm trả kỳ 20";
			break;
		case 73:
			note_pgd = " Chậm trả kỳ 21";
			break;
		case 74:
			note_pgd = " Chậm trả kỳ 22";
			break;
		case 75:
			note_pgd = " Chậm trả kỳ 23";
			break;
		case 76:
			note_pgd = " Chậm trả kỳ 24";
			break;
		case 77:
			note_pgd = " Phí gia hạn";
			break;
		case 78:
			note_pgd = " Phí tất toán trước hạn";
			break;
		case 79:
			note_pgd = " Phí cơ cấu";
			break;
	}
	return note_pgd;
}
$("#amount_money_cc").on('input', function(e){ 

   if($(this).val())
   {
    var amount_debt_cc=$(".amount_debt_cc").val();
   var amount_money_cc=$(this).val();
   $("#amount_debt_cc").val(numeral(getFloat(amount_debt_cc)-getFloat(amount_money_cc)).format('0,0'));
}
  });
$('#checkTransaction').on('hidden.bs.modal', function (e) {
	// do something...
	$('input[name="check_code_contract"').prop('checked', false);
});

$("#type_loan_cc").change(function () {
	if ($(this).val() == "CC") {
		$("#number_day_loan_cc option").each(function () {
			console.log($(this).val());
			if ($(this).val() > 1) {
				$(this).remove();
			}
		});
	} else {
		$("#number_day_loan_cc option").each(function () {
			$(this).remove();
		});

		$('#number_day_loan_cc').append($('<option>', {value: 1, text: '1 tháng'}));
		$('#number_day_loan_cc').append($('<option>', {value: 3, text: '3 tháng'}));
		$('#number_day_loan_cc').append($('<option>', {value: 6, text: '6 tháng'}));
		$('#number_day_loan_cc').append($('<option>', {value: 9, text: '9 tháng'}));
		$('#number_day_loan_cc').append($('<option>', {value: 12, text: '12 tháng'}));
		$('#number_day_loan_cc').append($('<option>', {value: 18, text: '18 tháng'}));
		$('#number_day_loan_cc').append($('<option>', {value: 24, text: '24 tháng'}));
	}
});
$('#amount_money_cc').on('input', function (e) {
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
	}).on('keypress', function (e) {
		if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function (e) {
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});
	function formatCurrency(number){
    var n = number.split('').reverse().join("");
    var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
    return  n2.split('').reverse().join('');
}

$(".cancel_trans_submit").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $(modal).find("input[name='code_transaction_bank']").val();
	var bank = $(modal).find("input[name='bank']").val();
	var approve_note = $(".cancel_note").val();
	var status = $(".status_approve").val();
	var id = $(".transaction_id_approve").val();
	let reasons = [];
	if ($(modal).find('input[name="reason"]').length > 0) {
		// Kiểm tra có input lý do không ? Nếu có thì check require input
		let reasonsEl = $(modal).find('input[name="reason"]:checked');
		reasonsEl.each(function() {
		   reasons.push(this.value);
		});
		if (reasons.length < 1) {
			alert("Lý do chưa được chọn");
			return false;
		}
	}
	if (code_transaction_bank == "" || code_transaction_bank == undefined) {
		alert("Mã GD ngân hàng không thể trống");
		return false;
	}
	if (bank == "" || bank == undefined) {
		alert("Ngân hàng không thể trống");
		return false;
	}
	

	var formData = {
		approve_note: approve_note,
		status: status,
		transaction_id: id,
		code_transaction_bank: code_transaction_bank,
		bank: bank,
		reasons: reasons
	};

	//Call ajax
	$.ajax({
		url: _url.base_url + "transaction/cancel_transaction",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (response) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (response.status == 200) {
				$("#approve_transaction").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(response.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + 'transaction/list_kt?tab=all';
				}, 2000);
			} else {
				if (response.type == "bank_transaction") {
					$("#approve_transaction").modal("hide");
					$("#gachnoModal").modal("show");
				} else {
					$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
