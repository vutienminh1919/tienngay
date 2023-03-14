$(document).ready(function (){


	$('#ctv_phone').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});

	$('#ctv_bank').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});

	$('#ctv_code1').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/ /, "");
		});
	});


	$(".modal_ctv").click(function(event)
	{
		event.preventDefault();

		// $("input[name='ctv_code']").val();
		$("input[name='ctv_name']").val();
		$("input[name='ctv_phone']").val();
		$("input[name='ctv_job']").val();
		$("input[name='ctv_bank_name']").val();
		$("input[name='ctv_bank']").val();

	});

	$(".ctv_close").click(function(event)
	{
		event.preventDefault();

		// $("input[name='ctv_code']").val("");
		$("input[name='ctv_name']").val("");
		$("input[name='ctv_phone']").val("");
		$("input[name='ctv_job']").val("");
		$("input[name='ctv_bank_name']").val("");
		$("input[name='ctv_bank']").val("");


	});

	$("#ctv_btnSave").click(function (event) {
		event.preventDefault();
		// var ctv_code = $("input[name='ctv_code']").val();
		var ctv_name = $("input[name='ctv_name']").val();
		var ctv_phone = $("input[name='ctv_phone']").val();
		var ctv_job = $("input[name='ctv_job']").val();
		var ctv_bank_name = $("input[name='ctv_bank_name']").val();
		var ctv_bank = $("input[name='ctv_bank']").val();

		var formData = new FormData();
		// formData.append('ctv_code', ctv_code);
		formData.append('ctv_name', ctv_name);
		formData.append('ctv_phone', ctv_phone);
		formData.append('ctv_job', ctv_job);
		formData.append('ctv_bank_name', ctv_bank_name);
		formData.append('ctv_bank', ctv_bank);



		$.ajax({
			url: _url.base_url + 'collaborator/insert_collaborator',
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
						window.location.href = _url.base_url + 'collaborator/index_collaborator';
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
function sua_thong_tin(id){

	$.ajax({
		url: _url.base_url + 'collaborator/showUpdate_collaborator/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('#_id').val(result.data.id)
			$('#ctv_code_update').val(result.data.ctv_code)
			$('#ctv_code_update').prop('disabled', true);
			$('#ctv_name_update').val(result.data.ctv_name)
			$('#ctv_phone_update').val(result.data.ctv_phone)
			$('#ctv_job_update').val(result.data.ctv_job)
			$('#ctv_bank_name_update').val(result.data.ctv_bank_name)
			$('#ctv_bank_update').val(result.data.ctv_bank)

			$('#edit_ctv').modal('show');

		}
	});

}

$("#ctv_btn_update").click(function (event) {
	event.preventDefault();

	var ctv_code_update = $("#ctv_code_update").val();
	var ctv_name_update = $("#ctv_name_update").val();
	var ctv_phone_update = $("#ctv_phone_update").val();
	var ctv_job_update = $("#ctv_job_update").val();
	var ctv_bank_name_update = $("#ctv_bank_name_update").val();
	var ctv_bank_update = $("#ctv_bank_update").val();


	$.ajax({
		url: _url.base_url + '/collaborator/update',
		method: "POST",
		data: {
			id: $("#_id").val(),
			ctv_code_update: ctv_code_update,
			ctv_name_update: ctv_name_update,
			ctv_phone_update: ctv_phone_update,
			ctv_job_update: ctv_job_update,
			ctv_bank_name_update: ctv_bank_name_update,
			ctv_bank_update: ctv_bank_update,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			console.log(data)
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Sửa thành công');

				setTimeout(function () {
					window.location.href = _url.base_url + 'collaborator/index_collaborator';
				}, 3000);
			} else {

				$("#div_errorCreate_1").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorCreate_1").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});
