function edit_fee(thiz) {
	let contract_id = $(thiz).data("id");
	$(".contract_id_fee").val(contract_id);
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
				$(".percent_interest_customer").val(data.data.fee.percent_interest_customer);
				$(".percent_advisory").val(data.data.fee.percent_advisory);
				$(".percent_expertise").val(data.data.fee.percent_expertise);
				$(".penalty_percent").val(data.data.fee.penalty_percent);
				$(".penalty_amount").val(numeral(data.data.fee.penalty_amount).format('0,0'));
				$(".extend").val(numeral(data.data.fee.extend).format('0,0'));
				$(".extend_new_five").val(numeral(data.data.fee.extend_new_five).format('0,0'));
				$(".extend_new_three").val(numeral(data.data.fee.extend_new_three).format('0,0'));
				$(".percent_prepay_phase_1").val(data.data.fee.percent_prepay_phase_1);
				$(".percent_prepay_phase_2").val(data.data.fee.percent_prepay_phase_2);
				$(".percent_prepay_phase_3").val(data.data.fee.percent_prepay_phase_3);
				$('.code_coupon').val(data.data.loan_infor.code_coupon);

				// $(".amount_loan").val(numeral(data.data.loan_infor.amount_money-money_gic).format('0,0'));
				$("#editFee").modal("show");

			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

}

function show_history(phone_number) {
	if (phone_number == undefined || phone_number == '') {
		alert("Không có số");
	}
	$.ajax({
		url: _url.base_url + "pawn/show_callhistory",
		method: "POST",
		data: {
			phone_number: phone_number
		},
		success: function (data) {
			if (data.data !== null) {
				var history = data.data.data;
				$('#list_lead').empty();
				if (typeof history !== 'undefined' && history.length > 0) {
					history.forEach(myFunction);

					function myFunction(item, index) {
						if (item.hangupCause == 'USER_BUSY') {
							var status = 'User bận';
						}
						if (item.hangupCause == 'NO_USER_RESPONSE') {
							var status = 'Không nghe máy';
						}
						if (item.hangupCause == 'NORMAL_CLEARING') {
							var status = 'Thành công';
						}
						if (item.hangupCause == 'CALL_REJECTED') {
							var status = 'Từ chối';
						}
						if (item.hangupCause == 'ORIGINATOR_CANCEL') {
							var status = 'Người gọi dừng';
						}
						if (item.hangupCause == 'NO_ANSWER') {
							var status = 'Cuộc gọi nhỡ';
						}
						document.getElementById("list_lead").innerHTML +=
							"<tr>" +
							"<td>" + (++index) + "</td>" +
							"<td>" + item.fromUser.email + "</td>" +
							"<td>" + item.fromNumber + "</td>" +
							"<td>" + status + "</td>" +
							"<td>Bắt đầu:" + moment.unix(item.startTime / 1000).format("DD/MM/YYYY HH:mm:ss") + "<br>Trả lời:" + moment.unix(item.answerTime / 1000).format("DD/MM/YYYY HH:mm:ss") + "<br>Kết thúc:" + moment.unix(item.endTime / 1000).format("DD/MM/YYYY HH:mm:ss") + "</td>" +
							"<td>Tổng time:" + item.duration + "<br>Tổng time tư vấn:" + item.billDuration + "</td>" +

							"</tr>"
						;
						// index + ":" + item + "<br>";
					}
				}
				$("#showhistory").modal("show");
			} else {
				$("#showhistory").modal("show");
			}
		},
		error: function (error) {
			console.log(error);
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


$(".submit_edit_fee").on("click", function () {
	//Get fee infor
	var code_coupon = $(".code_coupon").val();

	$("#editFee").modal("hide");
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/updateFee",
		method: "POST",
		data: {
			id: $(".contract_id_fee").val(),
			code_coupon: code_coupon
		},
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.code != 200) {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
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

function get_status_contract(stt) {
	var text_status = "";
	switch (stt) {
		case 17:
			text_status = "Đang vay";
			break;
		case 21:
			text_status = "Chờ trưởng PGD duyệt gia hạn";
			break;
		case 22:
			text_status = "Trưởng PGD không duyệt gia hạn";
			break;
		case 23:
			text_status = "Chờ trưởng PGD duyệt cơ cấu";
			break;
		case 24:
			text_status = "Trưởng PGD không duyệt cơ cấu";
			break;
		case 25:
			text_status = "Chờ hội sở duyệt gia hạn";
			break;
		case 26:
			text_status = "Hội sở không duyệt gia hạn";
			break;
		case 27:
			text_status = "Chờ hội sở duyệt cơ cấu";
			break;
		case 28:
			text_status = "Hội sở không duyệt cơ cấu";
			break;
		case 29:
			text_status = "Chờ kế toán duyệt gia hạn";
			break;
		case 30:
			text_status = "Chờ ASM duyệt gia hạn";
			break;
		case 31:
			text_status = "Chờ kế toán duyệt gia hạn";
			break;
		case 32:
			text_status = "Chờ ASM duyệt cơ cấu";
			break;
		case 33:
			text_status = "Đã gia hạn";
			break;
		case 34:
			text_status = "Đã cơ cấu";
			break;
		case 11:
			text_status = "Chờ TP QLHDV duyệt gia hạn";
			break;
		case 12:
			text_status = "Chờ TP QLHDV duyệt cơ cấu";
			break;
		case 13:
			text_status = "TP QLHDV không duyệt gia hạn";
			break;
		case 14:
			text_status = "TP QLHDV không duyệt cơ cấu";
			break;
		case 41:
			text_status = "ASM không duyệt gia hạn";
			break;
		case 42:
			text_status = "ASM không duyệt cơ cấu";
			break;


	}
	return text_status;
}

$("#ds_hop_dong_gh").on("click", function () {
	var id_contract = $('.contract_id_gh').val();
	var type_gh_cc = "";
	var status_extend = "";
	$.ajax({
		url: _url.base_url + "ajax/get_list_gh",
		method: "POST",
		data: {
			id_contract: id_contract
		},

		dataType: 'json',
		success: function (data) {
			$('#list_contract_gh_cc').empty();
			$('#title_list_cc_gh').val('DANH SÁCH HỢP ĐỒNG GIA HẠN');
			if (data.data !== null) {
				var history = data.data;

				if (typeof history !== 'undefined' && history.length > 0) {
					history.forEach(myFunction);

					function myFunction(item, index) {

						if (item.type_gh == "origin") {
							type_gh = "Hợp đồng gốc";
						} else if (item.type_gh > 0) {
							type_gh = "Gia hạn lần " + item.type_gh;
						} else {
							type_gh = "Hợp đồng gốc";
						}

						var extend_date = (moment.unix(item.extend_date).format("DD/MM/YYYY HH:mm:ss") == "Invalid date") ? '' : moment.unix(item.extend_date).format("DD/MM/YYYY HH:mm:ss");
						document.getElementById("list_contract_gh_cc").innerHTML +=
							"<tr>" +
							"<td>" + (++index) + "</td>" +
							"<td>" + item.code_contract_disbursement + "</td>" +
							"<td>" + item.code_contract + "</td>" +
							"<td>" + type_gh + "</td>" +
							"<td>" + extend_date + "</td>" +
							"<td>" + get_status_contract(item.status) + "</td>" +
							"<td><a href='" + _url.base_url + "pawn/detail?id=" + item._id.$oid + "' target='_blank' >Xem chi tiết</a></td>" +
							"</tr>"
						;
						// index + ":" + item + "<br>";
					}
				}
				$("#list_giahan_cc").modal("show");
			} else {
				$("#list_giahan_cc").modal("show");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});
});
$("#ds_hop_dong_cc").on("click", function () {
	var id_contract = $('.contract_id_cc').val();
	var type_gh_cc = "";
	var status_extend = "";
	$.ajax({
		url: _url.base_url + "ajax/get_list_cc",
		method: "POST",
		data: {
			id_contract: id_contract
		},
		dataType: 'json',
		success: function (data) {
			$('#list_contract_gh_cc').empty();
			$('#title_list_cc_gh').text('DANH SÁCH HỢP ĐỒNG CƠ CẤU');
			console.log(data);
			if (data.data !== null) {
				var history = data.data;

				if (typeof history !== 'undefined' && history.length > 0) {
					history.forEach(myFunction);

					function myFunction(item, index) {

						if (item.type_cc == "origin") {
							type_cc = "Hợp đồng gốc";
						} else if (item.type_cc > 0) {
							type_cc = "Cơ cấu lần " + item.type_cc;
						} else {
							type_cc = "Hợp đồng gốc";
						}

						var structure_date = (moment.unix(item.structure_date).format("DD/MM/YYYY HH:mm:ss") == "Invalid date") ? '' : moment.unix(item.ngay_co_cau).format("DD/MM/YYYY HH:mm:ss");
						document.getElementById("list_contract_gh_cc").innerHTML +=
							"<tr>" +
							"<td>" + (++index) + "</td>" +
							"<td>" + item.code_contract_disbursement + "</td>" +
							"<td>" + item.code_contract + "</td>" +
							"<td>" + type_cc + "</td>" +
							"<td>" + moment.unix(item.structure_date).format("DD/MM/YYYY HH:mm:ss") + "</td>" +
							"<td>" + get_status_contract(item.status) + "</td>" +
							"<td><a href='" + _url.base_url + "pawn/detail?id=" + item._id.$oid + "' target='_blank' >Xem chi tiết</a></td>" +
							"</tr>"
						;
						// index + ":" + item + "<br>";
					}
				}
				$("#list_giahan_cc").modal("show");
			} else {
				$("#list_giahan_cc").modal("show");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});
});
$('.code_coupon').change(function () {
	//Get fee infor
	var code_coupon = $(".code_coupon").val();


	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getFeeByCoupon",
		method: "POST",
		data: {
			id: $(".contract_id_fee").val(),
			code_coupon: code_coupon
		},
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.code != 200) {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			} else {
				$(".percent_interest_customer").val(data.data.fee.percent_interest_customer);
				$(".percent_advisory").val(data.data.fee.percent_advisory);
				$(".percent_expertise").val(data.data.fee.percent_expertise);
				$(".penalty_percent").val(data.data.fee.penalty_percent);
				$(".penalty_amount").val(numeral(data.data.fee.penalty_amount).format('0,0'));
				$(".extend").val(numeral(data.data.fee.extend).format('0,0'));
				$(".percent_prepay_phase_1").val(data.data.fee.percent_prepay_phase_1);
				$(".percent_prepay_phase_2").val(data.data.fee.percent_prepay_phase_2);
				$(".percent_prepay_phase_3").val(data.data.fee.percent_prepay_phase_3);

			}
		},
		error: function (error) {
			console.log(error);
		}
	})

});


function gui_tpgd_duyet_gia_han(thiz) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
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
				$("#approve_note_gh").val("");
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				if(typeof data.logs.new != 'undefined'  && data.data.status!=17){

				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);
				 var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
			    }

				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');


			
				  
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);

			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function gui_asm_duyet_gia_han(thiz,is_cvkd) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
			
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_gh").text("Gửi ASM duyệt gia hạn");
				$(".status_approve_gh").val(30);
				$(".error_code_contract").hide();
				$("#approve_note_gh").val("");
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_gh").val(data.data.status);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				if (!is_cvkd) {
					$('#number_day_loan_gh').attr('disabled', true);
					$('#exception_gh').attr('disabled', true);
					$('#addup_gh').empty();
					

				}else{
					$('.cancel_submit_gh').hide();
				    $('.return_submit_gh').hide();
				}
				
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
				
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
$("#amount_money_cc").on('input', function(e){ 

   if($(this).val())
   {
   	 var amount_money_cc=$(this).val();
   	 var amount_debt_cc=$(".amount_debt_cc").val();
   	if($(this).val()<0)
   	{
   		$("#amount_money_cc").val(0);
   		amount_money_cc=0;
   	}
    
  
   $("#amount_debt_cc").val(numeral(getFloat(amount_debt_cc)-getFloat(amount_money_cc)).format('0,0'));
}
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

function gui_hs_duyet_gia_han(thiz, is_cvkd) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
			
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_gh").text("Gửi hội sở duyệt gia hạn");
				$(".status_approve_gh").val(25);
				$(".error_code_contract").hide();
				$("#approve_note_gh").val("");
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_gh").val(data.data.status);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				if (!is_cvkd) {
					$('#number_day_loan_gh').attr('disabled', true);
					$('#exception_gh').attr('disabled', true);
					$('#addup_gh').empty();
					

				}else{
					$('.cancel_submit_gh').hide();
				    $('.return_submit_gh').hide();
				}
			
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
				
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function tpgd_gui_duyet_gia_han(thiz, is_cvkd) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
			
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_gh").text("Gửi ASM duyệt gia hạn");
				 $(".status_approve_gh").val(30);
				
				 if(data.data.status==17)
				{
				 $(".title_modal_approve_gh").text("Gửi ASM duyệt gia hạn");
				 $(".status_approve_gh").val(30);
			
			    }
			    if(data.data.status==41 || data.data.status==21)
				{
				 $(".title_modal_approve_gh").text("Gửi ASM duyệt gia hạn");
				 $(".status_approve_gh").val(30);
				 
			    }
			     if(data.data.status==13)
				{
				 $(".title_modal_approve_gh").text("Gửi TP THN duyệt gia hạn");
				 $(".status_approve_gh").val(11);
				 
			    }
			     if(data.data.status==26)
				{
				 $(".title_modal_approve_gh").text("Gửi hội sở duyệt gia hạn");
				 $(".status_approve_gh").val(25);
			    }
				$(".error_code_contract").hide();
				$("#approve_note_gh").val("");
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_gh").val(data.data.status);
				
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
					
				if (  data.data.status==17 || data.logs.type_gh_cc=="TPGD") {
				
					$('.cancel_submit_gh').hide();
				    $('.return_submit_gh').hide();
				}
			
				var content = "";
				if(typeof data.logs.new != 'undefined' && data.data.status!=17){
					$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				}
				
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
				
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function gui_thn_duyet_gia_han(thiz, is_cvkd) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_gh").text("Gửi TP QLHDV duyệt gia hạn");
				$(".status_approve_gh").val(11);
				$(".status_contract_gh").val(data.data.status);
				$(".error_code_contract").hide();
				$("#approve_note_gh").val("");
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$("#exception_gh").val(data.logs.new.exception);
				if (!is_cvkd) {
					$('#number_day_loan_gh').attr('disabled', true);
					$('#exception_gh').attr('disabled', true);
					$('#addup_gh').empty();

				}else{
					$('.cancel_submit_gh').hide();
				    $('.return_submit_gh').hide();
				}
				
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
				
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}

function gui_ke_toan_duyet_gia_han(thiz, is_cvkd) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_gh").text("Gửi kế toán duyệt gia hạn");
				$(".status_approve_gh").val(29);
				$(".error_code_contract").hide();
				$("#approve_note_gh").val("");
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_gh").val(data.data.status);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$("#exception_gh").val(data.logs.new.exception);
				if (!is_cvkd) {
					$('#number_day_loan_gh').attr('disabled', true);
					$('#exception_gh').attr('disabled', true);
					$('#addup_gh').empty();

				}else{
					$('.cancel_submit_gh').hide();
				    $('.return_submit_gh').hide();
				}
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
				
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function asm_duyet_gia_han(thiz) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				
				
			    var count_extent=(data.data.count_extension!=undefined) ? data.data.count_extension : 0;
			 //    if(data.logs.new.number_day_loan==1 && data.data.debt.so_ngay_cham_tra < 4 && count_extent <2)
				// {
				// $(".title_modal_approve_gh").text("Duyệt gia hạn");
				// $(".status_approve_gh").val(29);
			 //    }
			 //    if((data.logs.new.number_day_loan > 1 && data.data.debt.so_ngay_cham_tra < 4)  || count_extent >=2)
			 //    {
    //               $(".title_modal_approve_gh").text("Gửi hội sở duyệt gia hạn");
				// $(".status_approve_gh").val(25);
			 //    }
			 //    if(data.logs.new.number_day_loan > 1 && data.data.debt.so_ngay_cham_tra >= 4)
			 //    {
                 $(".title_modal_approve_gh").text("Gửi trưởng phòng QLHDV duyệt gia hạn");
				 $(".status_approve_gh").val(11);
			 //    }
			 //    if(data.logs.new.number_day_loan==1 && data.data.debt.so_ngay_cham_tra >= 4)
				// {
				//  $(".title_modal_approve_gh").text("Gửi trưởng phòng thu hồi  duyệt gia hạn");
				//  $(".status_approve_gh").val(11);
			 //    }

				$(".error_code_contract").hide();
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_gh").val(data.data.status);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);
				$("#approve_note_gh").val("");
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$('#number_day_loan_gh').attr('disabled', true);
				$('#exception_gh').attr('disabled', true);
				$('#addup_gh').empty();
				$('.approve_submit_gh').text("Duyệt");
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery">';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
				
				if (data.data.debt.check_tt_gh == 1) {
					$('.approve_submit_gh').prop('disabled', false);
				}
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function hoi_so_duyet_gia_han(thiz) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_gh").text("Hội sở duyệt gia hạn");
				$(".status_approve_gh").val(29);
				$(".error_code_contract").hide();
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_gh").val(data.data.status);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);
				$("#approve_note_gh").val("");
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$('#number_day_loan_gh').attr('disabled', true);
				$('#exception_gh').attr('disabled', true);
				$('#addup_gh').empty();
				$('.approve_submit_gh').text("Duyệt");
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery">';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
			
				if (data.data.debt.check_tt_gh == 1) {
					$('.approve_submit_gh').prop('disabled', false);
				}
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function tp_thn_duyet_gia_han(thiz) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				
				

			  
			      $(".title_modal_approve_gh").text("Duyệt gia hạn");
				$(".status_approve_gh").val(29);
				
			    
			    
                
				$(".error_code_contract").hide();
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_gh").val(data.data.status);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);
				$("#approve_note_gh").val("");
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$('#number_day_loan_gh').attr('disabled', true);
				$('#exception_gh').attr('disabled', true);
				
				$('.approve_submit_gh').text("Duyệt");
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery">';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);
			
				if (data.data.debt.check_tt_gh == 1) {
					$('.approve_submit_gh').prop('disabled', false);
				}
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function thn_duyet_gia_han(thiz) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_gh",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$("#gh_ma_hop_dong").empty();
				$("#gh_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				
				

			   
                $(".title_modal_approve_gh").text("Gửi trưởng phòng QLHDV duyệt gia hạn");
				$(".status_approve_gh").val(11);
			    
			   
					$('.cancel_submit_gh').hide();
				    $('.return_submit_gh').hide();
				$(".error_code_contract").hide();
				$(".contract_id_gh").val(contract_id);
				$("#xem_chi_tiet_gia_han").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				 var content = "";
				if(data.data.status!=17)
				{
				$(".status_contract_gh").val(data.data.status);
				$("#number_day_loan_gh").val(data.logs.new.number_day_loan);
				$("#exception_gh").val(data.logs.new.exception);

				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img  style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
			    }
				$("#approve_note_gh").val("");
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				
				
				$('.approve_submit_gh').text("Duyệt");
				
			    

				$('#uploads_img_file_gh').empty();
				$('#uploads_img_file_gh').append(content);

				
				
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});

	$("#giahanhopdongModal").modal("show");
}
function hoi_so_duyet_co_cau(thiz) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_cc").text("Hội sở duyệt cơ cấu");
				$(".status_approve_cc").val(31);
				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#amount_debt_cc").val(numeral(data.tien_phai_tra-data.logs.new.amount_money).format('0,0'));
				$(".amount_debt_cc").val(numeral(data.tien_phai_tra-data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
				$("#type_interest_cc").val(data.logs.new.type_interest);
				$("#approve_note_cc").val("");
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$('#type_loan_cc').attr('disabled', true);
				$('#amount_money_cc').attr('disabled', true);
				$('#type_interest_cc').attr('disabled', true);
				$('#number_day_loan_cc').attr('disabled', true);
				$('#exception_cc').attr('disabled', true);
				$('#addup_cc').empty();
				$('.approve_submit_cc').text("Duyệt");
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery">';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				//$(".approve_submit_cc").attr('disabled', false);
				// if ((data.tien_phai_tra-data.logs.new.amount_money)>0) {
				// 	$(".text_waring_gh_cc").text("Khách hàng chưa đóng đủ tiền thanh toán để cơ cấu");
				// 	$(".link_payment_gh_cc").text("Đi đến trang thanh toán");
				// 	$(".link_payment_gh_cc").attr("href", _url.base_url + "/accountant/view?id=" + contract_id);
				// 	$(".warning_send_gh_cc").show();
				// 	$(".approve_submit_cc").attr('disabled', true);
				// } 
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
}
function asm_duyet_co_cau(thiz) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				var count_structure=(data.data.count_structure!=undefined) ? data.data.count_structure : 0;
				// if(data.logs.new.number_day_loan==1 && data.data.debt.so_ngay_cham_tra < 4  && count_structure <2)
				// {
				// $(".title_modal_approve_cc").text("Duyệt cơ cấu");
				// $(".status_approve_cc").val(31);
			 //    }
			 //     if(data.logs.new.number_day_loan == 1 && data.data.debt.so_ngay_cham_tra >= 4)
			 //    {
                 $(".title_modal_approve_cc").text("Gửi trưởng phòng QLHDV duyệt cơ cấu");
				 $(".status_approve_cc").val(12);
			 //    }

			 //    if((data.logs.new.number_day_loan > 1 && data.data.debt.so_ngay_cham_tra < 4)  || count_structure >=2)
			 //    {
    //             $(".title_modal_approve_cc").text("Gửi hội sở duyệt cơ cấu");
				// $(".status_approve_cc").val(27);
			 //    }
			 //    if(data.logs.new.number_day_loan > 1 && data.data.debt.so_ngay_cham_tra >= 4)
			 //    {
    //              $(".title_modal_approve_cc").text("Gửi trưởng phòng thu hồi  duyệt cơ cấu");
				//  $(".status_approve_cc").val(12);
			 //    }

				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#amount_debt_cc").val(numeral(data.tien_phai_tra-data.logs.new.amount_money).format('0,0'));
				$(".amount_debt_cc").val(numeral(data.tien_phai_tra-data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
				$("#type_interest_cc").val(data.logs.new.type_interest);
				$("#approve_note_cc").val("");
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$('#type_loan_cc').attr('disabled', true);
				$('#amount_money_cc').attr('disabled', true);
				$('#type_interest_cc').attr('disabled', true);
				$('#number_day_loan_cc').attr('disabled', true);
				$('#exception_cc').attr('disabled', true);
				$('#addup_cc').empty();
				$('.approve_submit_cc').text("Duyệt");
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery">';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				//$(".approve_submit_cc").attr('disabled', false);
				// if ((data.tien_phai_tra-data.logs.new.amount_money)>0) {
				// 	$(".text_waring_gh_cc").text("Khách hàng chưa đóng đủ tiền thanh toán để cơ cấu");
				// 	$(".link_payment_gh_cc").text("Đi đến trang thanh toán");
				// 	$(".link_payment_gh_cc").attr("href", _url.base_url + "/accountant/view?id=" + contract_id);
				// 	$(".warning_send_gh_cc").show();
				// 	$(".approve_submit_cc").attr('disabled', true);
				// } 
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
}
function gui_thn_duyet_co_cau(thiz, is_cvkd) {
	$(".warning_send_gh_cc").hide();
	let contract_id = $(thiz).data("id");

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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_cc").text("Trưởng phòng QLHDV duyệt cơ cấu");
				$(".status_approve_cc").val(12);
				$(".error_code_contract").hide();
				$("#approve_note_cc").val("");
				$(".contract_id_cc").val(contract_id);
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#type_interest_cc").val(data.logs.new.type_interest);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#amount_debt_cc").val(numeral(data.tien_phai_tra-data.logs.new.amount_money).format('0,0'));
				$(".amount_debt_cc").val(numeral(data.tien_phai_tra-data.logs.new.amount_money).format('0,0'));
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$("#exception_cc").val(data.logs.new.exception);
				if (!is_cvkd) {
					$('#type_loan_cc').attr('disabled', true);
					$('#amount_money_cc').attr('disabled', true);
					$('#number_day_loan_cc').attr('disabled', true);
					$('#exception_cc').attr('disabled', true);
					$('#type_interest_cc').attr('disabled', true);
					$('#addup_cc').empty();

				}else{
					$('.cancel_submit_cc').hide();
				    $('.return_submit_cc').hide();
				}
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				// if ((data.tien_phai_tra-data.logs.new.amount_money)>0) {
				// 	$(".text_waring_gh_cc").text("Khách hàng chưa đóng đủ tiền thanh toán để cơ cấu");
				// 	$(".link_payment_gh_cc").text("Đi đến trang thanh toán");
				// 	$(".link_payment_gh_cc").attr("href", _url.base_url + "/accountant/view?id=" + contract_id);
				// 	$(".warning_send_gh_cc").show();
					
				// } 
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
}

function gui_tpgd_duyet_co_cau(thiz) {
	let contract_id = $(thiz).data("id");
	$(".warning_send_gh_cc").hide();
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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_cc").text("Gửi trưởng phòng giao dịch duyệt cơ cấu");
				$(".status_approve_cc").val(23);
				$('.cancel_submit_cc').hide();
				$('.return_submit_cc').hide();
				$("#approve_note_cc").val("");
                 $("#amount_debt_cc").val(numeral(data.tien_phai_tra).format('0,0'));
                 $(".amount_debt_cc").val(numeral(data.tien_phai_tra).format('0,0'));
				$(".error_code_contract").hide();
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$(".contract_id_cc").val(contract_id);
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				if(typeof data.logs.new != 'undefined' && data.data.status!=17){
				$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
			    $("#type_interest_cc").val(data.logs.new.type_interest);
			    var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
			   }
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
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
}

function gui_hs_duyet_co_cau(thiz, is_cvkd) {

	let contract_id = $(thiz).data("id");
	$(".warning_send_gh_cc").hide();
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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_cc").text("Gửi hội sở duyệt cơ cấu");
				$(".status_approve_cc").val(27);
				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#approve_note_cc").val("");
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
			    $("#type_interest_cc").val(data.logs.new.type_interest);
				if (!is_cvkd) {
					$('#type_loan_cc').attr('disabled', true);
					$('#amount_money_cc').attr('disabled', true);
					$('#number_day_loan_cc').attr('disabled', true);
					$('#exception_cc').attr('disabled', true);
					$('#type_interest_cc').attr('disabled', true);
					$('#addup_cc').empty();

				}else{
					$('.cancel_submit_cc').hide();
				    $('.return_submit_cc').hide();
				}
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				

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
}
function tp_thn_duyet_co_cau(thiz, is_cvkd) {

	let contract_id = $(thiz).data("id");
	$(".warning_send_gh_cc").hide();
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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				
			    

			  
                 $(".title_modal_approve_cc").text("Duyệt cơ cấu");
				$(".status_approve_cc").val(31);

			    
			    
				
				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#approve_note_cc").val("");
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
			    $("#type_interest_cc").val(data.logs.new.type_interest);
				if (!is_cvkd) {
					$('#type_loan_cc').attr('disabled', true);
					$('#amount_money_cc').attr('disabled', true);
					$('#number_day_loan_cc').attr('disabled', true);
					$('#exception_cc').attr('disabled', true);
					$('#type_interest_cc').attr('disabled', true);
					

				}else{
					$('.cancel_submit_cc').hide();
				    $('.return_submit_cc').hide();
				}
				var content = "";
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				

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
}
function thn_duyet_co_cau(thiz) {

	let contract_id = $(thiz).data("id");
	$(".warning_send_gh_cc").hide();
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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				
			   
                $(".title_modal_approve_cc").text("Gửi trưởng phòng QLHDV duyệt cơ cấu");
				$(".status_approve_cc").val(12);
			    
			    

				
				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#approve_note_cc").val("");
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				
				
					$('.cancel_submit_cc').hide();
				    $('.return_submit_cc').hide();
				
				 var content = "";
				if(data.data.status!=17)
				{
					$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
			    $("#type_interest_cc").val(data.logs.new.type_interest);
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img  style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
			   }
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				

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
}

function gui_asm_duyet_co_cau(thiz, is_cvkd) {

	let contract_id = $(thiz).data("id");
	$(".warning_send_gh_cc").hide();
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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				$(".title_modal_approve_cc").text("Gửi ASM duyệt cơ cấu");
				$(".status_approve_cc").val(32);
				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#approve_note_cc").val("");
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
			    $("#type_interest_cc").val(data.logs.new.type_interest);
				if (!is_cvkd) {
					$('#type_loan_cc').attr('disabled', true);
					$('#amount_money_cc').attr('disabled', true);
					$('#number_day_loan_cc').attr('disabled', true);
					$('#exception_cc').attr('disabled', true);
					$('#type_interest_cc').attr('disabled', true);
					$('#addup_cc').empty();

				}else{
					$('.cancel_submit_cc').hide();
				    $('.return_submit_cc').hide();
				}
				var content = "";
				for (x in data.logs.new.image_file) {
					console.log(data.logs.new.image_file)
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}

				}
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				

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
}
function tpgd_gui_duyet_co_cau(thiz, is_cvkd) {

	let contract_id = $(thiz).data("id");
	$(".warning_send_gh_cc").hide();
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
				$("#cc_ma_hop_dong").append("<a target='_blank' href='" + _url.base_url + "/pawn/detail?id=" + contract_id + "#hoat_dong'>" + data.data.code_contract_disbursement + "</a>");
				$("#cc_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#cc_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#cc_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#cc_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#cc_thoi_gian_vay").text((data.data.loan_infor.number_day_loan / 30) + ' tháng');
				 $(".title_modal_approve_cc").text("Gửi ASM duyệt cơ cấu");
				 $(".status_approve_cc").val(32);
				 if(data.data.status==17)
				{
				 $(".title_modal_approve_cc").text("Gửi ASM duyệt cơ cấu");
				 $(".status_approve_cc").val(32);
			    }
			    if(data.data.status==42 || data.data.status==23)
				{
				 $(".title_modal_approve_cc").text("Gửi ASM duyệt cơ cấu");
				 $(".status_approve_cc").val(32);
			    }
			     if(data.data.status==14)
				{
				 $(".title_modal_approve_cc").text("Gửi TP THN duyệt cơ cấu");
				 $(".status_approve_cc").val(12);
			    }
			     if(data.data.status==28)
				{
				 $(".title_modal_approve_cc").text("Gửi hội sở duyệt cơ cấu");
				 $(".status_approve_cc").val(27);
			    }
				$(".error_code_contract").hide();
				$(".contract_id_cc").val(contract_id);
				$("#approve_note_cc").val("");
				$("#xem_chi_tiet_co_cau").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id);
				$(".status_contract_cc").val(data.data.status);
				$(".lich_su_hoat_dong_gh_cc").attr("href", _url.base_url + "/pawn/detail?id=" + contract_id + '#hoat_dong');
				
				if (  data.data.status==17 || data.logs.type_gh_cc=="TPGD") {
				
					$('.cancel_submit_cc').hide();
				    $('.return_submit_cc').hide();
				}
				var content = "";
				if(typeof data.logs.new != 'undefined' && data.data.status!=17){
					$("#type_loan_cc").val(data.logs.new.type_loan);
				$("#number_day_loan_cc").val(data.logs.new.number_day_loan);
				$("#amount_money_cc").val(numeral(data.logs.new.amount_money).format('0,0'));
				$("#exception_cc").val(data.logs.new.exception);
			    $("#type_interest_cc").val(data.logs.new.type_interest);
				for (x in data.logs.new.image_file) {
					if (data.logs.new.image_file[x]['file_type'] == "application/pdf" ){
						content += '<div class="block"><a target="_blank" href="' + data.logs.new.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.logs.new.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.logs.new.image_file[x]['file_type'] + '"  data-fileName="' + data.logs.new.image_file[x]['file_name'] + '" name="img_file"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}

				}
			}
				$('#uploads_img_file_cc').empty();
				$('#uploads_img_file_cc').append(content);
				

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
}


function gui_cht_duyet(thiz) {
	$(".title_modal_approve").text("Gửi Trưởng PGD duyệt");
	$(".status_approve").val(2);
	$(".error_code_contract").hide();
	$(".img_return_file").hide();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function yeu_cau_giai_ngan(thiz) {
	$(".title_modal_approve").text("Yêu cầu giải ngân");
	let code_contract_disbursement = $(thiz).data("codecontract");
	console.log(code_contract_disbursement.length);

	if (code_contract_disbursement.length != 0) {
		$("input[name='code_contract_disbursement_approve']").val(code_contract_disbursement);
		$('input[name="code_contract_disbursement_approve"]').prop("disabled", true);
		$(".code_contract_disbursement_type").val(1);

	}

	$(".status_approve").val(15);
	$(".error_code_contract").hide();
	$(".img_return_file").hide();
	$(".code_contract_approve").show();
	let contract_id = $(thiz).data("id");

	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function cht_tu_choi(thiz) {
	$(".title_modal_approve").text("Trưởng PGD từ chối");
	$(".status_approve").val(4);
	$(".error_code_contract").hide();
	$(".img_return_file").hide();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

// khong chuyen len hs nua mà chuyen len asm duyet
// status = 35 cho asm duyet
// function chuyen_asm_duyet(thiz) {
// 	$(".title_modal_approve").text("Chuyển lên ASM duyệt");
// 	$(".status_approve").val(35);
// 	$(".error_code_contract").hide();
// 	$(".img_return_file").show();
// 	let contract_id = $(thiz).data("id");
// 	$(".contract_id").val(contract_id);
// 	$("#approve").modal("show");
// }

// chuyển từ Trưởng PGD lên Hội sở duyệt
function chuyen_hoiso_duyet(thiz) {
	$(".title_modal_approve").text("Chuyển lên Hội Sở duyệt");
	$(".status_approve").val(5);
	$(".error_code_contract").hide();
	$(".img_return_file").show();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function fee_gic() {
	tilekhoanvay = getFloat($('.tilekhoanvay').val());
	money = getFloat($('.amount_money').val());
	number_month_loan = getFloat($("input[name='number_month_loan']").val());
	user_nextpay = $('#user_nextpay').val() !== undefined ? $('#user_nextpay').val() : 0;
	if(user_nextpay == 1){
		if(number_month_loan == 1 || number_month_loan == 3){
			fee_gi = Number((Number(money) * 100) / 100) * 1 / 100;
		}else {
			fee_gi = Number((Number(money) * 100) / 100) * 5 / 100;
		}
	}else {
		if (number_month_loan <= 12) {
			// 0.05 (5%) * money
			fee_gi = Number((Number(money) * 200) / 100) * (tilekhoanvay) / 100;
		} else {
			// 0.056 (6%) * money
			fee_gi = Number((Number(money) * 120) / 100) * (tilekhoanvay) * 2 / 100;
		}
	}
	fee = numeral(fee_gi).format('0,0');
	return fee
}

function amount_loan() {

	money = getFloat($('.amount_money').val());
	money_gic = getFloat($('.fee_gic').val());
	money_vbi = getFloat($('.fee_vbi').val());
	money_gic_easy = getFloat($('.fee_gic_easy').val());
	money_gic_plt = getFloat($('.fee_gic_plt').val());
	phi_tnds = getFloat($('.phi_tnds').val());
	phi_pti_vta = getFloat($('.phi_pti_vta').val());
	phi_pti_bhtn = getFloat($('#pti_bhtn_fee').val());
	total = Number(money - money_gic - money_gic_easy - money_gic_plt - money_vbi-phi_tnds-phi_pti_vta-phi_pti_bhtn);
	fee = numeral(total).format('0,0');
	return fee
}

function fee_mic() {
	var fee = 0;
	var money = getFloat($('.amount_money').val());
	var month = getFloat($("input[name='number_month_loan']").val());
	var user_nextpay = $('#user_nextpay').val() !== undefined ? $('#user_nextpay').val() : 0;
	var formData = {
		money: money
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
				$('.fee_gic').val(fee);
				$('.amount_loan').val(amount_loan());
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

function hsduyet(thiz) {
	$(".title_modal_approve").text("Hội sở duyệt");
	$(".status_approve").val(6);
	$(".error_code_contract").hide();
	$(".img_return_file").hide();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
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
			console.log(data.data);
			var money_gic = (data.data.loan_infor.amount_GIC == undefined) ? 0 : data.data.loan_infor.amount_GIC;
			var money_mic = (data.data.loan_infor.amount_MIC == undefined) ? 0 : data.data.loan_infor.amount_MIC;
			var loan_insurance = (data.data.loan_infor.loan_insurance == undefined) ? '1' : data.data.loan_infor.loan_insurance;
			var money_gic_easy = (data.data.loan_infor.amount_GIC_easy == undefined) ? 0 : data.data.loan_infor.amount_GIC_easy;
			var amount_GIC_plt = (data.data.loan_infor.amount_GIC_plt == undefined) ? 0 : data.data.loan_infor.amount_GIC_plt;
			var amount_vbi = (data.data.loan_infor.amount_VBI == undefined) ? 0 : data.data.loan_infor.amount_VBI;

            var phi_tnds = (data.data.loan_infor.bao_hiem_tnds == undefined) ? 0 : data.data.loan_infor.bao_hiem_tnds.price_tnds;
            var phi_pti_vta = (data.data.loan_infor.bao_hiem_pti_vta == undefined) ? 0 : data.data.loan_infor.bao_hiem_pti_vta.price_pti_vta;

			if (data.code == 200) {
				$("input[name='number_month_loan']").val(Number(data.data.loan_infor.number_day_loan / 30));
				$(".amount_money_max").val(numeral(data.data.loan_infor.amount_money_max).format('0,0'));
				$(".amount_loan").val(numeral(data.data.loan_infor.amount_loan).format('0,0'));
				if (loan_insurance == '1') {
					$(".fee_gic").val(numeral(money_gic).format('0,0'));
				}
				if (loan_insurance == '2') {
					$(".fee_gic").val(numeral(money_mic).format('0,0'));
				}
				$(".fee_gic_plt").val(numeral(amount_GIC_plt).format('0,0'));
				$(".fee_vbi").val(numeral(amount_vbi).format('0,0'));
				$(".fee_gic_easy").val(numeral(money_gic_easy).format('0,0'));
				$(".phi_tnds").val(numeral(phi_tnds).format('0,0'));
				$(".amount_money").val(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$(".phi_tnds").val(numeral(phi_tnds).format('0,0'));
				$(".phi_pti_vta").val(numeral(phi_pti_vta).format('0,0'));
				$("#insurrance_contract").val(data.data.loan_infor.insurrance_contract);
				$("#loan_insurance").val(data.data.loan_infor.loan_insurance);
				// $("#pti_bhtn_fee").val(data.data.loan_infor.pti_bhtn.phi);
				$("#hsduyet").modal("show");

			} else {
				$("#hsduyet").modal("show");
			}
		},
		error: function (error) {
			console.log(error);
		}
	})

}

function hoi_so_khong_duyet(thiz) {
	$(".title_modal_approve").text("Hội sở không duyệt hợp đồng");
	$(".status_approve").val(8);
	$(".error_code_contract").show();
	$(".img_return_file").show();
	$(".cancel-B").hide();
	$(".cancel-C").hide();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function hsduyetgiahan(thiz) {
	let contract_id = $(thiz).data("id");
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
				$("#gh_ma_hop_dong").text(data.data.code_contract_disbursement);
				$("#gh_hinh_thuc_vay").text(data.data.loan_infor.type_loan.text);
				$("#gh_loai_tai_san").text(data.data.loan_infor.type_property.text);
				$("#gh_so_tien_duoc_vay").text(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#gh_hinh_thuc_tra_lai").text(get_type_interest(data.data.loan_infor.type_interest));
				$("#gh_thoi_gian_vay").text(data.data.loan_infor.number_day_loan / 30);
				$(".title_modal_approve_gh").text("Hội sở duyệt gia hạn");
				$(".status_approve_gh").val(25);
				let contract_id = $(thiz).data("id");
				$(".contract_id_gh").val(contract_id);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function (error) {
			console.log(error);
		}
	});
	$("#giahanhopdongModal").modal("show");
}

function hshuygiahan(thiz) {
	$(".title_modal_approve").text("Hội sở hủy gia hạn");
	$(".status_approve").val(17);
	let contract_id = $(thiz).data("id");
	$(".error_code_contract").show();
	$(".img_return_file").hide();
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function kthuygiahan(thiz) {
	$(".title_modal_approve").text("Kế toán hủy gia hạn");
	$(".status_approve").val(17);
	let contract_id = $(thiz).data("id");
	$(".error_code_contract").show();
	$(".img_return_file").hide();
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function ketoan_tu_choi(thiz) {
	$(".title_modal_approve").text("Kế toán từ chối");
	$(".status_approve").val(7);
	let contract_id = $(thiz).data("id");
	$(".error_code_contract").show();
	$(".error_code_contract_kt").show();
	$(".img_return_file").hide();
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function huy_hop_dong(thiz) {
	$(".title_modal_approve").text("Hủy hợp đồng");
	$(".status_approve").val(3);
	$(".error_code_contract").hide();
	$(".code_contract_approve").hide();
	$(".img_return_file").hide();
	$(".cancel-C").show();
	$(".cancel-B").show();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function ktduyetgiahan(thiz) {
	let contract_id = $(thiz).data("id");
	$(".title_modal_approve").text("Kế toán duyệt gia hạn");
	$(".error_code_contract").hide();
	$(".contract_id_extension").val(contract_id);
	$("#extension").modal("show");
}

function capnhatmahopdong(thiz) {
	let contract_id = $(thiz).data("id");
	let code_contract = $(thiz).data("code");
	$(".title_modal_approve").text("Sửa mã hợp đồng với mã phiếu ghi:" + code_contract);
	$(".error_code_contract").hide();
	$(".contract_id_update").val(contract_id);
	$("#update_code_contract_disbursement").modal("show");
}

$('#error_code').selectize({
	create: false,
	valueField: 'error_code',
	labelField: 'name1',
	searchField: 'name1',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('[name="error_code[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#error_code').val();
	var data = [];
	if (value != null) {
		data.push(value);
	}
	$('#error_code1').val(JSON.stringify(data));
})


$(".approve_submit").on("click", function () {
	var note = $(".approve_note").val();
	var status = $(".status_approve").val();
	var id = $(".contract_id").val();
	var id_oid = $("#id_oid").val();
	var loan_insurance = $('#loan_insurance').val();
	var approve_reason_hs = $('.approve_reason_hs').val();
	var amount_money = 0;
	var amount_loan = 0;
	var amount_GIC = 0;
	if (($('#error_code1').val()) != "") {
		var error_code = JSON.parse($('#error_code1').val());
	}

	var codeContractDisbursement = "";
	var codeContractDisbursementType = "";
	var count = $("img[name='img_file']").length;
	var image_file = {};

	if ($('#lead_cancel1_C1').val() != "") {
		var lead_cancel1_C1 = JSON.parse($('#lead_cancel1_C1').val());
	}
	if ($('#lead_cancel1_C2').val() != "") {
		var lead_cancel1_C2 = JSON.parse($('#lead_cancel1_C2').val());
	}
	if ($('#lead_cancel1_C3').val() != "") {
		var lead_cancel1_C3 = JSON.parse($('#lead_cancel1_C3').val());
	}
	if ($('#lead_cancel1_C4').val() != "") {
		var lead_cancel1_C4 = JSON.parse($('#lead_cancel1_C4').val());
	}
	if ($('#lead_cancel1_C5').val() != "") {
		var lead_cancel1_C5 = JSON.parse($('#lead_cancel1_C5').val());
	}
	if ($('#lead_cancel1_C6').val() != "") {
		var lead_cancel1_C6 = JSON.parse($('#lead_cancel1_C6').val());
	}
	if ($('#lead_cancel1_C7').val() != "") {
		var lead_cancel1_C7 = JSON.parse($('#lead_cancel1_C7').val());
	}

	// if ($('#exception1_value_detail').val() != "") {
	// 	var exception1_value_detail = JSON.parse($('#exception1_value_detail').val());
	//
	// }
	// if ($('#exception2_value_detail').val() != "") {
	// 	var exception2_value_detail = JSON.parse($('#exception2_value_detail').val());
	//
	// }
	// if ($('#exception3_value_detail').val() != "") {
	// 	var exception3_value_detail = JSON.parse($('#exception3_value_detail').val());
	//
	// }
	// if ($('#exception4_value_detail').val() != "") {
	// 	var exception4_value_detail = JSON.parse($('#exception4_value_detail').val());
	//
	// }
	//
	// if ($('#exception5_value_detail').val() != "") {
	// 	var exception5_value_detail = JSON.parse($('#exception5_value_detail').val());
	//
	// }
	//
	// if ($('#exception6_value_detail').val() != "") {
	// 	var exception6_value_detail = JSON.parse($('#exception6_value_detail').val());
	//
	// }
	// if ($('#exception7_value_detail').val() != "") {
	// 	var exception7_value_detail = JSON.parse($('#exception7_value_detail').val());
	//
	// }
	if ($("input[name='so_tien_vay_asm_de_xuat']").val() != "") {
		var so_tien_vay_asm_de_xuat = $("input[name='so_tien_vay_asm_de_xuat']").val();
	}
	if ($("input[name='so_tien_vay_asm_de_xuat']").val() != "") {
		var ki_han_vay_asm_de_xuat = $("input[name='ki_han_vay_asm_de_xuat']").val();
	}

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
	console.log(image_file);
	if (status == 3) {
		if (($('#lead_cancel1_C1').val()) != "") {
			lead_cancel1_C1 = JSON.parse($('#lead_cancel1_C1').val());
		}
		if (($('#lead_cancel1_C2').val()) != "") {
			lead_cancel1_C2 = JSON.parse($('#lead_cancel1_C2').val());
		}
		if (($('#lead_cancel1_C3').val()) != "") {
			lead_cancel1_C3 = JSON.parse($('#lead_cancel1_C3').val());
		}
		if (($('#lead_cancel1_C4').val()) != "") {
			lead_cancel1_C4 = JSON.parse($('#lead_cancel1_C4').val());
		}
		if (($('#lead_cancel1_C5').val()) != "") {
			lead_cancel1_C5 = JSON.parse($('#lead_cancel1_C5').val());
		}
		if (($('#lead_cancel1_C6').val()) != "") {
			lead_cancel1_C6 = JSON.parse($('#lead_cancel1_C6').val());
		}
		if (($('#lead_cancel1_C7').val()) != "") {
			lead_cancel1_C7 = JSON.parse($('#lead_cancel1_C7').val());
		}

	}
	if (status == 7 || status == 8) {
		// error_code = $("select[name='error_code']").val();
		if (($('#error_code1').val()) != "") {
			error_code = JSON.parse($('#error_code1').val());
			id_oid = $("#id_oid").val();
		}
	}

	if (status == 6) {
		amount_money = getFloat($(".amount_money").val());
		amount_loan = getFloat($(".amount_loan").val());
		amount_GIC = getFloat($(".fee_gic").val());
		let phi_pti_bhtn = parseInt(getFloat($('#pti_bhtn_fee').val()));
		if (pti_bhtn_fee && pti_bhtn_fee > 0) {
			if (amount_money >= 7000000 && amount_money < 15000000 && phi_pti_bhtn < 240000) {
				alert("Khoản vay 7-15tr phải mua bảo hiểm PTI-BHTN từ gói 30tr trở lên.");
				return;
			} else if (amount_money >= 15000000 && amount_money < 25000000 && phi_pti_bhtn < 280000) {
				alert("Khoản vay 15-25tr phải mua bảo hiểm PTI-BHTN từ gói 50tr trở lên.");
				return;
			} else if (amount_money >= 25000000 && phi_pti_bhtn < 370000) {
				alert("Khoản vay từ 25tr phải mua bảo hiểm PTI-BHTN từ gói 100tr trở lên.");
				return;
			}
		}
		note = $(".approve_note_hs").val();
		approve_reason_hs = $(".approve_reason_hs").val();

		if ($('#exception1_value_detail').val() != "") {
			var exception1_value_detail = JSON.parse($('#exception1_value_detail').val());

		}
		if ($('#exception2_value_detail').val() != "") {
			var exception2_value_detail = JSON.parse($('#exception2_value_detail').val());

		}
		if ($('#exception3_value_detail').val() != "") {
			var exception3_value_detail = JSON.parse($('#exception3_value_detail').val());

		}
		if ($('#exception4_value_detail').val() != "") {
			var exception4_value_detail = JSON.parse($('#exception4_value_detail').val());

		}
		if ($('#exception5_value_detail').val() != "") {
			var exception5_value_detail = JSON.parse($('#exception5_value_detail').val());

		}
		if ($('#exception6_value_detail').val() != "") {
			var exception6_value_detail = JSON.parse($('#exception6_value_detail').val());

		}
		if ($('#exception7_value_detail').val() != "") {
			var exception7_value_detail = JSON.parse($('#exception7_value_detail').val());

		}


	}
	if (status == 15) {
		codeContractDisbursement = $("input[name='code_contract_disbursement_approve']").val();
		codeContractDisbursementType = $(".code_contract_disbursement_type").val();
	}

	if (status == "") {
		note = $(".approve_note_hs").val();
	}

	if (status == 5){
		var so_tien_vay_asm_de_xuat = " ";
		var ki_han_vay_asm_de_xuat = " ";
	}

	var formData = {
		note: note,
		status: status,
		id: id,
		id_oid: id_oid,
		approve_reason_hs: approve_reason_hs,
		error_code: error_code,
		amount_money: amount_money,
		amount_loan: amount_loan,
		amount_GIC: amount_GIC,
		loan_insurance: loan_insurance,
		code_contract_disbursement: codeContractDisbursement,
		codeContractDisbursementType: codeContractDisbursementType,
		image_file: image_file,
		lead_cancel1_C1: lead_cancel1_C1,
		lead_cancel1_C2: lead_cancel1_C2,
		lead_cancel1_C3: lead_cancel1_C3,
		lead_cancel1_C4: lead_cancel1_C4,
		lead_cancel1_C5: lead_cancel1_C5,
		lead_cancel1_C6: lead_cancel1_C6,
		lead_cancel1_C7: lead_cancel1_C7,
		exception1_value_detail: exception1_value_detail,
		exception2_value_detail: exception2_value_detail,
		exception3_value_detail: exception3_value_detail,
		exception4_value_detail: exception4_value_detail,
		exception5_value_detail: exception5_value_detail,
		exception6_value_detail: exception6_value_detail,
		exception7_value_detail: exception7_value_detail,
		so_tien_vay_asm_de_xuat: so_tien_vay_asm_de_xuat,
		ki_han_vay_asm_de_xuat: ki_han_vay_asm_de_xuat,

	};
	$("#approve").modal("hide");
	$("#hsduyet").modal("hide");
	$(".code_contract_approve").hide();

	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/approveContract",
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
					// window.location.reload();
					window.location.href = _url.base_url + 'pawn/contract';
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$(".approve_submit_gh").on("click", function () {
	var note = $("#approve_note_gh").val();
	var status = $(".status_approve_gh").val();
	var contractId = $(".contract_id_gh").val();
	var exception = $("#exception_gh").val();

	var number_day_loan = $("#number_day_loan_gh").val();
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

	var formData = {
		note: note,
		status: status,
		contractId: contractId,
		exception: exception,
		image_file: image_file,
		number_day_loan: number_day_loan,

	};
	var link = "";
	if (status == 21 || status == 25 || status == 29 || status == 11 || status == 30) {
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
				setTimeout(function(){
				    window.location.reload();
				}, 3000);
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

	var amount_money = getFloat($("#amount_money_cc").val());
	var number_day_loan = $("#number_day_loan_cc").val();
	var type_loan = $("#type_loan_cc").val();
	var type_interest = $("#type_interest_cc").val();
	var amount_debt_cc = $("#amount_debt_cc").val();
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
	if (status == 23 || status == 27 || status == 31 || status == 12 || status == 32) {
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
		amount_debt_cc: amount_debt_cc,


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
$(".return_submit_gh").on("click", function () {
	var note = $("#approve_note_gh").val();
	var status = $(".status_approve_gh").val();
	var contractId = $(".contract_id_gh").val();
	var exception = $("#exception_gh").val();
	var status_contract = $(".status_contract_gh").val();
	var number_day_loan = $("#number_day_loan_gh").val();
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

	if (status_contract == 21) {
		status = 22;
	}
	if (status_contract == 25) {
		status = 26;
	}
	if (status_contract == 11) {
		status = 13;
	}
	if (status_contract == 30) {
		status = 41;
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

	link = _url.base_url + "pawn/request_exten";
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
$(".return_submit_cc").on("click", function () {
	var note = $("#approve_note_cc").val();
	var status = $(".status_approve_cc").val();
	var status_contract = $(".status_contract_cc").val();
	var contractId = $(".contract_id_cc").val();
	var exception = $("#exception_cc").val();

	var amount_money = getFloat($("#amount_money_cc").val());
	var number_day_loan = $("#number_day_loan_cc").val();
	var type_loan = $("#type_loan_cc").val();

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

	if (status_contract == 23) {
		status = 24;
	}
	if (status_contract == 27) {
		status = 28;
	}
	if (status_contract == 12) {
		status = 14;
	}
	if (status_contract == 32) {
		status = 42;
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


	};
	var link = "";
	link = _url.base_url + "pawn/request_exten";

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
$(".cancel_submit_gh").on("click", function () {
	var note = $("#approve_note_gh").val();
	var status = $(".status_approve_gh").val();
	var contractId = $(".contract_id_gh").val();
	var exception = $("#exception_gh").val();
	var status_contract = $(".status_contract_gh").val();
	var number_day_loan = $("#number_day_loan_gh").val();
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

	if (status_contract == 21) {
		status = 17;
	}
	if (status_contract == 25) {
		status = 17;
	}
	if (status_contract == 29) {
		status = 17;
	}
	if (status_contract == 11) {
		status = 17;
	}
	if (status_contract == 30) {
		status = 17;
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

	link = _url.base_url + "pawn/request_exten";
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

$(".cancel_submit_cc").on("click", function () {
	var note = $("#approve_note_cc").val();
	var status = $(".status_approve_cc").val();
	var status_contract = $(".status_contract_cc").val();
	var contractId = $(".contract_id_cc").val();
	var exception = $("#exception_cc").val();

	var amount_money = getFloat($("#amount_money_cc").val());
	var number_day_loan = $("#number_day_loan_cc").val();
	var type_loan = $("#type_loan_cc").val();

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

	if (status_contract == 23) {
		status = 17;
	}
	if (status_contract == 27) {
		status = 17;
	}
	if (status_contract == 31) {
		status = 17;
	}
	if (status_contract == 12) {
		status = 17;
	}
	if (status_contract == 32) {
		status = 17;
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


	};
	var link = "";
	link = _url.base_url + "pawn/request_exten";

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
// $( "#close_send_gh_cc" ).click(function() {
//   $("#cocauhopdongModal").modal("hide");
//   $("#giahanhopdongModal").modal("hide");
// });
$(".update_code_contract_submit").on("click", function () {
	var code_contract_disbursement = $("input[name='code_contract_disbursement_update']").val();
	var contractId = $(".contract_id_update").val();
	var formData = {
		code_contract_disbursement: code_contract_disbursement,
		id: contractId
	};
	//Call ajax
	$("#approve").modal("hide");
	$("#extension").modal("hide");
	$("#update_code_contract_disbursement").modal("hide");
	$.ajax({
		url: _url.base_url + "pawn/update_code_contract_disbursement",
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
$(".investors_disbursement_submit").on("click", function (event) {
	event.preventDefault();
	var disbursement_date = $("#timeCheckIn").val();// giải ngân qua vfc
	var disbursement_date1 = $("#timeCheckIn1").val()// giải ngân qua các nhà đầu tư
	var contract_id = $("input[name='contract_id']").val();
	var code_contract = $("input[name='code_contract']").val();
	var type_payout = $("input[name='type_payout']").val();
	var order_code = $("input[name='code_contract']").val();
	var amount = $("input[name='amount']").val();

	var codeTransactionBankDisbursement = $("#code_transaction_bank_disbursement").val();
	var bankName = $("#bank_name").val();
	var contentTransfer = $("#content_transfer").val();
    var chan_bao_hiem =($("input[name='chan_bao_hiem']:checked").val()==undefined) ? 2 : 1;
	var bank_id = $("input[name='bank_id']").val();
	var investor_selected = $('input[name=investor_selected]:checked').val()
	let urlSubmit = _url.base_url + '/pawn/investorsDisbursement';
	if (investor_selected == "2") {
		urlSubmit = _url.base_url + '/pawn/createWithdrawalVimo';
		if (type_payout == 2) {
			var bank_account = $(".bank_account").val();
			var bank_account_holder = $(".bank_account_holder").val();
			var bank_branch = $(".bank_branch").val();
			type_payout = $(".type_payout_bank").val();
			var atm_card_number = "";
			var atm_card_holder = "";

		} else if (type_payout == 3) {
			var bank_account = "";
			var bank_account_holder = "";
			var bank_branch = "";
			var atm_card_number = $(".atm_card_number").val();
			var atm_card_holder = $(".atm_card_holder").val();
		}
		var percentInterestInvestor = $("input[name='percent_interest_investor_vimo']").val();
		var formData = {
			content_transfer: contentTransfer,
			code_transaction_bank_disbursement: codeTransactionBankDisbursement,
			bank_name: bankName,
			code_contract: code_contract,
			type_payout: type_payout,
			order_code: order_code,
			amount: amount,
			bank_id: bank_id,
			bank_account: bank_account,
			bank_account_holder: bank_account_holder,
			atm_card_number: atm_card_number,
			atm_card_holder: atm_card_holder,
			bank_branch: bank_branch,
			investor_selected: investor_selected,
			percent_interest_investor: percentInterestInvestor,
			investor_code: 'vimo',
			chan_bao_hiem: chan_bao_hiem
		};
	} else if (investor_selected == "1") {
		var percentInterestInvestor = $("input[name='percent_interest_investor_vfc']").val();
		var formData = {
			content_transfer: contentTransfer,
			code_transaction_bank_disbursement: codeTransactionBankDisbursement,
			bank_name: bankName,
			code_contract: code_contract,
			type_payout: type_payout,
			investor_code: "vfc",
			contract_id: contract_id,
			percent_interest_investor: percentInterestInvestor,
			disbursement_date: disbursement_date,
			chan_bao_hiem: chan_bao_hiem

		};
	} else if (investor_selected == "3") {
		var investorId = $("#investor").val();
		// var percentInterestInvestor = $("#investor option:selected").attr('data-percent');
		var formData = {
			content_transfer: contentTransfer,
			code_transaction_bank_disbursement: codeTransactionBankDisbursement,
			bank_name: bankName,
			code_contract: code_contract,
			type_payout: type_payout,
			investor_id: investorId,
			contract_id: contract_id,
			investor_code: '',
			percent_interest_investor: '',
			disbursement_date: disbursement_date1,
			chan_bao_hiem: chan_bao_hiem
		};
	}
	$("#approve_disbursement").modal("hide");
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					if (investor_selected == '2') {
						window.location.href = _url.base_url + "pawn/contract";
					} else {
						window.location.href = _url.base_url + "pawn/accountantUpload?id=" + contract_id;
					}
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				// setTimeout(function(){
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function (data) {
			$(".theloading").hide();
			console.log(data);
			$("#loading").hide();
		}
	});

});


$(".investors_disbursement_nl_submit").on("click", function (event) {
	event.preventDefault();
	var contract_id = $("input[name='contract_id']").val();
	var code_contract = $("input[name='code_contract']").val();
	var type_payout = $("input[name='type_payout']").val();
	var order_code = $("input[name='code_contract']").val();
	var amount = $("input[name='amount']").val();
	var codeTransactionBankDisbursement = $("#code_transaction_bank_disbursement").val();
	var bankName = $("#bank_name").val();
	var contentTransfer = $("#content_transfer").val();
	var bank_id = $("input[name='bank_id']").val();
	var investorId = $("#investor").val();
    var chan_bao_hiem =($("input[name='chan_bao_hiem']:checked").val()==undefined) ? 2 : 1;
	let urlSubmit = _url.base_url + '/pawn/investorsDisbursementNganluong';
	var formData = {
		content_transfer: contentTransfer,
		code_transaction_bank_disbursement: codeTransactionBankDisbursement,
		bank_name: bankName,
		code_contract: code_contract,
		type_payout: type_payout,
		investor_id: investorId,
		contract_id: contract_id,
		bank_id: bank_id,
		order_code: order_code,
		amount: amount,
		chan_bao_hiem: chan_bao_hiem
	};
	$("#approve_disbursement").modal("hide");
	approve_disbursement
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					// if(investor_selected == '2'){
					//     window.location.href =  _url.base_url + "pawn/contract";
					// }else{
					//     window.location.href =  _url.base_url + "pawn/accountantUpload?id=" + contract_id;
					// }
					window.location.href = _url.base_url + "pawn/contract";
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				$(".disbursement").hide();
				$(".disbursement_disabled").show();
				setTimeout(function () {
					$("#errorModal").modal("hide");
					$(".modal-backdrop").hide();
				}, 3000);
			}
		},
		error: function (data) {
			$(".theloading").hide();
			console.log(data);
			$("#loading").hide();
		}
	});

});
$(".investors_disbursement_nl_max_submit").on("click", function (event) {
	event.preventDefault();
	var part = $("#part").text();
	var contract_id = $("input[name='contract_id']").val();
	var code_contract = $("input[name='code_contract']").val();
	var type_payout = $("input[name='type_payout']").val();
	var order_code = $("input[name='code_contract']").val();
	var amount = $("input[name='amount']").val();
	var codeTransactionBankDisbursement = $("#code_transaction_bank_disbursement").val();
	var bankName = $("#bank_name").val();
	var contentTransfer = $("#content_transfer").val();
	var bank_id = $("input[name='bank_id']").val();
	var investorId = $("#investor").val();
	var chan_bao_hiem =($("input[name='chan_bao_hiem']:checked").val()==undefined) ? 2 : 1;
	let urlSubmit = _url.base_url + '/pawn/investorsDisbursementNganluong_max';
	var formData = {
		content_transfer: contentTransfer,
		code_transaction_bank_disbursement: codeTransactionBankDisbursement,
		bank_name: bankName,
		code_contract: code_contract,
		type_payout: type_payout,
		investor_id: investorId,
		contract_id: contract_id,
		bank_id: bank_id,
		order_code: order_code,
		amount: amount,
		part: part,
		chan_bao_hiem: chan_bao_hiem

	};
	$("#approve_disbursement_part").modal("hide");

	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
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
				$(".disbursement").hide();
				$(".disbursement_disabled").show();
				setTimeout(function () {
					$("#errorModal").modal("hide");
					$(".modal-backdrop").hide();
					window.location.reload();
				}, 5000);
			}
		},
		error: function (data) {
			$(".theloading").hide();
			console.log(data);
			$("#loading").hide();
		}
	});

});

$(".approve_investors_disbursement_nl_max_submit").on("click", function (event) {
	event.preventDefault();

	var contract_id = $("input[name='contract_id']").val();
	var code_contract = $("input[name='code_contract']").val();
	var type_payout = $("input[name='type_payout']").val();
	var order_code = $("input[name='code_contract']").val();
	var amount = $("input[name='amount']").val();
	var codeTransactionBankDisbursement = $("#code_transaction_bank_disbursement").val();
	var bankName = $("#bank_name").val();
	var contentTransfer = $("#content_transfer").val();
	var bank_id = $("input[name='bank_id']").val();
	var investorId = $("#investor").val();
	var chan_bao_hiem =($("input[name='chan_bao_hiem']:checked").val()==undefined) ? 2 : 1;
	let urlSubmit = _url.base_url + '/pawn/approve_investorsDisbursementNganluong_max';
	var formData = {
		content_transfer: contentTransfer,
		code_transaction_bank_disbursement: codeTransactionBankDisbursement,
		bank_name: bankName,
		code_contract: code_contract,
		type_payout: type_payout,
		investor_id: investorId,
		contract_id: contract_id,
		bank_id: bank_id,
		order_code: order_code,
		amount: amount,
		chan_bao_hiem: chan_bao_hiem

	};
	$("#approve_disbursement_max").modal("hide");

	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
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
				$(".disbursement").hide();
				$(".disbursement_disabled").show();
				setTimeout(function () {
					$("#errorModal").modal("hide");
					$(".modal-backdrop").hide();
					window.location.reload();
				}, 5000);
			}
		},
		error: function (data) {
			$(".theloading").hide();
			console.log(data);
			$("#loading").hide();
		}
	});

});
$(".approve_disbursement_submit").on("click", function (event) {
	event.preventDefault();

	var code_contract = $("input[name='code_contract']").val();
	var type_payout = $("input[name='type_payout']").val();
	var order_code = $("input[name='code_contract']").val();
	var amount = $("input[name='amount']").val();
	var description = $("input[name='description']").val();
	var bank_id = $("input[name='bank_id']").val();

	if (type_payout == 2) {
		var bank_account = $(".bank_account").text();
		var bank_account_holder = $(".bank_account_holder").text();
		var bank_branch = $(".bank_branch").text();
		type_payout = $("input[name='type_payout_bank']:checked").val();
		var atm_card_number = "";
		var atm_card_holder = "";

	} else if (type_payout == 3) {
		var bank_account = "";
		var bank_account_holder = "";
		var bank_branch = "";
		var atm_card_number = $(".atm_card_number").text();
		var atm_card_holder = $(".atm_card_holder").text();
	}


	var formData = {
		code_contract: code_contract,
		type_payout: type_payout,
		order_code: order_code,
		amount: amount,
		bank_id: bank_id,
		description: description,
		bank_account: bank_account,
		bank_account_holder: bank_account_holder,
		atm_card_number: atm_card_number,
		atm_card_holder: atm_card_holder,
		bank_branch: bank_branch
	};
	$.ajax({
		url: _url.base_url + '/pawn/createWithdrawalVimo',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			if (data.code == 200) {
				$("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "pawn/contract";
				}, 2000);
			} else {
				$("#approve_disbursement").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				// setTimeout(function(){
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$("#loading").hide();
		}
	});

});
$("#approve_call_submit").on("click", function () {
	var note = $("#contract_v2_note").val();
	var id = $("#contract_id").val();
	var result_reminder = $("#result_reminder").val();
	var payment_date = $("#payment_date").val();
	var amount_payment_appointment = $("#amount_payment_appointment").val();
	var formData = {
		note: note,
		payment_date: payment_date,
		result_reminder: result_reminder,
		amount_payment_appointment: amount_payment_appointment,
		contractId: id
	};
	//Call ajax
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
				$("#approve_call").hide();
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});

$('#approve').on('hidden.bs.modal', function (e) {

	// do something...
	$(".approve_note").val('');
	$(".approve_note").html('');
	$(".approve_note").text('');

})

$(".edit_amount_money").on("click", function () {
	$('.amount_money').removeAttr('disabled');
});

$('.amount_money').keyup(function (event) {
	// skip for arrow keys
	if (event.which >= 37 && event.which <= 40) return;

	// format number
	$(this).val(function (index, value) {
		return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
	});
	if ($('#insurrance_contract').val() == 1) {
		if ($('#loan_insurance').val() != '2') {
			$('.fee_gic').val(fee_gic());
			$('.amount_loan').val(amount_loan());
		}
		if ($('#loan_insurance').val() == '2') {
			$('.fee_gic').val(fee_gic());
			$('.amount_loan').val(amount_loan());
		}
	} else {
		$('.fee_gic').val(0);
		$('.amount_loan').val(amount_loan());
	}

});

function getFloat(val) {
	var val = val.replace(/,/g, "");
	return parseFloat(val);
}

$('#hsduyet').on('hidden.bs.modal', function (e) {
	console.log('qưe');
	$('.amount_money').attr("disabled", true);
})


$('input[type=file]').change(function () {
	var contain = $(this).data("contain");
	var type = $(this).data("type");
	var contractId = $("#contract_id").val();
	// $(this).simpleUpload(_url.process_upload_image, {
	$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
		allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4","pdf"],
		//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
		maxFileSize: 20000000, //10MB
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
			'contract_id': contractId,
		},
		progress: function (progress) {
			//received progress
			this.progressBar.width(progress + "%");
		},
		success: function (data) {
			//upload successful
			this.progressBar.remove();
			if (data.code == 200) {
				//Video Mp4
				if (fileType == 'video/mp4') {
					// var item = '<a href="'+data.data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""></a>'
					// var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>');
					// this.block.append(data);

					var item = '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>'
					var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"></div>');
					this.block.append(data);
				}
				//Mp3
				else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
					// var item = '<a href="'+data.data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""></a>'
					// var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>');
					// this.block.append(data);


					var item = '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>'
					var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"><textarea rows="6" data-key="' + data.key + '" name="description_img" ></textarea></div>');
					this.block.append(data);
				}
				//pdf
				else if(fileType == 'application/pdf') {
					var item = '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>'
					var item = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>');

					var data = $('<div ></div>').html(item);
					this.block.append(data);
				}

				//Image
				else {

					// var data2 = $('<div ></div>').html('<img src="'+data.data.path+'" /><button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"><textarea rows="6" data-key="'+data.data.key+'" name="description_img" ></textarea></div>');
					// this.block.append(data2);


					var content = "";
					content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
					content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" />';
					content += '</a>';
					content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(content);
					this.block.append(data);


				}
			} else {
				//our application returned an error
				// var error = data.data.error.message;
				// var errorDiv = $('<div class="error"></div>').text(error);
				// this.block.append(errorDiv);
				var error = data.msg.error;
				this.block.remove();
				alert(error);
			}
		},
		error: function (error) {
			//upload failed
			// this.progressBar.remove();
			// var error = error.message;
			// var errorDiv = $('<div class="error"></div>').text(error);
			// this.block.append(errorDiv);

			var msg = error.message;
			this.block.remove();
			alert(msg);
		}
	});
});

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	var res = confirm("Bạn có chắc chắn muốn xóa ?");
	$(thiz_).closest("div .block").remove();
	// if (res == true) {
	//     $.ajax({
	//         url: _url.process_contract_delete_image,
	//         method: "POST",
	//         data: {
	//             id: id,
	//             key: key,
	//             type_img: type
	//         },
	//         success: function(data) {
	//             if(data.data.status == 200) {
	//                 $(thiz_).closest("div .block").remove();
	//             }
	//         },
	//         error: function(error) {

	//         }
	//     });
	// }
}

$(".submit_description_img").on("click", function (event) {
	event.preventDefault();
	var contractId = $("#contract_id").val();
	var expertise = {};
	var img_contract = $("img[name='img_file']").length;
	if (img_contract > 0) {
		$("img[name='img_file']").each(function () {
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
	console.log(expertise)
	var formData = {
		contractId: contractId,
		expertise: expertise,
		// arrDescription: arrDescription
	};
	$.ajax({
		url: _url.base_url + '/pawn/updateDescriptionImage',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			if (data.code == 200) {
				$("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "pawn/contract";
				}, 2000);
			} else {
				$("#approve_disbursement").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
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

$(".update_disbursement_contract").on("click", function (event) {
	event.preventDefault();
	console.log(123);
	//Get receiver infor
	var receiverInfor = getReceiverInfor();
	//Call ajax
	$.ajax({
		url: _url.base_url + '/pawn/updateDisbursementContract',
		method: "POST",
		data: {
			id: $("#contract_id").val(),
			receiver_infor: receiverInfor,
		},
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.data.status != 200) {
				$("#saveContract").modal("hide");
				$("#div_error").css("display", "block");
				$(".div_error").text(data.data.message);
				// window.scrollTo(0, 0);
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#div_error").offset().top
				}, 500);


				setTimeout(function () {
					$("#div_error").css("display", "none");
				}, 3000);
			} else {
				$("#saveContract").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text('Lưu hợp đồng thành công');
				setTimeout(function () {
					window.location.href = _url.contract;
				}, 2000);

			}
		},
		error: function (error) {
			console.log(error);
		}
	});
});

function show_popup_disbursement_part(t) {
	var part = $(t).data("part");
	var money = $(t).data("money");
	$('#part').text(part);
	$('#amount_part').text(money);
	$("#approve_disbursement_part").modal('show');
}

function getReceiverInfor() {
	var ReceiverInfor = {};
	var type_payout = $("#type_payout :checked").val();
	var amount = getFloat($("#money").val());
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


function getFloat(val) {
	var val = val.replace(/,/g, "");
	return parseFloat(val);
}


// $('#investor').selectize({
//     create: false,
//     valueField: 'percent_interest_investor',
//     labelField: 'name',
//     searchField: 'name',
//     maxItems: 1,
//     sortField: {
//         field: 'name',
//         direction: 'asc'
//     }
// });


$('#investor').selectize({
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


function closemedia() {
	var audio = $("#player");
	audio[0].pause();
}

function show_popup_print_contract_loan(thiz) {
	$(".title_modal_approve_printed").text("In chứng từ cho vay");

	let contract_id = $(thiz).data("id");
	let contract_status = $(thiz).data("status_contract");
	let type_property_code = $(thiz).data("type_property_code");
	$(".contract_id").val(contract_id);
	$(".printed_phu_luc").attr("href", _url.base_url + 'pawn/printed_phuluc01?id=' + contract_id);
	$(".printed_contract").attr("href", _url.base_url + 'pawn/printed?id=' + contract_id);
	$(".printed_notification").attr("href", _url.base_url + 'pawn/printedNotification?id=' + contract_id);
	if (contract_status != 19) {
		$(".printed_final_settlement").hide();
		$(".sample-receipt-two").hide();
		$(".printed_receipt_after_sign_contract").show();
		$(".printed_receipt_after_sign_contract").attr("href", _url.base_url + 'pawn/printedReceiptAfterSignContract?id=' + contract_id);
	} else if (contract_status == 19) {
		$(".printed_receipt_after_sign_contract").hide();
		$(".sample-receipt-one").hide();
		$(".printed_final_settlement").show();
		$(".printed_final_settlement").attr("href", _url.base_url + 'pawn/printedReceiptFinalSettlement?id=' + contract_id);
	}
	if (type_property_code == 'XM') {
		$(".printed_commitment_car").show();
		$(".printed_commitment_car").attr("href", _url.base_url + 'pawn/printedCommitmentCar?id=' + contract_id);
	} else {
		$(".printed_commitment_car").hide();
	}
     if ( contract_status != 34 && contract_status != 33 && contract_status != 29 && contract_status != 31) {
		$(".printed_phu_luc").hide();
			}
		if( contract_status == 33 || contract_status == 29 )
	{
		$(".text_title_ghcc").text('Phụ lục gia hạn');
	}	
	if( contract_status == 34 || contract_status== 31 )
	{
		$(".text_title_ghcc").text('Phụ lục cơ cấu');
	}
	$('#print_contract').modal('show');
}

function show_popup_print_contract_pledge(thiz) {
	$(".title_modal_approve_printed").text("In chứng từ cầm cố");

	let contract_id = $(thiz).data("id");
	let contract_status = $(thiz).data("status_contract");
	let type_property_code = $(thiz).data("type_property_code");
	$(".contract_id").val(contract_id);
	$(".printed_phu_luc").attr("href", _url.base_url + 'pawn/printed_phuluc01?id=' + contract_id);
	$(".printed_contract").attr("href", _url.base_url + 'pawn/printed?id=' + contract_id);
	$(".printed_phu_luc").attr("href", _url.base_url + 'pawn/printed_phuluc01?id=' + contract_id);
	$(".printed_notification").attr("href", _url.base_url + 'pawn/printedNotification?id=' + contract_id);
	if (contract_status != 19) {
		$(".printed_final_settlement").hide();
		$(".sample-receipt-two").hide();
		$(".printed_receipt_after_sign_contract").show();
		$(".printed_receipt_after_sign_contract").attr("href", _url.base_url + 'pawn/printedReceiptAfterSignContract?id=' + contract_id);
	} else if (contract_status == 19) {
		$(".printed_receipt_after_sign_contract").hide();
		$(".sample-receipt-one").hide();
		$(".printed_final_settlement").show();
		$(".printed_final_settlement").attr("href", _url.base_url + 'pawn/printedReceiptFinalSettlement?id=' + contract_id);
	}
     if ( contract_status != 34 && contract_status != 33 && contract_status != 29 && contract_status != 31) {
		$(".printed_phu_luc").hide();
			}
		if( contract_status == 33 || contract_status == 29 )
	{
		$(".text_title_ghcc").text('Phụ lục gia hạn');
	}	
	if( contract_status == 34 || contract_status== 31 )
	{
		$(".text_title_ghcc").text('Phụ lục cơ cấu');
	}
	if (type_property_code == 'XM') {
		$(".printed_commitment_car").show();
		$(".printed_commitment_car").attr("href", _url.base_url + 'pawn/printedCommitmentCar?id=' + contract_id);
	} else {
		$(".printed_commitment_car").hide();
	}

	$('#print_contract_pledge').modal('show');
}

function show_popup_print_contract_mortgage(thiz) {
	$(".title_modal_approve_printed").text("In chứng từ tín chấp");
  let contract_status = $(thiz).data("status_contract");
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$(".printed_phu_luc").attr("href", _url.base_url + 'pawn/printed_phuluc01?id=' + contract_id);
	$(".printed_contract_mortgage").attr("href", _url.base_url + 'pawn/printedMortgage?id=' + contract_id);
	$(".printed_commitment_policy").attr("href", _url.base_url + 'pawn/printedCommitmentPolicy?id=' + contract_id);
   $(".printed_phu_luc").attr("href", _url.base_url + 'pawn/printed_phuluc01?id=' + contract_id);
	$(".printed_contract_mortgage").attr("href", _url.base_url + 'pawn/printedMortgage?id=' + contract_id);
	  if ( contract_status != 34 && contract_status != 33 && contract_status != 29 && contract_status != 31) {
		$(".printed_phu_luc").hide();
			}
		if( contract_status == 33 || contract_status == 29 )
	{
		$(".text_title_ghcc").text('Phụ lục gia hạn');
	}	
	if( contract_status == 34 || contract_status== 31 )
	{
		$(".text_title_ghcc").text('Phụ lục cơ cấu');
	}
	$('#print_contract_mortgage').modal('show');
}

function show_popup_print_contract_estate(thiz) {
	$(".title_modal_approve_printed").text("In chứng từ nhà đất");
	let contract_id = $(thiz).data("id");
	let contract_status = $(thiz).data("status_contract");
	$(".contract_id").val(contract_id);
	$(".printed_bbbg_thanhly").attr("href", _url.base_url + 'pawn/printed_bbbg_the_chap_thanh_ly?id=' + contract_id);
	$(".printed_bbbg_ky").attr("href", _url.base_url + 'pawn/printed_bbbg_ky_thoa_thuan?id=' + contract_id);
	$(".printed_phu_luc").attr("href", _url.base_url + 'pawn/printed_phuluc01?id=' + contract_id);
	$(".printed_contract_mortgage").attr("href", _url.base_url + 'pawn/printedEstate?id=' + contract_id);
	  if ( contract_status != 34 && contract_status != 33 && contract_status != 29 && contract_status != 31) {
		$(".printed_phu_luc").hide();
			}
		if( contract_status == 33 || contract_status == 29 )
	{
		$(".text_title_ghcc").text('Phụ lục gia hạn');
	}	
	if( contract_status == 34 || contract_status== 31 )
	{
		$(".text_title_ghcc").text('Phụ lục cơ cấu');
	}
	if( contract_status != 19 )
	{
		$(".printed_bbbg_thanhly").hide();
	}
	$('#print_contract_mortgage').modal('show');
}

$(document).ready(function () {

	$('#change_cancel').change(function (event) {
		event.preventDefault();
		var change_cancel = $('#change_cancel').val();
		if (change_cancel == "C1") {
			$('#cancel1').show();
		} else if (change_cancel == "C2") {
			$('#cancel2').show();
		} else if (change_cancel == "C3") {
			$('#cancel3').show();
		} else if (change_cancel == "C4") {
			$('#cancel4').show();
		} else if (change_cancel == "C5") {
			$('#cancel5').show();
		} else if (change_cancel == "C6") {
			$('#cancel6').show();
		} else if (change_cancel == "C7") {
			$('#cancel7').show();
		}
	})

});

$('[name="lead_cancel_C1[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_cancel_C1').val()
	var data1 = [];
	if (value != null) {
		data1.push(value);
	}
	$('#lead_cancel1_C1').val(JSON.stringify(data1));
})
$('[name="lead_cancel_C2[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_cancel_C2').val()
	var data2 = [];
	if (value != null) {
		data2.push(value);
	}
	$('#lead_cancel1_C2').val(JSON.stringify(data2));
})
$('[name="lead_cancel_C3[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_cancel_C3').val()
	var data3 = [];
	if (value != null) {
		data3.push(value);
	}
	$('#lead_cancel1_C3').val(JSON.stringify(data3));
})
$('[name="lead_cancel_C4[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_cancel_C4').val()
	var data4 = [];
	if (value != null) {
		data4.push(value);
	}
	$('#lead_cancel1_C4').val(JSON.stringify(data4));
})
$('[name="lead_cancel_C5[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_cancel_C5').val()
	var data5 = [];
	if (value != null) {
		data5.push(value);
	}
	$('#lead_cancel1_C5').val(JSON.stringify(data5));
})
$('[name="lead_cancel_C6[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_cancel_C6').val()
	var data6 = [];
	if (value != null) {
		data6.push(value);
	}
	$('#lead_cancel1_C6').val(JSON.stringify(data6));
})
$('[name="lead_cancel_C7[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_cancel_C7').val()
	var data7 = [];
	if (value != null) {
		data7.push(value);
	}
	$('#lead_cancel1_C7').val(JSON.stringify(data7));
})


$('#lead_cancel_C1').selectize({
	create: false,
	valueField: 'lead_cancel_C1',
	labelField: 'name1',
	searchField: 'name1',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}

});
$('#lead_cancel_C2').selectize({
	create: false,
	valueField: 'lead_cancel_C2',
	labelField: 'name2',
	searchField: 'name2',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_cancel_C3').selectize({
	create: false,
	valueField: 'lead_cancel_C3',
	labelField: 'name3',
	searchField: 'name3',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_cancel_C4').selectize({
	create: false,
	valueField: 'lead_cancel_C4',
	labelField: 'name4',
	searchField: 'name4',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_cancel_C5').selectize({
	create: false,
	valueField: 'lead_cancel_C5',
	labelField: 'name5',
	searchField: 'name5',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_cancel_C6').selectize({
	create: false,
	valueField: 'lead_cancel_C6',
	labelField: 'name6',
	searchField: 'name1',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_cancel_C7').selectize({
	create: false,
	valueField: 'lead_cancel_C7',
	labelField: 'name7',
	searchField: 'name7',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$(document).ready(function () {

	$('#change_exception_detail').change(function (event) {
		event.preventDefault();
		var change_exception = $('#change_exception_detail').val();
		if (change_exception == "E1") {
			$('#exception1_detail').show();
		} else if (change_exception == "E2") {
			$('#exception2_detail').show();
		} else if (change_exception == "E3") {
			$('#exception3_detail').show();
		} else if (change_exception == "E4") {
			$('#exception4_detail').show();
		} else if (change_exception == "E5") {
			$('#exception5_detail').show();
		} else if (change_exception == "E6") {
			$('#exception6_detail').show();
		} else if (change_exception == "E7") {
			$('#exception7_detail').show();
		}
	})

});

$('[name="lead_exception_E1_detail[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E1_detail').val()
	var data1 = [];
	if (value != null) {
		data1.push(value);
	}
	$('#exception1_value_detail').val(JSON.stringify(data1));
})
$('[name="lead_exception_E2_detail[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E2_detail').val()
	var data2 = [];
	if (value != null) {
		data2.push(value);
	}
	$('#exception2_value_detail').val(JSON.stringify(data2));
})
$('[name="lead_exception_E3_detail[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E3_detail').val()
	var data3 = [];
	if (value != null) {
		data3.push(value);
	}
	$('#exception3_value_detail').val(JSON.stringify(data3));
})
$('[name="lead_exception_E4_detail[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E4_detail').val()
	var data4 = [];
	if (value != null) {
		data4.push(value);
	}
	$('#exception4_value_detail').val(JSON.stringify(data4));
})
$('[name="lead_exception_E5_detail[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E5_detail').val()
	var data5 = [];
	if (value != null) {
		data5.push(value);
	}
	$('#exception5_value_detail').val(JSON.stringify(data5));
})
$('[name="lead_exception_E6_detail[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E6_detail').val()
	var data6 = [];
	if (value != null) {
		data6.push(value);
	}
	$('#exception6_value_detail').val(JSON.stringify(data6));
})
$('[name="lead_exception_E7_detail[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#lead_exception_E7_detail').val()
	var data7 = [];
	if (value != null) {
		data7.push(value);
	}
	$('#exception7_value_detail').val(JSON.stringify(data7));
})


$('#lead_exception_E1_detail').selectize({
	create: false,
	valueField: 'lead_exception_E1_detail',
	labelField: 'name1',
	searchField: 'name1',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}

});
$('#lead_exception_E2_detail').selectize({
	create: false,
	valueField: 'lead_exception_E2_detail',
	labelField: 'name2',
	searchField: 'name2',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E3_detail').selectize({
	create: false,
	valueField: 'lead_exception_3_detail',
	labelField: 'name3',
	searchField: 'name3',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E4_detail').selectize({
	create: false,
	valueField: 'lead_exception_E4_detail',
	labelField: 'name4',
	searchField: 'name4',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E5_detail').selectize({
	create: false,
	valueField: 'lead_exception_E5_detail',
	labelField: 'name5',
	searchField: 'name5',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E6_detail').selectize({
	create: false,
	valueField: 'lead_exception_E6_detail',
	labelField: 'name6',
	searchField: 'name1',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$('#lead_exception_E7_detail').selectize({
	create: false,
	valueField: 'lead_exception_E7_detail',
	labelField: 'name7',
	searchField: 'name7',
	maxItems: 10,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});


$(document).ready(function () {

	$('#exception1_del_detail').click(function (event) {
		event.preventDefault();
		$('#exception1_detail').hide();
		$('#lead_exception_E1_detail')[0].selectize.clear();
	});
	$('#exception2_del_detail').click(function (event) {
		event.preventDefault();
		$('#exception2_detail').hide();
		$('#lead_exception_E2_detail')[0].selectize.clear();
	});
	$('#exception3_del_detail').click(function (event) {
		event.preventDefault();
		$('#exception3_detail').hide();
		$('#lead_exception_E3_detail')[0].selectize.clear();
	});
	$('#exception4_del_detail').click(function (event) {
		event.preventDefault();
		$('#exception4_detail').hide();
		$('#lead_exception_E4_detail')[0].selectize.clear();
	});
	$('#exception5_del_detail').click(function (event) {
		event.preventDefault();
		$('#exception5_detail').hide();
		$('#lead_exception_E5_detail')[0].selectize.clear();
	});
	$('#exception6_del_detail').click(function (event) {
		event.preventDefault();
		$('#exception6_detail').hide();
		$('#lead_exception_E6_detail')[0].selectize.clear();
	});
	$('#exception7_del_detail').click(function (event) {
		event.preventDefault();
		$('#exception7_detail').hide();
		$('#lead_exception_E7_detail')[0].selectize.clear();
	});
});
$(document).ready(function () {

	$('#lead_cancel_C1_detail').click(function (event) {
		event.preventDefault();
		$('#cancel1').hide();
		$('#lead_cancel_C1')[0].selectize.clear();
	});
	$('#lead_cancel_C2_detail').click(function (event) {
		event.preventDefault();
		$('#cancel2').hide();
		$('#lead_cancel_C2')[0].selectize.clear();
	});
	$('#lead_cancel_C3_detail').click(function (event) {
		event.preventDefault();
		$('#cancel3').hide();
		$('#lead_cancel_C3')[0].selectize.clear();
	});
	$('#lead_cancel_C4_detail').click(function (event) {
		event.preventDefault();
		$('#cancel4').hide();
		$('#lead_cancel_C4')[0].selectize.clear();
	});
	$('#lead_cancel_C5_detail').click(function (event) {
		event.preventDefault();
		$('#cancel5').hide();
		$('#lead_cancel_C5')[0].selectize.clear();
	});
	$('#lead_cancel_C6_detail').click(function (event) {
		event.preventDefault();
		$('#cancel6').hide();
		$('#lead_cancel_C6')[0].selectize.clear();
	});
	$('#lead_cancel_C7_detail').click(function (event) {
		event.preventDefault();
		$('#cancel7').hide();
		$('#lead_cancel_C7')[0].selectize.clear();
	});
});


function 	hoi_so_bat_dau_duyet(thiz) {
	let contract_id = $(thiz).data("id");
	let contract_name = $(thiz).data("customerhs");
	$("#check_app_hs").val(contract_id);
	console.log("test1");
	$("#check_contract_name").val(contract_name);
	$("#checkmodal").modal("show");
}

$(document).ready(function () {
	$("#customer_hs").click(function () {

		var id_oid = $('#check_app_hs').val();

		var formData = new FormData();
		formData.append('id_oid', id_oid);

		$("#checkmodal").modal("hide");

		$.ajax({
			url: _url.base_url + 'lead_custom/insert_customer_hs_create_at',
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
				window.location.href = _url.base_url + 'pawn/detail?id=' + data.data.id_oid;
			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});
	});
});

function comment(thiz) {
	let comment_id = $(thiz).data("id");
	$("#comment_id").val(comment_id);
	$("#addComment").modal("show");
}

$(document).ready(function () {

	$("#customer_comment").click(function (event) {

		event.preventDefault();

		var add_comment = $('#add_comment').val();
		var comment_id = $('#comment_id').val();

		var formData = new FormData();
		formData.append('add_comment', add_comment);
		formData.append('comment_id', comment_id);

		$.ajax({
			url: _url.base_url + 'pawn/insert_log_comment',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {

				$("#loading").hide();
				if (data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.msg);
					setTimeout(function () {
						window.location.reload();
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

//ASM gui hoi so duyet
function asm_duyet(thiz) {
	$(".title_modal_approve").text("Chuyển hội sở duyệt");
	$(".status_approve").val(5);
	$(".error_code_contract").hide();
	$(".img_return_file").hide();
	$(".so_tien_vay_asm_de_xuat").show();
	$(".ki_han_vay_asm_de_xuat").show();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

//ASM khong duyet tra ve cvkd
function asm_khong_duyet(thiz) {
	$(".title_modal_approve").text("ASM không duyệt");
	$(".status_approve").val(36);
	$(".error_code_contract").hide();
	$(".img_return_file").show();
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

$(document).ready(function (){
	function addCommas(str) {
		return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$('.so_tien_vay_asm_de_xuat').on('keyup', function (event) {
		var so_tien_vay_asm_de_xuat = $("input[name='so_tien_vay_asm_de_xuat']").val()
		console.log(so_tien_vay_asm_de_xuat)
		$('#so_tien_vay_asm_de_xuat').val(addCommas(so_tien_vay_asm_de_xuat))
	})
})

$('#change_source').click( function() {
	var id_contract = $('#contract_id').val();
	var customer_resources = $('#customer_resource_convert').val();
	var note_change_source = $("textarea[name='note_change_source']").val();
	var formData = {
		id_contract: id_contract,
		customer_resources: customer_resources,
		note_change_source: note_change_source
	}
	if (confirm("Xác nhận đổi nguồn khách hàng?")) {
		$.ajax({
			url: _url.base_url + 'Pawn/change_customer_resource',
			method: "POST",
			data: formData,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					toastr.success("Cập nhật thành công!", {
						timeOut: 3000,
					});
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					$(".theloading").hide();
					toastr.error("Cập nhật thất bại!", {
						timeOut: 2000,
					});
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}

		})
	}
});

$("#confirm_edit").click(function () {
	let id_contract = $("#contract_id_d_edit").val();
	let code_contract = $("#code_contract_d_edit").val();
	let new_code_contract_disbursement = $("#new_code_contract_disbursement").val();
	let note_edit_code_contract_disbursement = $("textarea[name='note_edit_code_contract_disbursement']").val();
	let formData = {
		id_contract: id_contract,
		code_contract: code_contract,
		new_code_contract_disbursement: new_code_contract_disbursement,
		note_edit_code_contract_disbursement: note_edit_code_contract_disbursement
	}
	$.ajax({
		url: _url.base_url + 'Pawn/edit_code_contract_d',
		method: "POST",
		data: formData,
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.status == 200) {
				toastr.success(data.msg, {
					timeOut: 3000,
				});
				setTimeout(function () {
					window.location.reload();
				}, 2000 )
			} else {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 3000,
				});
			}
		},
		error: function (data) {
			$(".theloading").hide();
			toastr.error('Có lỗi xảy ra trong quá trình cập nhật!', {
				timeOut: 3000,
			});
		}
	});
});

function cancel_contract_megadoc(thiz) {
	$("#cancel_contract_megadoc").modal("show");
}

$("#confirm_cancel_megadoc").click(function () {

	let fkey_send = $("input[name='fkey_document']:checked").data('fkey');
	let contract_no_send = $("input[name='fkey_document']:checked").data('contractno');
	let reason_cancel_megadoc = $("textarea[name='reason_cancel_megadoc']").val();
	let formData = {
		fkey_send: fkey_send,
		contract_no_send: contract_no_send,
		reason_cancel_megadoc: reason_cancel_megadoc
		}
	if (confirm("Xác nhận hủy hợp đồng điện tử?")) {
		$.ajax({
			url: _url.base_url + "Pawn/cancel_contract_megadoc",
			method: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				console.log(data);
				if (data.status == 200) {
					$('.theloading').hide();
					toastr.success(data.msg, {
						timeOut: 3000,
					});
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 2000,
					});
				}
				console.log(data)
			},
			error: function (data) {
				console.log(data)
			}
		});
	}

});

$("#confirm_check_status").click(function() {
	let searchkey = $("input[name='searchkey_document']:checked").val();
	let code_contract = $("#code_contract_searchkey").val();
	$("#status_contract_megadoc").empty();
	$("#fkey_resp").empty();
	$("#searchkey_resp").empty();
	$("#createdate_resp").empty();
	$("#signdate_resp").empty();
	$("#completedate_resp").empty();
	$("#status_resp").empty();
	$.ajax({
		url: _url.base_url + "Pawn/status_contract_megadoc",
		method: "POST",
		data: {
			searchkey: searchkey,
			code_contract: code_contract
		},
		success: function (data) {
			if (data.status == 200) {
				$("#checkStatusContractMegadoc").modal('hide');
				$("#fkey_resp").append(data.data.FKey);
				$("#searchkey_resp").append(data.data.SearchKey);
				$("#createdate_resp").append(data.data.CreateDate);
				$("#signdate_resp").append(data.data.SignDate);
				$("#completedate_resp").append(data.data.CompleteDate);
				$("#status_resp").append(data.data.status_convert);
				$("#statusContractMegadoc").modal("show");
			} else {
				alert("Có lỗi trong quá trình lấy dữ liệu Megadoc!");
			}
		},
		error: function (data) {
			alert("Chưa có dữ liệu hợp đồng điện tử Megadoc!");
		}
	});
});

function resend_file_to_megadoc(thiz) {
	let id_contract = $(thiz).data("id");
	let status_approve = $(thiz).data("statusapprove");
	let create_type = $(thiz).data("createtype");
	let urlSubmit = _url.base_url + 'Pawn/resend_file_to_megadoc';
	let formData = {
		id_contract : id_contract,
		status_approve : status_approve,
		create_type : create_type
	};
	if (confirm("Xác nhận tạo hợp đồng điện tử?")) {
		$.ajax({
			url: urlSubmit,
			method: "POST",
			data: formData,
			dataType: "JSON",
			beforeSend: function () {
				$("#viewStatusContractMegadoc").hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				console.log(data);
				if (data.status == 200) {
					toastr.success(data.msg, {
						timeOut: 3000,
					});
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					toastr.error(data.msg, {
						timeOut: 3000
					});
					setTimeout(function () {
						window.location.reload();
					}, 7000)
				}
			},
			error: function (data) {
				$(".theloading").hide();
				console.log(data);
				$("#loading").hide();
			}
		});
	}
}

function download_file_to_megadoc(thiz) {
	let searchkey = $(thiz).data("searchkey");
	let file_type = $(thiz).data("createtype");
	let codecontract = $(thiz).data("codecontract");
	let urlSubmit = _url.base_url + "Pawn/download_file_megadoc";
	let formData = {
		searchkey : searchkey,
		file_type : file_type,
		code_contract : codecontract,
	}

	if (confirm("Xác nhận tải file pdf Megadoc?")) {
		$.ajax({
			url: urlSubmit,
			method: "POST",
			data: formData,
			dataType: "JSON",
			beforeSend: function () {
				$("#viewStatusContractMegadoc").hide();
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data);
				if (data.status == 200) {
					$(".theloading").hide();
					pdfUrl = data.url
					window.open(pdfUrl, '_blank');
					toastr.success(data.msg, {
						timeOut: 3000,
					});
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 3000
					});
					setTimeout(function () {
						window.location.reload();
					}, 7000)
				}
			},
			error: function (data) {
				$(".theloading").hide();
			}
		});
	}

}

function resend_sms_to_customer(thiz) {
		let code_contract = $(thiz).data("codecontract");
		let sms_id = $(thiz).data("idsms");
		let urlSubmit = _url.base_url + "pawn/resend_sms_megadoc"
		let formData = {
			code_contract : code_contract,
			sms_id : sms_id,
		}
		if (confirm("Xác nhận gửi lại SMS cho khách hàng!")) {
			$.ajax({
				url: urlSubmit,
				method: "POST",
				data: formData,
				dataType: "JSON",
				beforeSend: function () {
					$("#viewStatusContractMegadoc").hide();
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						toastr.success(data.msg, {
							timeOut: 3000,
						});
						setTimeout(function () {
							window.location.reload();
						}, 2000)
					} else {
						toastr.error(data.msg, {
							timeOut: 3000
						});
						setTimeout(function () {
							window.location.reload();
						}, 7000)
					}
				},
				error: function (data) {
					$(".theloading").hide();
					console.log(data);
					$("#loading").hide();
				}
			})
		}
	}



