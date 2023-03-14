$("#code_nganluong").hide();

function check_all_kt(t) {

	var check = $("#combox_check").val();
	$('.datatablebutton input:checked').each(function (item) {
		$("#" + $(this).val()).val(check);
		update_kt($(this).val(), check);

	});

}

function update_kt(id, check) {
	var status = 0;
	if (check == "duyet") {

		var formData = {
			contract_id: id
		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/run_fee",
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
					$("#approve_disbursement").modal("hide");
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {
					//$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
	if (check == "thanhtoan") {

		var formData = {

			contract_id: id


		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/payment_all",
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
					$("#approve_disbursement").modal("hide");
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {
					//$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
	if (check == "chaylailaiphi") {

		var formData = {
			contract_id: id
		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/run_fee_again",
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

					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {
					//$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
	if (check == "khoa_hop_dong") {

		var formData = {
			contract_id: id
		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/khoa_hop_dong",
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

					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {

					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
	if (check == "mo_khoa_hop_dong") {

		var formData = {
			contract_id: id
		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/mo_khoa_hop_dong",
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

					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {

					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
	if (check == "chaylaicocau") {

		var formData = {

			contract_id: id


		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/re_run_cocau",
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

					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {
					//$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
	if (check == "chaylaigiahan") {

		var formData = {

			contract_id: id


		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/re_run_giahan",
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
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {
					//$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
	if (check == "duyet_hd_gn_nl") {
		var code_nganluong = $("#code_nganluong").val();
		var formData = {

			contract_id: id,
			code_nganluong: code_nganluong


		};
		//Call ajax
		$.ajax({
			url: _url.base_url + "temporary_plan/duyet_hd_nganluong",
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
					$("#code_nganluong").hide();
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
				} else {
					//$("#approve_transaction").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 3000);
			}
		});
	}
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
		success: function (data) {
			if (data.code == 200) {
				$("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "transaction/list_kt?tab=wait";
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
$('#combox_check').change(function () {
	var check = $("#combox_check").val();
	if (check == "duyet_hd_gn_nl") {
		$("#code_nganluong").show();
	} else {
		$("#code_nganluong").hide();
	}
});
$('input[type=file]').change(function () {

	var transactionId = $("#transaction_id").val();
	var count = $("img[name='img_transaction']").length;
	var expertise = {};
	if (count > 0) {
		$("img[name='img_transaction']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['description'] = "";
			var key = $(this).data('key');
			if (type == 'expertise') {
				expertise[key] = data;
			}
		});
	}
	var formData = {
		transactionId: transactionId,
		expertise: expertise,
	};
	console.log(formData);
	$.ajax({
		url: _url.base_url + '/transaction/doUpload',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.code == 200) {
				// $("#successModal").modal("show");
				// $(".msg_success").text(data.msg);
				// setTimeout(function(){
				// 	window.location.href =  _url.base_url + "transaction";
				// }, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			}
		},
		error: function (data) {
			$(".theloading").hide();
		}
	});

});


$(".approve_submit").on("click", function () {
	var modal = $(this).closest(".modal-body");
	var code_transaction_bank = $(modal).find("input[name='code_transaction_bank']").val();
	var bank = $(modal).find("input[name='bank']").val();
	var note = $(".approve_note").val();
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
		note: note,
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
					window.location.href = response.url;
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

function get_status_contract(stt) {
	var text_status = "";
	switch (stt) {
		case 17:
			text_status = "Đang vay";
			break;
		case 19:
			text_status = "Tất toán";
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
			text_status = "Kế toán không duyệt gia hạn";
			break;
		case 31:
			text_status = "Chờ kế toán duyệt gia hạn";
			break;
		case 32:
			text_status = "Kế toán không duyệt gia hạn";
			break;
		case 33:
			text_status = "Đã gia hạn";
			break;
		case 34:
			text_status = "Đã cơ cấu";
			break;

	}
	return text_status;
}

$(".ds_hop_dong_gh").on("click", function () {
	var id_contract = $(this).data('id');
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
							"<td><a href='" + _url.base_url + "accountant/view_v2?id=" + item._id.$oid + "' target='_blank' >Xem chi tiết</a></td>" +
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
$(".ds_hop_dong_cc").on("click", function () {
	var id_contract = $(this).data('id');
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
						console.log(item);
						var structure_date = (moment.unix(item.structure_date).format("DD/MM/YYYY HH:mm:ss") == "Invalid date") ? '' : moment.unix(item.ngay_co_cau).format("DD/MM/YYYY HH:mm:ss");
						document.getElementById("list_contract_gh_cc").innerHTML +=
							"<tr>" +
							"<td>" + (++index) + "</td>" +
							"<td>" + item.code_contract_disbursement + "</td>" +
							"<td>" + item.code_contract + "</td>" +
							"<td>" + type_cc + "</td>" +
							"<td>" + moment.unix(item.structure_date).format("DD/MM/YYYY HH:mm:ss") + "</td>" +
							"<td>" + get_status_contract(item.status) + "</td>" +
							"<td><a href='" + _url.base_url + "accountant/view_v2?id=" + item._id.$oid + "' target='_blank' >Xem chi tiết</a></td>" +
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
