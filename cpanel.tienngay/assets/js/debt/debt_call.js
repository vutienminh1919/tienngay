$(document).ready(function () {
	const $menu = $('.dropdown');
	$(document).mouseup(e => {
		if (!$menu.is(e.target)
			&& $menu.has(e.target).length === 0) {
			$menu.removeClass('is-active');
			$('.dropdown-menu').removeClass('show');
		}
	});
	$('.dropdown-toggle').on('click', () => {
		$menu.toggleClass('is-active');
	});
});

function change_debt_caller(t) {
	var id = $(t).data('id');
	var email_debt_caller = $(t).val();
	var formData = new FormData();
	formData.append('id', id);
	formData.append('email_debt_caller', email_debt_caller);

	if (confirm('Xác nhận đổi nhân viên?')) {
		$.ajax({
			url: _url.base_url + 'DebtCall/update_debt_caller',
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

$(document).ready(function () {
	$('#select_all_contract_field').click(function () {
		if (this.checked) {
			$('.checkbox_approve_field').each(function () {
				this.checked = true;
			});
		} else {
			$('.checkbox_approve_field').each(function () {
				this.checked = false;
			});
		}
	});

	$('.checkbox_approve').click(function () {
		if (!this.checked) {
			$('#select_all_contract_field').prop('checked', false);
		}
	});
});

function approve_contract_to_call(t) {
	$('#select_all_contract').prop('checked', false);
	var note = $('#approve_note').val();
	var status = $('#choose_status').val();
	$('.datatablebutton input:checked').each(function () {
		approve_contract_call($(this).val(), note, status);
	});
	// setTimeout(function () {
	//window.location.reload();
	// 			}, 3000);
}

function approve_contract_call(id, note, status) {
	var formData = {
		contract_caller_id: id,
		status: status,
		note: note
	}
	console.log(formData);
	$.ajax({
		url: _url.base_url + 'DebtCall/approve_contract_to_call',
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

function tp_thn_process_field(thiz) {
	let contract_debt_id = $(thiz).data("id");
	$('.contract_debt_id').val(contract_debt_id);
	$('#approve_to_field').modal("show");
}

$('#confirm_to_field').click(function () {
	var contract_id = $('.contract_debt_id').val();
	var status = $("input[name='confirm_call_to_field']:checked").val();
	var note = $('.contract_debt_call_note').val();

	if (confirm('Bạn có chắc chắn gửi xác nhận?')) {
		$.ajax({
			url: _url.base_url + 'DebtCall/approve_to_field',
			method: "POST",
			data: {
				contract_id: contract_id,
				status: status,
				note: note
			},
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text(data.msg);
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.href = _url.base_url + "DebtCall/list_contract_debt_to_field";
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
	} else {
		window.location.reload();
	}
});

function history_processing(id) {
	$.ajax({
		url: _url.base_url + 'DebtCall/showContractDebtLog/' + id,
		type: "GET",
		dataType: "JSON",
		success: function (result) {
			$('#tbody_contract_debt_log').empty();
			$('#tbody_contract_debt_log').append(result.html);

			$('#contract_debt_call_log').modal('show');
		}
	});
}

function update_time_field(thiz) {
	let contract_id = $(thiz).data('id');
	$('.contract_call_id').val(contract_id);
	// $('#update_time_field').val();
	$('#update_setup_time').modal('show');
}

$('#update_time_field_submit').click(function () {
	let contract_call_id = $('.contract_call_id').val();
	let time_field = $('#update_time_field').val();

	var formData = {
		contract_call_id: contract_call_id,
		time_field: time_field,
	}

	if (confirm('Xác nhận thay đổi thời gian chuyển Field cho hợp đồng này!')) {
		$.ajax({
			url: _url.base_url + 'DebtCall/update_time_field',
			type: "POST",
			data: formData,
			dataType: 'JSON',
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				setTimeout(function () {
					$('.theloading').hide();
				}, 1000);
				if (data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 3000)
				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 3000)
				}
			},
			error: function (error) {
				setTimeout(function () {
					$(".theloading").hide();
				}, 1000);
			}
		});
	} else {
		window.location.reload();
	}
});

function set_field(thiz) {

	$('#start_time').empty();
	$('#end_time').empty();

	$.ajax({
		url: _url.base_url + 'DebtCall/getTimeToField',
		type: "GET",
		dataType: "JSON",
		success: function (result) {
			var start_time_convert = new Date(result.data.start_time * 1000).format('Y-m-d');
			var end_time_convert = new Date(result.data.end_time * 1000).format('Y-m-d');
			console.log(start_time_convert);
			$('#start_time').val(start_time_convert);
			$('#end_time').val(end_time_convert);

			$("#time_to_field_modal").modal('show');
		}
	});
}

$("#confirm_setup_time").click(function () {
	var start_time = $("#start_time").val();
	var end_time = $("#end_time").val();
	var formData = {
		start_time: start_time,
		end_time: end_time
	}
	if (confirm("Xác nhận cài đặt thời gian chuyển Field cho hợp đồng?")) {
		$.ajax({
			url: _url.base_url + 'DebtCall/setup_time_to_field_all',
			type: "POST",
			data: formData,
			dataType: "JSON",
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.href = _url.base_url + "DebtCall/mission_caller#tab_content9";
						window.location.reload();
					}, 3000)
				} else {
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (error) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	} else {
		window.location.reload();
	}
});


var hash = window.location.hash;
hash && $('ul.nav a[href="' + hash + '"]').tab('show');

$('.nav-pills a').click(function (e) {
	$(this).tab('show');
	var scrollmem = $('body').scrollTop();
	window.location.hash = this.hash;
	$('html,body').scrollTop(scrollmem);
});

function assigned_contract_to_field(t) {
	var checked_data = $('#select_all_contract_field').prop('checked', false);
	var note = $('#approve_note_field').val();
	var status = $('#choose_status_field').val();
	var email_field = $('#choose_email_field').val();
	$('.datatablebuttonfield input:checked').each(function () {
		approve_contract_call_to_field($(this).val(), note, status, email_field);
	});
	setTimeout(function () {
		window.location.reload();
	}, 3000);
}

function approve_contract_call_to_field(code_contract, note, status, email_field) {
	var formData = {
		code_contract: code_contract,
		status: status,
		note: note,
		email_field: email_field,
	}
	console.log(formData);
	$.ajax({
		url: _url.base_url + 'DebtCall/assigned_contract_to_field',
		type: 'POST',
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			if (response.status == 200) {
				$(".theloading").hide();
				$("#successModal").modal("show");
				$(".msg_success").text("Thành công");
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
