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

$('#borrowed_start').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('#borrowed_end').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('#update_time_borrowed').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('.update_time_borrowed').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('#time_extend_input').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});

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

$('[name="code_contract_disbursement_1[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#code_contract_disbursement_1').val();
	var text = $('#code_contract_disbursement_1').text();
	var data1 = [];
	var data2 = [];
	if (value != null) {
		data1.push(value);
	}
	if (text != null) {
		data2.push(text);
	}
	$('#code_contract_disbursement_value_1').val(JSON.stringify(data1));
	$('#code_contract_disbursement_text_1').val(JSON.stringify(data2));
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

$('#borrowed_start_1').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('#borrowed_end_1').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});


$("#submit_borrowed").click(function (event) {
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
	var lydomuon = $("#lydomuon").val();

	var ghichu = $("#ghichu").val();


	$.ajax({
		url: _url.base_url + '/file_manager/create_borrowed',
		method: "POST",
		data: {
			code_contract_disbursement_value: code_contract_disbursement_value,
			code_contract_disbursement_text: code_contract_disbursement_text,
			file: file,
			giay_to_khac: giay_to_khac,
			groupRoles_store: groupRoles_store,
			borrowed_start: borrowed_start,
			borrowed_end: borrowed_end,
			ghichu: ghichu,
			lydomuon: lydomuon,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Thêm mới thành công');
				sessionStorage.clear()
				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
				}, 3000);
			} else {
				$("#div_errorCreate").css("display", "block");
				$(".div_errorCreate").text(data.msg);
				setTimeout(function () {
					$("#div_errorCreate").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			$(".theloading").hide();
		}
	});
});

function huy_yc_muon_hs(thiz) {
	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_cancel_borrowed").text("Bạn có chắc chắn HỦY yêu cầu mượn hồ sơ hợp đồng " + fileReturn_mhd);

	$("#cancel_borrowed").modal("show");
}

$('#borrowed_cancel').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();

	var formData = new FormData();
	formData.append('fileReturn_id', fileReturn_id);

	$("#cancel_borrowed").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/cancel_borrowed',
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
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				// window.location.href = _url.base_url + 'file_manager/index_borrowed';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function sua_yeu_cau_muon_hs(id) {

	for (let j = 0; j < 10; j++) {
		$('#file_' + j).prop('checked', false)
	}
	$('#selectAll_file_1').prop('checked', false)

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_borrowed/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			check_selectize(result.data.code_contract_disbursement_value[0], 'code_contract_disbursement_1', '');

			$('[name="giay_to_khac_1"]').val(result.data.giay_to_khac);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('[name="ghichu_1"]').val(result.data.ghichu);

			$('[name="groupRoles_store_1"]').val(result.data.groupRoles_store);
			$('[name="lydomuon_1"]').val(result.data.lydomuon);

			$('#borrowed_start_1').val(result.data.borrowed_start)
			$('#borrowed_end_1').val(result.data.borrowed_end)

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
				if ($('#file_10').val() == result.data.file[i]) {
					$('#file_10').prop('checked', true)
				}
				if (result.data.file.length == 10) {
					$('#selectAll_file_1').prop('checked', true)
				}
			}


			$('#editModal_muonhoso').modal('show');
		}
	});
}

function qlhs_xac_nhan_gia_han_muon_hs(id) {

	$('#file_img_approve').empty()

	$.ajax({
		url: _url.base_url + 'file_manager/showExtendBorrowed/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {

			$('#update_time_borrowed_approve').val(result.data.update_time_borrowed)
			$('#lydomuon_25').val(result.data.ghichu)
			$('#fileReturn_id_25').val(result.data.borrowed_id)
			var content = "";

			for (let i = 0; i < result.data.file_img_approve.length; i++) {
				if (result.data.file_img_approve[i].file_type == 'image/jpeg' || result.data.file_img_approve[i].file_type == 'image/png') {
					content += '<div class="block">'
					content += '<a href="' + result.data.file_img_approve[i].path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" data-max-width="992" data-type="image" >';
					content += '<img src="' + result.data.file_img_approve[i].path + '" />';
					content += '</a>';
					content += '</div>'
				}
			}
			$('#file_img_approve').append(content)

			$('#approve_extend_borrowed').modal('show');
		}
	});

}



$("#submit_edit_borrowed").click(function (event) {
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

	var ghichu = $("#ghichu_1").val();
	var lydomuon = $("#lydomuon_1").val();

	var borrowed_start = $("#borrowed_start_1").val();
	var borrowed_end = $("#borrowed_end_1").val();
	var groupRoles_store = $("#groupRoles_store_1").val();

	$.ajax({
		url: _url.base_url + '/file_manager/update_borrowed',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			code_contract_disbursement_value: code_contract_disbursement_value,
			code_contract_disbursement_text: code_contract_disbursement_text,
			file: file,
			giay_to_khac: giay_to_khac,

			ghichu: ghichu,
			borrowed_start: borrowed_start,
			borrowed_end: borrowed_end,
			groupRoles_store: groupRoles_store,
			lydomuon: lydomuon,

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
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
				}, 3000);
			} else {

				$("#div_errorCreate_2").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorCreate_2").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});


function check_selectize(check = null, type, t) {

	$('#' + type).data('selectize').setValue(check);
}

function gui_yc_len_asm(thiz){
	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_asm_borrowed").text("Bạn có chắc chắn yêu cầu MƯỢN hồ sơ hợp đồng " + fileReturn_mhd);

	$("#asm_borrowed").modal("show");

}

$('#borrowed_asm_borrowed').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();

	var formData = new FormData();
	formData.append('fileReturn_id', fileReturn_id);

	$("#asm_borrowed").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/asm_borrowed',
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
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				// window.location.href = _url.base_url + 'file_manager/index_borrowed';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function gui_yc_len_qlhs(thiz){
	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_qlhs_borrowed").text("Bạn có chắc chắn XÁC NHẬN yêu cầu mượn hồ sơ hợp đồng " + fileReturn_mhd);

	$("#qlhs_borrowed").modal("show");

}

/*flow gui TP QLKV duyet YC muon HS*/
function gui_yc_len_tp_qlkv(thiz) {
	let id_borrowed = $(thiz).data('id');
	let code_contract_disbursement = $(thiz).data('mhd');
	$('#id_borrowed').val(id_borrowed);
	$('.code_contract_text').append(code_contract_disbursement);
	$('#send_tp_qlkv').modal('show');
}

// Gửi YC mượn lên TP QLKV
$('#borrowed_send_tp_qlkv').click(function (event) {
	event.preventDefault();
	let id_borrowed = $('#id_borrowed').val();
	let img_file_borrow = {};
	let img_element = $("img[name='img_fileReturn']");
	let note_qlkv = $('#note_qlkv').val();
	let count_img_element = img_element.length;
	if (count_img_element > 0) {
		img_element.each(function () {
			let data = {};
			type = $(this).attr('data-type')
			data['file_type'] = $(this).attr('data-filetype');
			data['file_name'] = $(this).attr('data-filename');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			let key = $(this).attr('data-key');
			if (type == 'file_borrow') {
				img_file_borrow[key] = data;
			}
		});
	}
	let formData = {
		id_borrowed: id_borrowed,
		img_file_borrow: img_file_borrow,
		note_qlkv: note_qlkv
	};
	if (confirm('Xác nhận gửi yêu cầu?')) {
		$.ajax({
			url: _url.base_url + 'File_manager/send_borrowed_to_tp_qlkv',
			data: formData,
			method: 'POST',
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					$('#send_tp_qlkv').modal('hide');
					toastr.success(response.msg)
					setTimeout(function () {
						window.location.reload();
					}, 3000)
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

function tp_qlkv_duyet_yeu_cau(thiz) {
	let id_borrowed = $(thiz).data('id');
	let code_contract_disbursement = $(thiz).data('mhd');
	let note_nv_qlkv = $(thiz).data('note');
	$('.id_borrowed').val(id_borrowed);
	$('.code_contract_text').append(code_contract_disbursement);
	$('.note_qlkv').empty();
	$('.note_nv_qlkv').append(note_nv_qlkv);
	$('#send_borrow_to_qlhs').modal('show');
}

// Gửi YC mượn lên QLHS
$('#borrowed_send_to_qlhs').click(function (event) {
	event.preventDefault();
	let id_borrowed = $('.id_borrowed').val();
	let img_file_borrow = {};
	let img_element = $("img[name='img_fileReturn']");
	let note_qlkv = $('.note_qlkv').val();
	let count_img_element = img_element.length;
	if (count_img_element > 0) {
		img_element.each(function () {
			let data = {};
			type = $(this).attr('data-type')
			data['file_type'] = $(this).attr('data-filetype');
			data['file_name'] = $(this).attr('data-filename');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			let key = $(this).attr('data-key');
			if (type == 'file_borrow') {
				img_file_borrow[key] = data;
			}
		});
	}
	let formData = {
		id_borrowed: id_borrowed,
		img_file_borrow: img_file_borrow,
		note_qlkv: note_qlkv
	};
	if (confirm('Xác nhận gửi yêu cầu?')) {
		$.ajax({
			url: _url.base_url + 'File_manager/send_borrowed_to_qlhs',
			data: formData,
			method: 'POST',
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					$('#send_borrow_to_qlhs').modal('hide');
					toastr.success(response.msg)
					setTimeout(function () {
						window.location.reload();
					}, 3000)
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

$('#borrowed_qlhs_borrowed').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_1 = $('#ghichu_approve_1').val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var file_img_approve = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				file_img_approve[key] = data;
			}

		});
	}

	$("#qlhs_borrowed").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/qlhs_borrowed',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_1,
			file_img_approve: file_img_approve
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				// window.location.href = _url.base_url + 'file_manager/index_borrowed';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});


function tra_yc_muon_qlhs(id) {

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_borrowed/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('#qlhs_trahoso').modal('show');
		}
	});
}

$("#submit_qlhs_trahoso").click(function (event) {
	event.preventDefault();

	var ghichu = $("#ghichu_3").val();

	$.ajax({
		url: _url.base_url + '/file_manager/qlhs_trahoso_borrowed',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			ghichu: ghichu,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			console.log(data)
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');

				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
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
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);

				}
				//Mp3
				else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
					var item = "";
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);
				}
				//Image
				else {
					var content = "";
					content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
					content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn"  data-key="' + data.key + '" src="' + data.path + '" />';
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
	if (confirm("Bạn có chắc chắn muốn xóa ?")) {
		$(thiz_).closest("div .block").remove();
		toastr.success('Xóa thành công!');
	}
}

function xac_nhan_yeu_cau_qlhs(id) {

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_borrowed/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('#approve_borrowed').modal('show');
		}
	});
}

$("#submit_approve_borrowed").click(function (event) {
	event.preventDefault();

	var ghichu = $("#ghichu_4").val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var fileApprove_img = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				fileApprove_img[key] = data;
			}

		});
	}

	$.ajax({
		url: _url.base_url + '/file_manager/approve_borrowed',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			ghichu: ghichu,
			fileApprove_img: fileApprove_img,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			console.log(data)
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');

				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
				}, 3000);
			} else {

				$("#div_errorCreate_4").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorCreate_4").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});


function user_da_nhan_hs(thiz){
	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_danhanhoso").text("Bạn có chắc chắn ĐÃ NHẬN ĐỦ hồ sơ hợp đồng " + fileReturn_mhd);

	$("#danhanhoso").modal("show");

}

$('#borrowed_danhanhoso').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_2 = $('#ghichu_approve_2').val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var file_img_approve = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				file_img_approve[key] = data;
			}

		});
	}

	$("#danhanhoso").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/borrowed_danhanhoso',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_2,
			file_img_approve: file_img_approve
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				// window.location.href = _url.base_url + 'file_manager/index_borrowed';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function chua_nhan_du_ho_so(id) {

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_borrowed/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('#return_borrowed').modal('show');
		}
	});
}

$("#submit_return_borrowed").click(function (event) {
	event.preventDefault();

	var ghichu = $("#ghichu_5").val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var fileReturn_img = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				fileReturn_img[key] = data;
			}

		});
	}

	$.ajax({
		url: _url.base_url + '/file_manager/return_borrowed',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			ghichu: ghichu,
			fileReturn_img: fileReturn_img,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			console.log(data)
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');

				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
				}, 3000);
			} else {

				$("#div_errorCreate_5").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorCreate_5").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

function tra_hs_da_muon(thiz){
	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_trahsdamuon").text("Bạn có chắc chắn TRẢ hồ sơ mượn hợp đồng " + fileReturn_mhd);

	$("#trahsdamuon").modal("show");

}

function tra_hs_cho_kh_tat_toan(thiz){

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_trahskhachhangtattoan").text("Bạn có chắc chắn TRẢ hồ sơ tất toán hợp đồng " + fileReturn_mhd);

	$("#trahskhachhangtattoan").modal("show");

}

function gia_han_thoi_gian_muon(thiz){

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_giahanthoigianmuon").text("Bạn có chắc chắn GIA HẠN thời gian mượn hợp đồng " + fileReturn_mhd);

	$("#giahanthoigianmuon").modal("show");

}

/*Tạo yêu cầu gửi duyệt gia hạn mượn hồ sơ*/
function send_request_approve_extend(thiz) {
	let id_borrow = $(thiz).data("id");
	let code_contract_text = $(thiz).data("mhd");
	$(".id_borrow_extend").val(id_borrow);
	$(".title_giahanthoigianmuon").text("GỦI TRƯỞNG PHÒNG DUYỆT GIA HẠN THỜI GIAN MƯỢN " + code_contract_text);
	$("#send_request_extend_to_tpqlkv").modal("show");
}

$('#send_req_extend_borrow').click(function (event) {
	event.preventDefault();
	let id_borrow = $('.id_borrow_extend').val();
	let note_approve_extend = $('.note_approve_extend').val();
	let time_extend = $('.update_time_borrowed').val();
	let img_element = $("img[name='img_fileReturn']");
	let img_file_borrow = {};
	let count_img = img_element.length;
	if (count_img > 0) {
		img_element.each(function () {
			let data = {};
			type = $(this).attr('data-type')
			data['file_type'] = $(this).attr('data-filetype');
			data['file_name'] = $(this).attr('data-filename');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			let key = $(this).attr('data-key');
			if (type == 'file_borrow') {
				img_file_borrow[key] = data;
			}
		});
	}
	let formData = {
		id_borrow: id_borrow,
		img_file_borrow: img_file_borrow,
		time_extend: time_extend,
		note_approve_extend: note_approve_extend,
	}
	console.log(formData)
	if (confirm('Xác nhận gửi yêu cầu?')) {
		$.ajax({
			url: _url.base_url + 'File_manager/send_request_extend_borrow',
			data: formData,
			method: 'POST',
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					$('#send_request_extend_to_tpqlkv').modal('hide');
					toastr.success(response.msg)
					setTimeout(function () {
						window.location.reload();
					}, 3000)
				} else {
					toastr.error(response.msg);
				}
			},
			error: function (response) {
				$('.theloading').hide();
			}
		});
	}
});


function tp_qlkv_duyet_yeu_cau_gh_muon(thiz) {
	let id_borrow = $(thiz).data('id');
	let code_contract_text = $(thiz).data("mhd");
	let note_suggest = $(thiz).data('note');
	let time_extend = $(thiz).data('extend');
	$(".id_borrow_extend").val(id_borrow);
	$('.time_extend').append(time_extend);
	$('.note_suggest').append(note_suggest);
	$(".title_giahanthoigianmuon").text("DUYỆT YÊU CẦU GIA HẠN MƯỢN HỒ SƠ " + code_contract_text);
	$("#send_request_extend_to_qlhs").modal("show");
}

$('#send_req_extend_to_qlhs').click(function (event) {
	event.preventDefault();
	let id_borrow = $('.id_borrow_extend').val();
	let time_extend = $('#time_extend_input').val();
	let note_extend = $('.note_extend').val();
	let img_element = $("img[name='img_fileReturn']");
	let img_file_borrow = {};
	let count_img = img_element.length;
	if (count_img > 0) {
		img_element.each(function () {
			let data = {};
			type = $(this).attr('data-type')
			data['file_type'] = $(this).attr('data-filetype');
			data['file_name'] = $(this).attr('data-filename');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			let key = $(this).attr('data-key');
			if (type == 'file_borrow') {
				img_file_borrow[key] = data;
			}
		});
	}
	let formData = {
		id_borrow: id_borrow,
		img_file_borrow: img_file_borrow,
		time_extend: time_extend,
		note_extend: note_extend,
	}
	console.log(formData)
	if (confirm('Xác nhận gửi yêu cầu?')) {
		$.ajax({
			url: _url.base_url + 'File_manager/send_request_extend_borrow_to_qlhs',
			data: formData,
			method: 'POST',
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('.theloading').hide();
				if (response.status == 200) {
					$('#send_request_extend_to_qlhs').modal('hide');
					toastr.success(response.msg)
					setTimeout(function () {
						window.location.reload();
					}, 3000)
				} else {
					toastr.error(response.msg);
				}
			},
			error: function (response) {
				$('.theloading').hide();
			}
		});
	}
});

$('#borrowed_trahsdamuon').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_3 = $('#ghichu_approve_3').val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var file_img_approve = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				file_img_approve[key] = data;
			}

		});
	}

	$("#trahsdamuon").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/borrowed_trahsdamuon',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_3,
			file_img_approve: file_img_approve
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				// window.location.href = _url.base_url + 'file_manager/index_borrowed';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

$('#borrowed_trahskhachhangtattoan').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_3 = $('#ghichu_approve_20').val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var file_img_approve = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				file_img_approve[key] = data;
			}

		});
	}

	// $("#trahskhachhangtattoan").modal("hide");
		console.log(fileReturn_id)
		console.log(ghichu_approve_3)
	$.ajax({
		url: _url.base_url + 'file_manager/borrowed_trahskhachhangtattoan',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_3,
			file_img_approve: file_img_approve
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			if (data.data.status == 400){
				console.log(data.data.message)
				$("#div_errorCreate_20").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					$("#div_errorCreate_20").css("display", "none");
				}, 4000);

			} else {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
				}, 3000);
			}

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

$('#borrowed_giahanthoigianmuon').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_25 = $('#ghichu_approve_25').val();
	var update_time_borrowed = $('#update_time_borrowed').val();

	var count = $("img[name='img_fileReturn']").length;
	var file_img_approve = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				file_img_approve[key] = data;
			}
		});
	}

	$.ajax({
		url: _url.base_url + 'file_manager/borrowed_giahanthoigianmuon',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_25,
			file_img_approve: file_img_approve,
			update_time_borrowed: update_time_borrowed
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			if (data.data.status == 400){

				$("#div_errorCreate_25").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					$("#div_errorCreate_25").css("display", "none");
				}, 4000);

			} else {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					window.location.reload();
				}, 3000);
			}

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});


$('#approveExtendBorrowed').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id_25').val();
	var update_time_borrowed_approve = $('#update_time_borrowed_approve').val();

	$.ajax({
		url: _url.base_url + 'file_manager/approveExtendBorrowed',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			update_time_borrowed_approve: update_time_borrowed_approve,
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				window.location.reload();
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});


$('#borrowed_xacnhankhdatattoan').click(function (event) {
	event.preventDefault();
	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_3 = $('#ghichu_approve_21').val();
	//V2
	var thoa_thuan_ba_ben = $("input[name='ttbb_input']").val();
	var bbbg_tai_san = $("input[name='bbbgts_input']").val();
	var dang_ky_xe = $("input[name='dkx_input']").val();
	var thong_bao = $("input[name='tb_input']").val();
	var hd_mua_ban_xe = $("input[name='hdmbx_input']").val();
	var cam_ket = $("input[name='camket_input']").val();
	var bbbg_thiet_bi_dinh_vi = $("input[name='bbbg_tbdv_input']").val();
	var bbh_hoi_dong_co_dong = $("input[name='bbhhdcd_input']").val();
	var hop_dong_mua_ban = $("input[name='hdmb_input']").val();
	var hd_uy_quyen = $("input[name='hduq_input']").val();
	var hd_chuyen_nhuong = $("input[name='hdcn_input']").val();
	var so_do = $("input[name='so_do_input']").val();
	var hd_dat_coc = $("input[name='hddc_input']").val();
	var phu_luc_gia_han = $("input[name='plgh_input']").val();
	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var file_img_approve = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				file_img_approve[key] = data;
			}

		});
	}

	// $("#trahskhachhangtattoan").modal("hide");
	console.log(fileReturn_id)
	console.log(ghichu_approve_3)

	$.ajax({
		url: _url.base_url + 'file_manager/borrowed_xacnhankhdatattoan',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_3,
			file_img_approve: file_img_approve,
			thoa_thuan_ba_ben: thoa_thuan_ba_ben,
			bbbg_tai_san: bbbg_tai_san,
			dang_ky_xe: dang_ky_xe,
			thong_bao: thong_bao,
			hd_mua_ban_xe: hd_mua_ban_xe,
			cam_ket: cam_ket,
			bbbg_thiet_bi_dinh_vi: bbbg_thiet_bi_dinh_vi,
			bbh_hoi_dong_co_dong: bbh_hoi_dong_co_dong,
			hop_dong_mua_ban: hop_dong_mua_ban,
			hd_uy_quyen: hd_uy_quyen,
			hd_chuyen_nhuong: hd_chuyen_nhuong,
			so_do: so_do,
			hd_dat_coc: hd_dat_coc,
			phu_luc_gia_han: phu_luc_gia_han
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
				}, 3000);
			} else {
				console.log(data.msg)
				$("#div_errorCreate_20").css("display", "block");
				$(".div_errorCreate").text(data.msg);

				setTimeout(function () {
					$("#div_errorCreate_20").css("display", "none");
				}, 9000);
			}

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});


function qlhs_xac_nhan_kh_da_tat_toan(thiz){

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");
	console.log(fileReturn_mhd)

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_xacnhankhdatattoan").text("Bạn có chắc chắn Xác Nhận đã tất toán hợp đồng " + fileReturn_mhd);
	$.ajax({
		url: _url.base_url + '/file_manager/get_one_records_return_borrow/' + fileReturn_id,
		method: "POST",
		data: {
			id_records_br: fileReturn_id
		},
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			console.log(response)
			if (response.status == 200) {
				let records = response.data.records_receive;
				console.log(records.thoa_thuan_ba_ben.quantity)
				//Clear data input
				$('#ttbb_input').empty();
				$('#bbbgts_input').empty();
				$('#dkx_input').empty();
				$('#tb_input').empty();
				$('#hdmbx_input').empty();
				$('#camket_input').empty();
				$('#bbbg_tbdv_input').empty();
				$('#bbhhdcd_input').empty();
				$('#hdmb_input').empty();
				$('#hduq_input').empty();
				$('#hdcn_input').empty();
				$('#so_do_input').empty();
				$('#hddc_input').empty();
				$('#plgh_input').empty();
				//Append data to input
				$("input[name='ttbb_input']").val(records.thoa_thuan_ba_ben.quantity);
				$("input[name='bbbgts_input']").val(records.bbbg_tai_san.quantity);
				$("input[name='dkx_input']").val(records.dang_ky_xe.quantity);
				$("input[name='tb_input']").val(records.thong_bao.quantity);
				$("input[name='hdmbx_input']").val(records.hd_mua_ban_xe.quantity);
				$("input[name='camket_input']").val(records.cam_ket.quantity);
				$("input[name='bbbg_tbdv_input']").val(records.bbbg_thiet_bi_dinh_vi.quantity);
				$("input[name='bbhhdcd_input']").val(records.bbh_hoi_dong_co_dong.quantity);
				$("input[name='hdmb_input']").val(records.hop_dong_mua_ban.quantity);
				$("input[name='hduq_input']").val(records.hd_uy_quyen.quantity);
				$("input[name='hdcn_input']").val(records.hd_chuyen_nhuong.quantity);
				$("input[name='so_do_input']").val(records.so_do.quantity);
				$("input[name='hddc_input']").val(records.hd_dat_coc.quantity);
				$("input[name='plgh_input']").val(records.phu_luc_gia_han.quantity);
			}
		},
		error: function () {

		}
	})
	$("#xacnhankhdatattoan").modal("show");


}

function luu_kho(thiz){
	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_luukho").text("Bạn có chắc chắn NHẬN LẠI hồ sơ đã cho mượn hợp đồng " + fileReturn_mhd);

	$("#luukho").modal("show");
}

$('#borrowed_luukho').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_4 = $('#ghichu_approve_4').val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var file_img_approve = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				file_img_approve[key] = data;
			}

		});
	}

	$("#luukho").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/borrowed_luukho',
		type: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_4,
			file_img_approve: file_img_approve
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				// window.location.href = _url.base_url + 'file_manager/index_borrowed';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});



function chua_tra_du_hs(id) {

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_borrowed/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('#chua_tra_hs_da_muon').modal('show');
		}
	});
}

$("#submit_chua_tra_hs_da_muon").click(function (event) {
	event.preventDefault();

	var ghichu = $("#ghichu_6").val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var fileReturn_qlhs_img = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn') {
				fileReturn_qlhs_img[key] = data;
			}

		});
	}

	$.ajax({
		url: _url.base_url + '/file_manager/chua_tra_hs_da_muon',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			ghichu: ghichu,
			fileReturn_qlhs_img: fileReturn_qlhs_img,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			console.log(data)
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');

				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_borrowed';
					window.location.reload();
				}, 3000);
			} else {

				$("#div_errorCreate_6").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorCreate_6").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

$('#code_contract_disbursement').change(function (){

	for (let j = 0; j <= 10; j++) {
		$('#file6_' + j).prop('checked', false)
		$('#file6_' + j).prop('disabled', false)
	}
	$('#selectAll_file').prop('checked', false)


	let code_contract_disbursement = $('#code_contract_disbursement').text();
	console.log(code_contract_disbursement)

	$.ajax({
		url: _url.base_url + '/file_manager/check_file',
		method: "POST",
		data: {
			code_contract_disbursement: code_contract_disbursement,
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.code == 200) {
				let status_borrowed_text = "<i style='color: red;'> (đã được mượn)</i>";
				if (data.data.file) {
					for (let i = 0; i < data.data.file.length; i++) {
						if ($('#file6_1').val() == data.data.file[i]) {
							$('#file6_1').prop('checked', false)
							$("#file6_1").prop("disabled", true);
							$(".file6_1").addClass('stright-through');
							$(".file6_1").append(status_borrowed_text);
						}
						if ($('#file6_2').val() == data.data.file[i]) {
							$('#file6_2').prop('checked', false)
							$("#file6_2").prop("disabled", true);
							$(".file6_2").addClass('stright-through');
							$(".file6_2").append(status_borrowed_text);
						}
						if ($('#file6_3').val() == data.data.file[i]) {
							$('#file6_3').prop('checked', false)
							$("#file6_3").prop("disabled", true);
							$(".file6_3").addClass('stright-through');
							$(".file6_3").append(status_borrowed_text);
						}
						if ($('#file6_4').val() == data.data.file[i]) {
							$('#file6_4').prop('checked', false)
							$("#file6_4").prop("disabled", true);
							$(".file6_4").addClass('stright-through');
							$(".file6_4").append(status_borrowed_text);
						}
						if ($('#file6_5').val() == data.data.file[i]) {
							$('#file6_5').prop('checked', false)
							$("#file6_5").prop("disabled", true);
							$(".file6_5").addClass('stright-through');
							$(".file6_5").append(status_borrowed_text);
						}
						if ($('#file6_6').val() == data.data.file[i]) {
							$('#file6_6').prop('checked', false)
							$("#file6_6").prop("disabled", true);
							$(".file6_6").addClass('stright-through');
							$(".file6_6").append(status_borrowed_text);
						}
						if ($('#file6_7').val() == data.data.file[i]) {
							$('#file6_7').prop('checked', false)
							$("#file6_7").prop("disabled", true);
							$(".file6_7").addClass('stright-through');
							$(".file6_7").append(status_borrowed_text);
						}
						if ($('#file6_8').val() == data.data.file[i]) {
							$('#file6_8').prop('checked', false)
							$("#file6_8").prop("disabled", true);
							$(".file6_8").addClass('stright-through');
							$(".file6_8").append(status_borrowed_text);
						}
						if ($('#file6_9').val() == data.data.file[i]) {
							$('#file6_9').prop('checked', false)
							$("#file6_9").prop("disabled", true);
							$(".file6_9").addClass('stright-through');
							$(".file6_9").append(status_borrowed_text);
						}
						if ($('#file6_10').val() == data.data.file[i]) {
							$('#file6_10').prop('checked', false)
							$("#file6_10").prop("disabled", true);
							$(".file6_10").addClass('stright-through');
							$(".file6_10").append(status_borrowed_text);
						}
						if (data.data.file.length == 10) {
							$('#selectAll_file').prop('checked', false)
						}
						$('#selectAll_file').prop('disabled', true)
					}
				}

			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});



});

