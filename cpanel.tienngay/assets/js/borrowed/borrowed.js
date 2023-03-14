$('#code_contract_disbursement_1').selectize({
	create: false,
	valueField: 'code_contract_disbursement_1',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});
$(document).ready(function () {
	$('#code_contract_disbursement').selectize({
		create: false,
		valueField: 'code_contract_disbursement',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});



	$('[name="code_contract_disbursement[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#code_contract_disbursement').val();
		var text = $('#code_contract_disbursement').text();
		var data1 = [];
		var data2 = [];
		if (value != null) {
			data1.push(value);
		}
		if (text != null) {
			data2.push(text);
		}
		$('#code_contract_disbursement_value').val(JSON.stringify(data1));
		$('#code_contract_disbursement_text').val(JSON.stringify(data2));
	})

	$('#borrowed_start').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});
	$('#borrowed_end').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});
	$('#borrowed_end_3').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});


	$('#selectAll_file').click(function (event) {
		// event.preventDefault();
		if (this.checked) {
			$('.fileCheckBox').each(function () {
				this.checked = true;
			});
		} else {
			$('.fileCheckBox').each(function () {
				this.checked = false;
			});
		}
		let file = [];
		$(".fileCheckBox:checked").each(function () {
			file.push($(this).val());
		});
	});
	$('.fileCheckBox').click(function () {
		if (!this.checked) {
			$('#selectAll_file').prop('checked', false)
		}
		let file = [];
		$(".fileCheckBox:checked").each(function () {
			file.push($(this).val());
		});
		// console.log(file);
	});

	// $('#giay_to_khac').click(function () {
	// 	console.log("xxx");
	// 	if (!this.checked){
	// 		$('#giay_to_khac_show').hide();
	// 		$('#giay_to_khac_show').val("");
	// 	}
	// 	if (this.checked){
	// 		$('#giay_to_khac_show').show();
	// 	}
	//
	// 	// console.log(file);
	// });


	$("#submit_file").click(function (event) {
		event.preventDefault();

		if ($('#code_contract_disbursement_value').val() != "") {
			var code_contract_disbursement_value = JSON.parse($('#code_contract_disbursement_value').val());
		}
		if ($('#code_contract_disbursement_text').val() != "") {
			var code_contract_disbursement_text = JSON.parse($('#code_contract_disbursement_text').val());
		}
		let file = [];
		$(".fileCheckBox:checked").each(function () {
			file.push($(this).val());
		});

		var giay_to_khac = $("#giay_to_khac").val();
		var borrowed_start = $("#borrowed_start").val();
		var borrowed_end = $("#borrowed_end").val();
		var groupRoles_store = $("#groupRoles_store").val();
		var note = $("#note").val();

		$.ajax({
			url: _url.base_url + '/borrowed/create_borrowed',
			method: "POST",
			data: {
				code_contract_disbursement_value: code_contract_disbursement_value,
				code_contract_disbursement_text: code_contract_disbursement_text,
				file: file,
				groupRoles_store: groupRoles_store,
				giay_to_khac: giay_to_khac,
				borrowed_start: borrowed_start,
				borrowed_end: borrowed_end,
				note: note,
			},

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.data.status == 200) {
					console.log("xxx");
					$("#successModal").modal("show");
					$(".msg_success").text('Thêm mới thành công');
					sessionStorage.clear()
					setTimeout(function () {
						window.location.href = _url.base_url + 'borrowed/index_borrowed';
					}, 3000);
				} else {

					// $('#errorModal').modal('show');
					// $('.msg_error').text(data.data.message);
					$("#div_errorCreate").css("display", "block");
					$(".div_errorCreate").text(data.data.message);
					// window.scrollTo(0, 0);
					//
					setTimeout(function () {
						// $('#errorModal').modal('hide');
						$("#div_errorCreate").css("display", "none");
					}, 4000);
				}
			},
			error: function (data) {
				console.log("xxx");
				$(".theloading").hide();
			}
		});
	});



	$('[name="code_contract_disbursement_1[]"]').on('change', function (event) {
		event.preventDefault();
		var value1 = $('#code_contract_disbursement_1').val();
		var text = $('#code_contract_disbursement_1').text();
		var data1 = [];
		var data2 = [];
		if (value1 != null) {
			data1.push(value1);
		}
		if (text != null) {
			data2.push(text);
		}
		$('#code_contract_disbursement_value_1').val(JSON.stringify(data1));
		$('#code_contract_disbursement_text_1').val(JSON.stringify(data2));
	})
	$('#code_contract_disbursement_2').selectize({
		create: false,
		valueField: 'code_contract_disbursement_1',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

	$('[name="code_contract_disbursement_2[]"]').on('change', function (event) {
		event.preventDefault();
		var value1 = $('#code_contract_disbursement_2').val();
		var text = $('#code_contract_disbursement_2').text();
		var data1 = [];
		var data2 = [];
		if (value1 != null) {
			data1.push(value1);
		}
		if (text != null) {
			data2.push(text);
		}
		$('#code_contract_disbursement_value_2').val(JSON.stringify(data1));
		$('#code_contract_disbursement_text_2').val(JSON.stringify(data2));
	})

	$('#borrowed_start_1').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});
	$('#borrowed_end_1').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});
	$('#selectAll_file_1').click(function (event) {
		// event.preventDefault();
		if (this.checked) {
			$('.fileCheckBox_1').each(function () {
				this.checked = true;
			});
		} else {
			$('.fileCheckBox_1').each(function () {
				this.checked = false;
			});
		}
		let file_1 = [];
		$(".fileCheckBox_1:checked").each(function () {
			file_1.push($(this).val());
		});
	});
	$('.fileCheckBox_1').click(function () {
		if (!this.checked) {
			$('#selectAll_file_1').prop('checked', false)
		}
		let file_1 = [];
		$(".fileCheckBox_1:checked").each(function () {
			file_1.push($(this).val());
		});
		// console.log(file);
	});
	$('#selectAll_file_3').click(function (event) {
		// event.preventDefault();
		if (this.checked) {
			$('.fileCheckBox_3').each(function () {
				this.checked = true;
			});
		} else {
			$('.fileCheckBox_3').each(function () {
				this.checked = false;
			});
		}
		let file_3 = [];
		$(".fileCheckBox_3:checked").each(function () {
			file_3.push($(this).val());
		});
	});
	$('.fileCheckBox_3').click(function () {
		if (!this.checked) {
			$('#selectAll_file_3').prop('checked', false)
		}
		let file_3 = [];
		$(".fileCheckBox_3:checked").each(function () {
			file_3.push($(this).val());
		});
		// console.log(file);
	});


});


function editBorrowed(id) {
	for (let j = 0; j < 9; j++) {
		$('#file_' + j).prop('checked', false)
	}
	$('#selectAll_file_1').prop('checked', false)

	$.ajax({
		url: _url.base_url + 'borrowed/showUpdate/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			check_selectize(result.data.code_contract_disbursement_value[0], 'code_contract_disbursement_1', '');

			$('[name="borrowed_start_1"]').val(result.data.borrowed_start);
			$('[name="borrowed_end_1"]').val(result.data.borrowed_end);
			$('[name="giay_to_khac_1"]').val(result.data.giay_to_khac);
			$("textarea[name='note_1']").val(result.data.note);

			$('[name="borrowed_id"]').val(result.data._id.$oid);

			for (let i = 0; i < result.data.file.length; i++) {
				if ($('#file_1').val() == result.data.file[i]) {
					$('#file_1').prop('checked', true)
				}
				if ($('#file_2').val() == result.data.file[i]) {
					$('#file_2').prop('checked', true)
				}
				if ($('#file_3').val() == result.data.file[i]) {
					$('#file_3').prop('checked', true)
				}
				if ($('#file_4').val() == result.data.file[i]) {
					$('#file_4').prop('checked', true)
				}
				if ($('#file_5').val() == result.data.file[i]) {
					$('#file_5').prop('checked', true)
				}
				if ($('#file_6').val() == result.data.file[i]) {
					$('#file_6').prop('checked', true)
				}
				if ($('#file_7').val() == result.data.file[i]) {
					$('#file_7').prop('checked', true)
				}
				if ($('#file_8').val() == result.data.file[i]) {
					$('#file_8').prop('checked', true)
				}
				if ($('#file_9').val() == result.data.file[i]) {
					$('#file_9').prop('checked', true)
				}
				if (result.data.file.length == 9) {
					$('#selectAll_file_1').prop('checked', true)
				}
			}

			$('#editBorrowed').modal('show');
		}
	});

}

function check_selectize(check = null, type, t) {

	$('#' + type).data('selectize').setValue(check);
}

$("#edit_file").click(function (event) {
	event.preventDefault();

	if ($('#code_contract_disbursement_value_1').val() != "") {
		var code_contract_disbursement_value = JSON.parse($('#code_contract_disbursement_value_1').val());
	}
	if ($('#code_contract_disbursement_text_1').val() != "") {
		var code_contract_disbursement_text = JSON.parse($('#code_contract_disbursement_text_1').val());
	}
	let file = [];
	$(".fileCheckBox_1:checked").each(function () {
		file.push($(this).val());
	});

	var giay_to_khac = $("#giay_to_khac_1").val();
	var borrowed_start = $("#borrowed_start_1").val();
	var borrowed_end = $("#borrowed_end_1").val();
	var note = $("#note_1").val();

	$.ajax({
		url: _url.base_url + '/borrowed/update_borrowed',
		method: "POST",
		data: {
			id: $("#borrowed_id").val(),
			code_contract_disbursement_value: code_contract_disbursement_value,
			code_contract_disbursement_text: code_contract_disbursement_text,
			file: file,
			giay_to_khac: giay_to_khac,
			borrowed_start: borrowed_start,
			borrowed_end: borrowed_end,
			note: note,
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
					window.location.href = _url.base_url + 'borrowed/index_borrowed';
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

function huy_muon(thiz) {
	let borrowed_id = $(thiz).data("id");
	let borrowed_mhd = $(thiz).data("mhd");

	$("#borrowed_id").val(borrowed_id);
	$("#title_cancel").text("Bạn có chắc chắn hủy mượn hồ sơ của mã hợp đồng " + borrowed_mhd + " này không?");

	$("#cancel_borrowed").modal("show");
}

function xac_nhan_da_cho_muon(thiz) {
	$('#uploads_borrowed').empty();


	let borrowed_id = $(thiz).data("id");
	let borrowed_mhd = $(thiz).data("mhd");

	$("#borrowed_id_1").val(borrowed_id);
	$("#title_confirm").text("Bạn xác nhận đã cho mượn hồ sơ của mã hợp đồng " + borrowed_mhd + " này?");

	$("#confirm_borrowed").modal("show");
}



function xac_nhan_da_tra(thiz) {
	$('#uploads_borrowed_dt').empty();

	let borrowed_id = $(thiz).data("id");
	let borrowed_mhd = $(thiz).data("mhd");

	$("#borrowed_id_5").val(borrowed_id);
	$("#title5_confirm").text("Bạn xác nhận PGD đã trả hồ sơ của mã hợp đồng " + borrowed_mhd + " này?");

	$("#paid_borrowed").modal("show");
}


$('input[type=file]').change(function () {
	var contain = $(this).data("contain");
	var title = $(this).data("title");
	var type = $(this).data("type");
	var contractId = $("#contract_id").val();
	$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
		// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
		allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
		//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
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
				//Video Mp4
				if (fileType == 'video/mp4') {
					var item = "";
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);

				}
				//Mp3
				else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
					var item = "";
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);
				}
				//Image
				else {
					var content = "";
					content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
					content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" />';
					content += '</a>';
					content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(content);
					this.block.append(data);
				}
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

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	// var res = confirm("Bạn có chắc chắn muốn xóa");
	if (confirm("Bạn có chắc chắn muốn xóa ?")){
		$(thiz_).closest("div .block").remove();
	}
}


function yeu_cau_tra_ho_so(thiz) {
	let borrowed_id = $(thiz).data("id");
	let code_mhd = $(thiz).data("mhd");

	$("#borrowed_id_4").val(borrowed_id);
	$("#code_mhd").val(code_mhd);

	$("#pay_borrowed").modal("show");
}



function xu_ly_cho_muon_asm(thiz) {
	let borrowed_id = $(thiz).data("id");
	let borrowed_mhd = $(thiz).data("mhd");

	$("#borrowed_id_asm").val(borrowed_id);
	$("#title_approval_asm").text("Bạn có xác nhận cho mượn hồ sơ của mã hợp đồng " + borrowed_mhd + " này không?");

	$("#approval_borrowed_asm").modal("show");
}

$('#borrowed_cancel_asm').click(function (event) {
	event.preventDefault();

	var id_borrowed = $('#borrowed_id_asm').val();

	var formData = new FormData();
	formData.append('id_borrowed', id_borrowed);

	$("#approval_borrowed_asm").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/approve_borrowed_asm',
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

			if (data.data.status == 400){
				$('#errorModal').modal('show');
				$('.msg_error').text(data.data.return.message);
				setTimeout(function () {
					window.location.href = _url.base_url + 'borrowed/index_borrowed';
				}, 3000);
			} else {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					window.location.href = _url.base_url + 'borrowed/index_borrowed';
				}, 3000);
			}

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});


$('#borrowed_cancel').click(function (event) {
	event.preventDefault();

	var id_borrowed = $('#borrowed_id').val();

	var formData = new FormData();
	formData.append('id_borrowed', id_borrowed);

	$("#cancel_borrowed").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/cancel_borrowed',
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

			$("#successModal").modal("show");
			$(".msg_success").text('Hủy thành công');
			setTimeout(function () {
				window.location.href = _url.base_url + 'borrowed/index_borrowed';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function xu_ly_cho_muon(thiz) {
	let id = $(thiz).data("id");

	for (let j = 0; j < 9; j++) {
		$('#file1_' + j).prop('checked', false)
	}
	$('#selectAll_file_2').prop('checked', false)

	for (let k = 0; k < 9; k++) {
		$('#file2_' + k).prop('checked', false)
	}
	$('#selectAll_file_3').prop('checked', false)

	$.ajax({
		url: _url.base_url + 'borrowed/showUpdate/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			check_selectize(result.data.code_contract_disbursement_value[0], 'code_contract_disbursement_2', '');

			$('[name="borrowed_start_2"]').val(result.data.borrowed_start);
			$('[name="borrowed_end_2"]').val(result.data.borrowed_end);
			$('[name="giay_to_khac_2"]').val(result.data.giay_to_khac);
			$("textarea[name='note_2']").val(result.data.note);


			$('[name="borrowed_end_3"]').val(result.data.borrowed_end);
			$('[name="giay_to_khac_3"]').val(result.data.giay_to_khac);
			$("textarea[name='note_3']").val(result.data.note);


			$('[name="borrowed_id_3"]').val(result.data._id.$oid);

			for (let i = 0; i < result.data.file.length; i++) {
				if ($('#file1_1').val() == result.data.file[i]) {
					$('#file1_1').prop('checked', true)
				}
				if ($('#file1_2').val() == result.data.file[i]) {
					$('#file1_2').prop('checked', true)
				}
				if ($('#file1_3').val() == result.data.file[i]) {
					$('#file1_3').prop('checked', true)
				}
				if ($('#file1_4').val() == result.data.file[i]) {
					$('#file1_4').prop('checked', true)
				}
				if ($('#file1_5').val() == result.data.file[i]) {
					$('#file1_5').prop('checked', true)
				}
				if ($('#file1_6').val() == result.data.file[i]) {
					$('#file1_6').prop('checked', true)
				}
				if ($('#file1_7').val() == result.data.file[i]) {
					$('#file1_7').prop('checked', true)
				}
				if ($('#file1_8').val() == result.data.file[i]) {
					$('#file1_8').prop('checked', true)
				}
				if ($('#file1_9').val() == result.data.file[i]) {
					$('#file1_9').prop('checked', true)
				}
				if (result.data.file.length == 9) {
					$('#selectAll_file_2').prop('checked', true)
				}
			}
			for (let i = 0; i < result.data.file.length; i++) {
				if ($('#file3_1').val() == result.data.file[i]) {
					$('#file3_1').prop('checked', true)
				}
				if ($('#file3_2').val() == result.data.file[i]) {
					$('#file3_2').prop('checked', true)
				}
				if ($('#file3_3').val() == result.data.file[i]) {
					$('#file3_3').prop('checked', true)
				}
				if ($('#file3_4').val() == result.data.file[i]) {
					$('#file3_4').prop('checked', true)
				}
				if ($('#file3_5').val() == result.data.file[i]) {
					$('#file3_5').prop('checked', true)
				}
				if ($('#file3_6').val() == result.data.file[i]) {
					$('#file3_6').prop('checked', true)
				}
				if ($('#file3_7').val() == result.data.file[i]) {
					$('#file3_7').prop('checked', true)
				}
				if ($('#file3_8').val() == result.data.file[i]) {
					$('#file3_8').prop('checked', true)
				}
				if ($('#file3_9').val() == result.data.file[i]) {
					$('#file3_9').prop('checked', true)
				}
				if (result.data.file.length == 9) {
					$('#selectAll_file_3').prop('checked', true)
				}
			}

			$('#xulychomuon').modal('show');
		}
	});
}

$('#xulychomuon_submit').click(function (event) {
	event.preventDefault();

	var id_borrowed = $('#borrowed_id_3').val();

	let file = [];
	$(".fileCheckBox_3:checked").each(function () {
		file.push($(this).val());
	});

	var giay_to_khac = $("#giay_to_khac_3").val();
	var borrowed_end = $("#borrowed_end_3").val();
	var borrowed_start = $("#borrowed_start_2").val();
	var note = $("#note_3").val();

	$.ajax({
		url: _url.base_url + '/borrowed/approve_borrowed',
		method: "POST",
		data: {
			id: id_borrowed,
			file: file,
			giay_to_khac: giay_to_khac,
			borrowed_end: borrowed_end,
			borrowed_start: borrowed_start,
			note: note,
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			console.log(data)
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Xác nhận thành công');

				setTimeout(function () {
					window.location.href = _url.base_url + 'borrowed/index_borrowed';
				}, 3000);
			} else {

				$("#div_errorCreate_3").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorCreate_3").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});

});

$('#borrowed_confirm').click(function (event) {
	event.preventDefault();

	var id_borrowed = $('#borrowed_id_1').val();

	var count = $("img[name='img_borrowed']").length;
	// console.log(count);
	var borrowed_img = {};

	if (count > 0) {
		$("img[name='img_borrowed']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'borrowed') {
				borrowed_img[key] = data;
			}

		});
	}


	// var formData = new FormData();
	// formData.append('id_borrowed', id_borrowed);
	// formData.append('borrowed_img', borrowed_img);

	$("#confirm_borrowed").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/confirm_borrowed',
		// type: "POST",
		// data: formData,
		// dataType: 'json',
		// processData: false,
		// contentType: false,
		method: "POST",
		data: {
			id_borrowed: id_borrowed,

			borrowed_img: borrowed_img,

		},
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Xác nhận cho mượn thành công');
			setTimeout(function () {
				window.location.href = _url.base_url + 'borrowed/index_borrowed';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

$('#pay_borrowed_submit').click(function (event) {
	event.preventDefault();

	var id_borrowed = $('#borrowed_id_4').val();
	var note = $('#note_4').val();

	var formData = new FormData();
	formData.append('id_borrowed', id_borrowed);
	formData.append('note', note);

	$("#pay_borrowed").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/pay_borrowed',
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

			$("#successModal").modal("show");
			$(".msg_success").text('Xác nhận yêu cầu thành công');
			setTimeout(function () {
				window.location.href = _url.base_url + 'borrowed/index_borrowed';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

$('#paid_borrowed_submit').click(function (event) {
	event.preventDefault();

	var id_borrowed = $('#borrowed_id_5').val();

	var count = $("img[name='img_borrowed']").length;
	// console.log(count);
	var borrowed_img = {};

	if (count > 0) {
		$("img[name='img_borrowed']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'borrowed') {
				borrowed_img[key] = data;
			}

		});
	}

	// var formData = new FormData();
	// formData.append('id_borrowed', id_borrowed);

	$("#paid_borrowed").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/paid_borrowed',
		// type: "POST",
		// data: formData,
		// dataType: 'json',
		// processData: false,
		// contentType: false,
		method: "POST",
		data: {
			id_borrowed: id_borrowed,

			borrowed_img: borrowed_img,

		},
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Xác nhận đã nhận lại hồ sơ thành công');
			setTimeout(function () {
				window.location.href = _url.base_url + 'borrowed/index_borrowed';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function history_borrowed(id) {
	$('#history_ycmhs').empty();

	$.ajax({
		url: _url.base_url + 'borrowed/showLog/' + id,
		type: "GET",
		dateType: "JSON",
		beforeSend: function () {
			$("#theloading").show();
		},
		success: function (result) {
			console.log(result);
			$("#theloading").hide();
			if (result.code == 200) {
				let html = "";
				let content = result.data;
				console.log(content)

				for (var i = 0; i < content.length; i++) {

					if (content[i].note == undefined){
						content[i].note = "";
					}
					if (content[i].old.giay_to_khac == undefined){
						content[i].old.giay_to_khac = "";
					}
					if (content[i].new.giay_to_khac == undefined){
						content[i].new.giay_to_khac = "";
					}
					if (content[i].new.borrowed_img == undefined){
						content[i].new.borrowed_img = "";
					}

					html += "<tr><td>" + content[i].created_at;
					html += "<br>" + content[i].created_by;
					html += "</td>";
					if (content[i].borrowed != "" ) {
						console.log("xxx")
						html +=  "<td>" + content[i].borrowed.status + "</td>";
					} else {
						html +=  "<td>" + content[i].old.status + " -> " + content[i].new.status + "</td>";
					}
					html +=  "<td>" + content[i].note + "</td>";
					if (content[i].file != undefined){
						html +=  "<td>" + content[i].file + "</td>";
					} else if(content[i].new.giay_to_khac != "") {
						html +=  "<td>" + content[i].new.giay_to_khac + "</td>";
					} else {
						html +=  "<td>" + content[i].old.giay_to_khac + "</td>";
					}

					if (content[i].new.borrowed_img != ""){
						html += '<td><div id="" class="simpleUploader">';
						html += '<div class="uploads " id="">';
						for(var j in content[i].new.borrowed_img) {
							html += '<div class="block">';
							html += '<a href="' + content[i].new.borrowed_img[j].path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-max-width="992" data-type="image" >';
							html += '<img data-fileType="' + content[i].new.borrowed_img[j].file_type + '" data-fileName="' + content[i].new.borrowed_img[j].file_name + '" name="img_borrowed"  data-key="' + content[i].new.borrowed_img[j].key + '" src="' + content[i].new.borrowed_img[j].path + '" />';
							html += '</a>';
							html += '</div>';
						}
						html += '</div></div></td>';
					} else {
						html += '<td></td>'
					}
					html += "</tr>";
				}
				$("#history_ycmhs").append(html);

			}
			$('#history_yeucaumuonhoso').modal('show');
		}
	});



}



