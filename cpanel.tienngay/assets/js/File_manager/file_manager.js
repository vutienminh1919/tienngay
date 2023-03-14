$('#code_contract_disbursement').selectize({
	create: false,
	valueField: 'name',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('#code_contract_disbursement_1').selectize({
	create: false,
	valueField: 'name',
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
	let file_1 = [];
	$(".fileCheckBox_3:checked").each(function () {
		file_1.push($(this).val());
	});
});
$('.fileCheckBox_3').click(function () {
	if (!this.checked) {
		$('#selectAll_file_3').prop('checked', false)
	}
	let file_1 = [];
	$(".fileCheckBox_3:checked").each(function () {
		file_1.push($(this).val());
	});
	// console.log(file);
});



$('#selectAll_file_4').click(function (event) {
	// event.preventDefault();
	if (this.checked) {
		$('.fileCheckBox_4').each(function () {
			this.checked = true;
		});
	} else {
		$('.fileCheckBox_4').each(function () {
			this.checked = false;
		});
	}
	let file_1 = [];
	$(".fileCheckBox_4:checked").each(function () {
		file_1.push($(this).val());
	});
});
$('.fileCheckBox_4').click(function () {
	if (!this.checked) {
		$('#selectAll_file_4').prop('checked', false)
	}
	let file_1 = [];
	$(".fileCheckBox_4:checked").each(function () {
		file_1.push($(this).val());
	});
	// console.log(file);
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
	}
}


$("#submit_fileReturn").click(function (event) {
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
	var taisandikem = $("#taisandikem").val();
	var ghichu = $("#ghichu").val();

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
		url: _url.base_url + '/file_manager/create_file_manager',
		method: "POST",
		data: {
			code_contract_disbursement_value: code_contract_disbursement_value,
			code_contract_disbursement_text: code_contract_disbursement_text,
			file: file,
			giay_to_khac: giay_to_khac,
			taisandikem: taisandikem,
			ghichu: ghichu,
			fileReturn_img: fileReturn_img,

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
					// window.location.href = _url.base_url + 'file_manager/index_file_manager';
					window.location.reload();
				}, 3000);
			} else {

				$("#div_errorCreate").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {

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

function huy_ho_so_gui(thiz) {
	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_cancel").text("Bạn có chắc chắn HỦY yêu cầu gửi hồ sơ hợp đồng " + fileReturn_mhd);

	$("#cancel_fileReturn").modal("show");
}

$('#fileReturn_cancel').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();

	var formData = new FormData();
	formData.append('fileReturn_id', fileReturn_id);

	$("#cancel_fileReturn").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/cancel_fileReturn',
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
				// window.location.href = _url.base_url + 'file_manager/index_file_manager';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function sua_yeu_cau(id) {

	$("#uploads_fileReturn_edit").empty();

	for (let j = 0; j < 10; j++) {
		$('#file_' + j).prop('checked', false)
	}
	$('#selectAll_file_1').prop('checked', false)

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_fileReturn/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			check_selectize(result.data.code_contract_disbursement_text, 'code_contract_disbursement_1', '');

			$('[name="giay_to_khac_1"]').val(result.data.giay_to_khac);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('[name="taisandikem_1"]').val(result.data.taisandikem);

			$('[name="ghichu_1"]').val(result.data.ghichu);

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

			var html = "";

			for (let j = 0; j < result.data.image.length; j++) {
				if (result.data.image[j].file_type == 'image/png' || result.data.image[j].file_type == 'image/jpg' || result.data.image[j].file_type == 'image/jpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='image' data-title='Thông báo'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "' data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "'></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='identify' data-key='" + result.data.image[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'audio/mp3' || result.data.image[j].file_type == 'audio/mpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>" + result.data.image[j].file_name + "</span><img name='img_fileReturn' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "'  data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "' ></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='fileReturn' data-key='" + j + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'video/mp4') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>" + result.data.image[j].file_name + "</span><img name='img_fileReturn' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "'  data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "' ></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='fileReturn' data-key='" + result.data.image[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
			}
			$("#uploads_fileReturn_edit").append(html);

			$('#editFileReturn').modal('show');
		}
	});
}

$("#edit_fileReturn").click(function (event) {
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
	var taisandikem = $("#taisandikem_1").val();
	var ghichu = $("#ghichu_1").val();

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
		url: _url.base_url + '/file_manager/update_fileReturn',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			code_contract_disbursement_value: code_contract_disbursement_value,
			code_contract_disbursement_text: code_contract_disbursement_text,
			file: file,
			giay_to_khac: giay_to_khac,
			taisandikem: taisandikem,
			ghichu: ghichu,
			fileReturn_img: fileReturn_img

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
					// window.location.href = _url.base_url + 'file_manager/index_file_manager';
					window.location.reload();
				}, 3000);
			} else {

				$("#div_errorCreate_100").css("display", "block");
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

function gui_ho_so(thiz) {

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_send_file").text("GỬI HỒ SƠ CỦA HĐ: " + fileReturn_mhd);

	$("#manager_send_file").modal("show");
}

$('#fileReturn_send_file').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();

	var formData = new FormData();
	formData.append('fileReturn_id', fileReturn_id);

	$("#manager_send_file").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/send_file_fileReturn',
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
				// window.location.href = _url.base_url + 'file_manager/index_file_manager';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});


function yeu_cau_bo_sung(id) {

	for (let j = 0; j < 9; j++) {
		$('#file1_' + j).prop('checked', false)
	}
	$('#selectAll_file_2').prop('checked', false)

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_fileReturn/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			check_selectize(result.data.code_contract_disbursement_text, 'code_contract_disbursement_1', '');

			$('[name="giay_to_khac_2"]').val(result.data.giay_to_khac);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('[name="taisandikem_2"]').val(result.data.taisandikem);

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
				if ($('#file1_10').val() == result.data.file[i]) {
					$('#file1_10').prop('checked', true)
				}
				if (result.data.file.length == 10) {
					$('#selectAll_file_2').prop('checked', true)
				}
			}

			$('#bosunghoso').modal('show');
		}
	});
}

$('#submit_bosunghoso').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_qlhs = $('#ghichu_qlhs').val();

	var formData = new FormData();
	formData.append('fileReturn_id', fileReturn_id);
	formData.append('ghichu_qlhs', ghichu_qlhs);

	$("#bosunghoso").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/bosunghoso_fileReturn',
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
				// window.location.href = _url.base_url + 'file_manager/index_file_manager';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});


function gui_bo_sung_ho_so(id){

	$("#uploads_fileReturn_3").empty();

	for (let j = 0; j < 10; j++) {
		$('#file3_' + j).prop('checked', false)
	}
	$('#selectAll_file_3').prop('checked', false)

	$("#file3_1").prop("disabled", false);
	$("#file3_2").prop("disabled", false);
	$("#file3_3").prop("disabled", false);
	$("#file3_4").prop("disabled", false);
	$("#file3_5").prop("disabled", false);
	$("#file3_6").prop("disabled", false);
	$("#file3_7").prop("disabled", false);
	$("#file3_8").prop("disabled", false);
	$("#file3_9").prop("disabled", false);
	$("#file3_10").prop("disabled", false);


	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_fileReturn/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			check_selectize(result.data.code_contract_disbursement_text, 'code_contract_disbursement_1', '');

			$('[name="giay_to_khac_3"]').val(result.data.giay_to_khac);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('[name="taisandikem_3"]').val(result.data.taisandikem);

			$('[name="ghichu_3"]').val(result.data.ghichu);

			for (let i = 0; i < result.data.file.length; i++) {
				if ($('#file3_1').val() == result.data.file[i]) {
					$('#file3_1').prop('checked', true)
					$("#file3_1").prop("disabled", true);
				}
				if ($('#file3_2').val() == result.data.file[i]) {
					$('#file3_2').prop('checked', true)
					$("#file3_2").prop("disabled", true);
				}
				if ($('#file3_3').val() == result.data.file[i]) {
					$('#file3_3').prop('checked', true)
					$("#file3_3").prop("disabled", true);
				}
				if ($('#file3_4').val() == result.data.file[i]) {
					$('#file3_4').prop('checked', true)
					$("#file3_4").prop("disabled", true);
				}
				if ($('#file3_5').val() == result.data.file[i]) {
					$('#file3_5').prop('checked', true)
					$("#file3_5").prop("disabled", true);
				}
				if ($('#file3_6').val() == result.data.file[i]) {
					$('#file3_6').prop('checked', true)
					$("#file3_6").prop("disabled", true);
				}
				if ($('#file3_7').val() == result.data.file[i]) {
					$('#file3_7').prop('checked', true)
					$("#file3_7").prop("disabled", true);
				}
				if ($('#file3_8').val() == result.data.file[i]) {
					$('#file3_8').prop('checked', true)
					$("#file3_8").prop("disabled", true);
				}
				if ($('#file3_9').val() == result.data.file[i]) {
					$('#file3_9').prop('checked', true)
					$("#file3_9").prop("disabled", true);
				}
				if ($('#file3_10').val() == result.data.file[i]) {
					$('#file3_10').prop('checked', true)
					$("#file3_10").prop("disabled", true);
				}
				if (result.data.file.length == 10) {
					$('#selectAll_file_3').prop('checked', true)
				}
			}

			var html = "";

			for (let j = 0; j < result.data.image.length; j++) {
				if (result.data.image[j].file_type == 'image/png' || result.data.image[j].file_type == 'image/jpg' || result.data.image[j].file_type == 'image/jpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='image' data-title='Thông báo'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "' data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "'></a>";
					// html += "<button type='button'  data-type='identify' data-key='" + result.data.image[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'audio/mp3' || result.data.image[j].file_type == 'audio/mpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>" + result.data.image[j].file_name + "</span><img name='img_fileReturn_3' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "'  data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "' ></a>";
					// html += "<button type='button'  data-type='fileReturn' data-key='" + j + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'video/mp4') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>" + result.data.image[j].file_name + "</span><img name='img_fileReturn_3' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "'  data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "' ></a>";
					// html += "<button type='button'  data-type='fileReturn' data-key='" + result.data.image[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
			}
			$("#uploads_fileReturn_3").append(html);

			$('#guibosunghoso').modal('show');
		}
	});
}

$('#submit_guibosunghoso').click(function (event){

	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();

	let file = [];
	$(".fileCheckBox_3:checked").each(function () {
		file.push($(this).val());
	});

	var giay_to_khac = $("#giay_to_khac_3").val();
	var taisandikem = $("#taisandikem_3").val();
	var ghichu = $("#ghichu_3").val();

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
			console.log(type)
			if (type == 'fileReturn') {
				fileReturn_img[key] = data;
			}

		});
	}

	$("#guibosunghoso").modal("hide");

	$.ajax({
		url: _url.base_url + '/file_manager/guibosunghoso_fileReturn',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			file: file,
			giay_to_khac: giay_to_khac,
			taisandikem: taisandikem,
			ghichu: ghichu,
			fileReturn_img: fileReturn_img

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
					// window.location.href = _url.base_url + 'file_manager/index_file_manager';
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

function xac_nhan_yeu_cau(thiz) {

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_approve_file").text("Bạn chắc chắn XÁC NHẬN yêu cầu nhận hồ sơ hợp đồng " + fileReturn_mhd);

	$("#approve_file").modal("show");
}


$('#fileReturn_approve_file').click(function (event) {
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

	$("#approve_file").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/approve_fileReturn',
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
			console.log(data)
			$("#successModal").modal("show");
			$(".msg_success").text('Thành công');
			setTimeout(function () {
				// window.location.href = _url.base_url + 'file_manager/index_file_manager';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function hoan_tat_luu_kho(thiz) {

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_save_file").text("LƯU KHO HỒ SƠ: " + fileReturn_mhd);

	$("#save_file").modal("show");
}

$('#fileReturn_save_file').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_2 = $('#ghichu_approve_2').val();
	//V2
	var thoa_thuan_ba_ben = $('#ttbb_input').val();
	var bbbg_tai_san = $('#bbbgts_input').val();
	var dang_ky_xe = $('#dkx_input').val();
	var thong_bao = $('#tb_input').val();
	var hd_mua_ban_xe = $('#hdmbx_input').val();
	var cam_ket = $('#camket_input').val();
	var bbbg_thiet_bi_dinh_vi = $('#bbbg_tbdv_input').val();
	var bbh_hoi_dong_co_dong = $('#bbhhdcd_input').val();
	var hop_dong_mua_ban = $('#hdmb_input').val();
	var hd_uy_quyen = $('#hduq_input').val();
	var hd_chuyen_nhuong = $('#hdcn_input').val();
	var so_do = $('#so_do_input').val();
	var hd_dat_coc = $('#hddc_input').val();
	var phu_luc_gia_han = $('#plgh_input').val();
	var code_store_rc = $('#code_store_rc').val();

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

	$("#save_file").modal("hide");
	if (confirm("Xác nhận lưu kho hồ sơ?")) {
		$.ajax({
			url: _url.base_url + 'file_manager/save_fileReturn',
			type: "POST",
			data: {
				fileReturn_id: fileReturn_id,
				ghichu: ghichu_approve_2,
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
				phu_luc_gia_han: phu_luc_gia_han,
				code_store_rc: code_store_rc
			},

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (response) {
				console.log(response)
				$(".theloading").hide();
				if (response.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(response.msg);
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(response.msg);
				}
			},
			error: function (response) {
				console.log(response)
				$(".theloading").hide();
			}
		});
	}


});

function qlhs_chua_nhan_hs(thiz) {

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_not_received_file").text("Bạn chắc chắn CHƯA NHẬN hồ sơ hợp đồng " + fileReturn_mhd);

	$("#not_received_file").modal("show");
}

$('#fileReturn_not_received_file').click(function (event) {
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


	$("#not_received_file").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/not_received_fileReturn',
		type: "POST",
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
				// window.location.href = _url.base_url + 'file_manager/index_file_manager';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function yc_tra_hs_sau_tat_toan(thiz) {

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_return_file_v2").text("GỬI YÊU CẦU TRẢ HỒ SƠ CỦA HĐ: " + fileReturn_mhd);

	$("#return_file_v2").modal("show");
}

$('#fileReturn_return_file_v2').click(function (event) {
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


	$("#return_file_v2").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/return_file_v2_fileReturn',
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
			console.log(data)
			$(".theloading").hide();
			// if (status == 200){
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					// window.location.href = _url.base_url + 'file_manager/index_file_manager';
					window.location.reload();
				}, 3000);
			// }
			// else {
			// 	$('#errorModal').modal('show');
			// 	$('.msg_error').text("Hợp đồng chưa được tất toán");
			// 	setTimeout(function () {
			// 		window.location.href = _url.base_url + 'file_manager/index_file_manager';
			// 	}, 3000);
			// }

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function xac_nhan_yeu_cau_tra(id){

	$("#fileReturn_id").val(id);
	$.ajax({
		url: _url.base_url + '/file_manager/get_one_records_return/' + id,
		method: "POST",
		data: {
			id_records: id
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

	$("#xacnhanyeucautra").modal("show");
}

$('#submit_return_v2').click(function (event){
	event.preventDefault();
	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu = $("#ghichu_5").val();
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
	var fileReturn_img_v2 = {};

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
				fileReturn_img_v2[key] = data;
			}
		});
	}
	$.ajax({
		url: _url.base_url + '/file_manager/return_v2_fileReturn',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			ghichu: ghichu,
			fileReturn_img_v2: fileReturn_img_v2,
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
			console.log(data)
			$(".theloading").hide();
			if (data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					window.location.reload();
				}, 3000);
			} else {
				$("#div_errorCreate_5").css("display", "block");
				$(".div_errorCreate").text(data.msg);
				setTimeout(function () {
					$("#div_errorCreate_5").css("display", "none");
				}, 10000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

function yeu_cau_bo_sung_ho_so(id){

	$("#file4_1").prop("disabled", false);
	$("#file4_2").prop("disabled", false);
	$("#file4_3").prop("disabled", false);
	$("#file4_4").prop("disabled", false);
	$("#file4_5").prop("disabled", false);
	$("#file4_6").prop("disabled", false);
	$("#file4_7").prop("disabled", false);
	$("#file4_8").prop("disabled", false);
	$("#file4_9").prop("disabled", false);
	$("#file4_10").prop("disabled", false);
	for (let j = 0; j < 10; j++) {
		$('#file4_' + j).prop('checked', false)
	}
	$('#selectAll_file_4').prop('checked', false)

	$.ajax({
		url: _url.base_url + 'file_manager/showUpdate_fileReturn/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="giay_to_khac_4"]').val(result.data.giay_to_khac);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

			$('[name="taisandikem_4"]').val(result.data.taisandikem);


			for (let i = 0; i < result.data.file.length; i++) {
				if ($('#file4_1').val() == result.data.file[i]) {
					$('#file4_1').prop('checked', true)
					$("#file4_1").prop("disabled", true);
				}
				if ($('#file4_2').val() == result.data.file[i]) {
					$('#file4_2').prop('checked', true)
					$("#file4_2").prop("disabled", true);
				}
				if ($('#file4_3').val() == result.data.file[i]) {
					$('#file4_3').prop('checked', true)
					$("#file4_3").prop("disabled", true);
				}
				if ($('#file4_4').val() == result.data.file[i]) {
					$('#file4_4').prop('checked', true)
					$("#file4_4").prop("disabled", true);
				}
				if ($('#file4_5').val() == result.data.file[i]) {
					$('#file4_5').prop('checked', true)
					$("#file4_5").prop("disabled", true);
				}
				if ($('#file4_6').val() == result.data.file[i]) {
					$('#file4_6').prop('checked', true)
					$("#file4_6").prop("disabled", true);
				}
				if ($('#file4_7').val() == result.data.file[i]) {
					$('#file4_7').prop('checked', true)
					$("#file4_7").prop("disabled", true);
				}
				if ($('#file4_8').val() == result.data.file[i]) {
					$('#file4_8').prop('checked', true)
					$("#file4_8").prop("disabled", true);
				}
				if ($('#file4_9').val() == result.data.file[i]) {
					$('#file4_9').prop('checked', true)
					$("#file4_9").prop("disabled", true);
				}
				if ($('#file4_10').val() == result.data.file[i]) {
					$('#file4_10').prop('checked', true)
					$("#file4_10").prop("disabled", true);
				}
				if (result.data.file.length == 10) {
					$('#selectAll_file_4').prop('checked', true)
				}
			}

			$('#yeucaubosunghs').modal('show');
		}
	});

}

$("#submit_yeucaubosunghs").click(function (event) {
	event.preventDefault();

	let file = [];
	$(".fileCheckBox_4:checked").each(function () {
		file.push($(this).val());
	});

	var giay_to_khac = $("#giay_to_khac_4").val();
	var taisandikem = $("#taisandikem_4").val();
	var ghichu = $("#ghichu_4").val();

	var count = $("img[name='img_fileReturn']").length;
	// console.log(count);
	var fileReturn_img_cvkd = {};

	if (count > 0) {
		$("img[name='img_fileReturn']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'fileReturn_4') {
				fileReturn_img_cvkd[key] = data;
			}

		});
	}

	$.ajax({
		url: _url.base_url + '/file_manager/cvkd_ycbs_fileReturn',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			file: file,
			giay_to_khac: giay_to_khac,
			taisandikem: taisandikem,
			ghichu: ghichu,
			fileReturn_img_cvkd: fileReturn_img_cvkd

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
					// window.location.href = _url.base_url + 'file_manager/index_file_manager';
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


function check_selectize(check = null, type, t) {

	$('#' + type).data('selectize').setValue(check);
}

function da_tra_hs_sau_tat_toan(thiz) {

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_trahososautattoan").text("Bạn chắn chắn xác nhận đã nhận đủ hồ sơ " + fileReturn_mhd + " từ HO ");

	$("#trahososautattoan").modal("show");
}


$('#fileReturn_trahososautattoan').click(function (event) {
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

	$("#trahososautattoan").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/trahososautattoan_fileReturn',
		method: "POST",
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
				// window.location.href = _url.base_url + 'file_manager/index_file_manager';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function tra_ve_yeu_cau_qlhs(thiz) {

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_traveyeucautattoan").text("QLHS trả về yêu cầu trả HS sau tất toán hồ sơ " + fileReturn_mhd + " từ HO ");

	$("#traveyeucautattoan").modal("show");
}

$('#fileReturn_traveyeucautattoan').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();
	var ghichu_approve_5 = $('#ghichu_approve_5').val();

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

	$("#trahososautattoan").modal("hide");

	$.ajax({
		url: _url.base_url + 'file_manager/traveyeucautattoan_fileReturn',
		method: "POST",
		data: {
			fileReturn_id: fileReturn_id,
			ghichu: ghichu_approve_5,
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
				// window.location.href = _url.base_url + 'file_manager/index_file_manager';
				window.location.reload();
			}, 3000);
		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function update_quantity_records(id_records) {
	$('#id_records').val(id_records);
	$.ajax({
		url: _url.base_url + '/file_manager/get_one_records_return/' + id_records,
		method: "POST",
		data: {
			id_records: id_records
		},
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (response) {
			$('.theloading').hide();
			console.log(response)
			if (response.status == 200) {
				let records = response.data.records_receive;
				//Clear data input
				$('#ttbb_update_input').empty();
				$('#bbbgts_update_input').empty();
				$('#dkx_update_input').empty();
				$('#tb_update_input').empty();
				$('#hdmbx_update_input').empty();
				$('#camket_update_input').empty();
				$('#bbbg_tbdv_update_input').empty();
				$('#bbhhdcd_update_input').empty();
				$('#hdmb_update_input').empty();
				$('#hduq_update_input').empty();
				$('#hdcn_update_input').empty();
				$('#so_do_update_input').empty();
				$('#hddc_update_input').empty();
				$('#plgh_update_input').empty();
				$('#code_storage').empty();
				//Append data to input
				$('#ttbb_update_input').val(records.thoa_thuan_ba_ben.quantity);
				$('#bbbgts_update_input').val(records.bbbg_tai_san.quantity);
				$('#dkx_update_input').val(records.dang_ky_xe.quantity);
				$('#tb_update_input').val(records.thong_bao.quantity);
				$('#hdmbx_update_input').val(records.hd_mua_ban_xe.quantity);
				$('#camket_update_input').val(records.cam_ket.quantity);
				$('#bbbg_tbdv_update_input').val(records.bbbg_thiet_bi_dinh_vi.quantity);
				$('#bbhhdcd_update_input').val(records.bbh_hoi_dong_co_dong.quantity);
				$('#hdmb_update_input').val(records.hop_dong_mua_ban.quantity);
				$('#hduq_update_input').val(records.hd_uy_quyen.quantity);
				$('#hdcn_update_input').val(records.hd_chuyen_nhuong.quantity);
				$('#so_do_update_input').val(records.so_do.quantity);
				$('#hddc_update_input').val(records.hd_dat_coc.quantity);
				$('#plgh_update_input').val(records.phu_luc_gia_han.quantity);
				if (response.data.code_store_rc) {
					$('#code_storage').val(response.data.code_store_rc);
				}
			}
		},
		error: function () {

		}
	})
	$('#update_quantity_records').modal("show");
}

$('#submit_update_records').click(function (event) {
	event.preventDefault();
	//V2
	let id_records = $('#id_records').val();
	let note_update = $('#note_records').val();
	let code_storage = $('#code_storage').val();
	let thoa_thuan_ba_ben = $('#ttbb_update_input').val();
	let bbbg_tai_san = $('#bbbgts_update_input').val();
	let dang_ky_xe = $('#dkx_update_input').val();
	let thong_bao = $('#tb_update_input').val();
	let hd_mua_ban_xe = $('#hdmbx_update_input').val();
	let cam_ket = $('#camket_update_input').val();
	let bbbg_thiet_bi_dinh_vi = $('#bbbg_tbdv_update_input').val();
	let bbh_hoi_dong_co_dong = $('#bbhhdcd_update_input').val();
	let hop_dong_mua_ban = $('#hdmb_update_input').val();
	let hd_uy_quyen = $('#hduq_update_input').val();
	let hd_chuyen_nhuong = $('#hdcn_update_input').val();
	let so_do = $('#so_do_update_input').val();
	let hd_dat_coc = $('#hddc_update_input').val();
	let phu_luc_gia_han = $('#plgh_update_input').val();
	let formData = {
		id_records: id_records,
		note_update: note_update,
		code_storage: code_storage,
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
	}
	if (confirm('Xác nhận thay đổi số lượng?')) {
		$.ajax({
			url: _url.base_url + '/file_manager/update_quantity_records',
			method: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (response) {
				$('#update_quantity_records').modal("hide");
				$('.theloading').hide();
				if (response.status == 200) {
					toastr.success(response.msg, {
						timeOut: 3000,
					});
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				} else {
					toastr.error(response.msg, {
						timeOut: 3000,
					});
				}
			},
			error: function (response) {
				$('.theloading').hide();
			}
		})
	}
})

function update_records_origin(id) {
	if (confirm('Xác nhận chuyển hồ sơ gốc về hợp đồng này?')) {
		$.ajax({
			url:_url.base_url + 'File_manager/update_records_origin',
			method: "POST",
			data: {
				id: id
			},
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

			}
		})
	}
}


