$('select[name="userId"]').selectize({
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

function showContractId(id) {
	$.ajax({
		url: _url.base_url + "/debt_manager_app/showContractDebt?id=" + id,
		type: "GET",
		dataType: 'json',
		success: function (data) {
			let code_contract = typeof data.data.code_contract_disbursement == 'undefined' ? data.data.code_contract : data.data.code_contract_disbursement
			$('.title_contract_update').empty()
			$("input[name='contractIdInput']").empty()
			$('.title_contract_update').text('Hợp đồng ' + code_contract)
			$("input[name='contractIdInput']").val(id)
		}
	})
}

$(document).ready(function () {
	$("#contract_debt_btnSave").click(function (event) {
		event.preventDefault();
		var id_contract = $("input[name='contractIdInput']").val()
		var user_id = $("#email_user_debt").val();
		var formData = new FormData();
		formData.append('user_id', user_id);
		formData.append('id_contract', id_contract);
		$.ajax({
			url: _url.base_url + 'debt_manager_app/add_user_debt_contract',
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
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				}
			},
			error: function () {
				$(".theloading").hide();
				alert('error')
			}
		});
	})

	$("#addAssignUserDebtModal_btnSave").click(function (event) {
		event.preventDefault();
		var code_contract = $("input[name='contractAssignUserDebt']").val()
		var note = $("#noteAssignUserDebt").val()
		var id = $("#idUserDebtAssign").val()
		var formData = new FormData();
		formData.append('code_contract', code_contract);
		formData.append('note', note);
		formData.append('userId', id);
		$.ajax({
			url: _url.base_url + 'debt_manager_app/addAssignUserDebt',
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
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				}
			},
			error: function () {
				$(".theloading").hide();
				alert('error')
			}
		});
	})

	$('.overViewUserDebt').click(function () {
		let id = $('#idUserDebtAssign').val()
		$.ajax({
			url: _url.base_url + 'debt_manager_app/kpi_overView?user_id=' + id,
			type: "GET",
			dataType: "JSON",
			success: function (result) {
				console.log(result)
				$('.pos').empty();
				$('.da_gap').empty();
				$('.chua_gap').empty();
				$('.da_xu_ly').empty();
				$('.chua_xu_ly').empty();
				$('.tien_da_thu').empty();
				$('.da_thu_tien').empty();
				$('.chua_vieng_tham').empty();
				$('.da_thu_hoi_xe').empty();
				$('.tiep_tuc_tac_dong').empty();
				$('.hua_thanh_toan').empty();
				$('.mat_kha_nang_thanh_toan').empty();
				$('.pos').text(result.data.pos + ' VND');
				$('.da_gap').text(result.data.da_gap);
				$('.chua_gap').text(result.data.chua_gap);
				$('.da_xu_ly').text(result.data.da_xu_ly);
				$('.chua_xu_ly').text(result.data.chua_xu_ly);
				$('.tien_da_thu').text(result.data.tien_thu + ' VND');
				$('.da_thu_tien').text(result.data.da_thu_tien);
				$('.chua_vieng_tham').text(result.data.chua_vieng_tham);
				$('.da_thu_hoi_xe').text(result.data.da_thu_hoi_xe);
				$('.tiep_tuc_tac_dong').text(result.data.tiep_tuc_tac_dong);
				$('.hua_thanh_toan').text(result.data.hua_thanh_toan);
				$('.mat_kha_nang_thanh_toan').text(result.data.mat_kha_nang_thanh_toan);
			}
		});
	})

	$('.push_noti').on('click', function () {
		if (confirm('Bạn có muốn gửi thông báo tới nhân viên?')) {
			let id = $(this).attr('data-id')
			let date = $(this).attr('data-date')
			$.ajax({
				url: _url.base_url + 'debt_manager_app/push_noti_user_debt?contract_id=' + id + '&date=' + date,
				type: "GET",
				dataType: "JSON",
				success: function (result) {
					$("#successModal").modal("show");
					$(".msg_success").text(result.msg);
				}
			});
		}
	})
})

function showLogDebt(id) {
	console.log(id)
	$.ajax({
		url: _url.base_url + 'debt_manager_app/log_debt?contract_id=' + id,
		type: "GET",
		dataType: "JSON",
		success: function (result) {
			console.log(result)
			$('#tbody_debt_log').empty();
			$('#tbody_debt_log').append(result.html);
			$('#tab_debt_log').modal('show');
		}
	});
}

function history_import(id) {
	$.ajax({
		url: _url.base_url + 'Debt_manager_app/showContractFieldLog/' + id,
		type: "GET",
		dataType: "JSON",
		success: function (result) {
			$('#tbody_contract_debt_log').empty();
			$('#tbody_contract_debt_log').append(result.html);

			$('#contract_debt_call_log').modal('show');
		}
	});
}

$(document).ready(function () {
	$('#select_all_contract').click(function () {
		if (this.checked) {
			$('.checkbox_approve').each(function () {
				this.checked = true;
			});
		} else {
			$('.checkbox_approve').each(function () {
				this.checked = false;
			});
		}
	});

	$('.checkbox_approve').click(function () {
		if (!this.checked) {
			$('#select_all_contract').prop('checked', false);
		}
	});
});

function approve_contract_to_field(t) {
	$('#select_all_contract').prop('checked', false);
	var note = $('#approve_note').val();
	var status = $('#choose_status').val();
	$('.list_field_qlkv input:checked').each(function () {
		approve_contract_field($(this).val(), note, status);
	});
	// setTimeout(function () {
	// 	window.location.reload();
	// }, 3000);
}

function approve_contract_field(id, note, status) {
	var formData = {
		contract_field_id: id,
		status: status,
		note: note
	}
	console.log(formData);
	$.ajax({
		url: _url.base_url + 'Debt_manager_app/approve_contract_assigned_field',
		type: 'POST',
		data: formData,
		dataType: 'json',
		async: true,
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			if (response.status == 200) {
				$(".theloading").hide();
				toastr.success(response.msg, {
					timeOut: 3000,
				});
			} else {
				$(".theloading").hide();
				toastr.error(response.msg, {
					timeOut: 3000,
				});
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	});
}

function change_debt_field(t) {
	var id = $(t).data('id');
	var email_debt_field = $(t).val();
	var formData = {
			id: id,
			email_debt_field: email_debt_field
		};
	console.log(formData);
	if (confirm('Xác nhận đổi nhân viên?')) {
		$.ajax({
			url: _url.base_url + 'Debt_manager_app/update_debt_field',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.msg);
					setTimeout(function () {
						$('#successModal').modal('hide');
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
				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 3000);
			}
		});
	} else {
		window.location.reload();
	}
}

$(document).ready(function () {
	$('#select_all_contract_caller').click(function () {
		if (this.checked) {
			$('.checkbox_approve_caller').each(function () {
				this.checked = true;
			});
		} else {
			$('.checkbox_approve_caller').each(function () {
				this.checked = false;
			});
		}
	});

	$('.checkbox_approve_caller').click(function () {
		if (!this.checked) {
			$('#select_all_contract_caller').prop('checked', false);
		}
	});
});

function assigned_contract_back_to_call(t) {
	var checked_data = $('#select_all_contract_caller').prop('checked', false);
	var note = $('#approve_note_caller').val();
	var status = $('#choose_status_caller').val();
	var email_call = $('#choose_email_caller').val();
	$('.datatablebuttoncaller input:checked').each(function () {
		approve_contract_back_to_call($(this).val(), note, status, email_call);
	});

}

function approve_contract_back_to_call(code_contract, note, status, email_call) {
	var formData = {
		code_contract: code_contract,
		status: status,
		note: note,
		email_call: email_call,
	}
	console.log(formData);
	$.ajax({
		url: _url.base_url + 'Debt_manager_app/assigned_contract_back_to_caller',
		type: 'POST',
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			if (response.status == 200) {
				$(".theloading").hide();
				toastr.success(response.msg, {
					timeOut: 3000,
				});
			} else {
				$(".theloading").hide();
				toastr.error(response.msg, {
					timeOut: 3000,
				});
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 2000);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	});
}
