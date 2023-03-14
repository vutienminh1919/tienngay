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

$('#code_contract_disbursement_2').selectize({
	create: false,
	valueField: 'code_contract_disbursement_2',
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



$(document).ready(function () {

	$('#fileReturn_start').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});

	$('#fileReturn_start_1').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});

	$('#fileReturn_start_3').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});



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

		var fileReturn_start = $("#fileReturn_start").val();
		console.log(fileReturn_start)
		$.ajax({
			url: _url.base_url + '/borrowed/create_fileReturn',
			method: "POST",
			data: {
				code_contract_disbursement_value: code_contract_disbursement_value,
				code_contract_disbursement_text: code_contract_disbursement_text,
				file: file,
				giay_to_khac: giay_to_khac,
				fileReturn_start: fileReturn_start,

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
						window.location.href = _url.base_url + 'borrowed/index_fileReturn';
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

});

function editFileReturn(id){

	for (let j = 0; j < 10; j++) {
		$('#file_' + j).prop('checked', false)
	}
	$('#selectAll_file_1').prop('checked', false)

	$.ajax({
		url: _url.base_url + 'borrowed/showUpdate_fileReturn/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			check_selectize(result.data.code_contract_disbursement_value[0], 'code_contract_disbursement_1', '');

			$('[name="fileReturn_start_1"]').val(result.data.fileReturn_start);

			$('[name="giay_to_khac_1"]').val(result.data.giay_to_khac);

			$('[name="fileReturn_id"]').val(result.data._id.$oid);

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

			$('#editFileReturn').modal('show');
		}
	});

}

function check_selectize(check = null, type, t) {

	$('#' + type).data('selectize').setValue(check);
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

	var fileReturn_start = $("#fileReturn_start_1").val();

	$.ajax({
		url: _url.base_url + '/borrowed/update_fileReturn',
		method: "POST",
		data: {
			id: $("#fileReturn_id").val(),
			code_contract_disbursement_value: code_contract_disbursement_value,
			code_contract_disbursement_text: code_contract_disbursement_text,
			file: file,
			giay_to_khac: giay_to_khac,

			fileReturn_start: fileReturn_start,

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
					window.location.href = _url.base_url + 'borrowed/index_fileReturn';
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

function xu_ly_nhan_ho_so(thiz){

	let id = $(thiz).data("id");

	for (let j = 0; j < 10; j++) {
		$('#file1_' + j).prop('checked', false)
	}
	$('#selectAll_file_2').prop('checked', false)


	$.ajax({
		url: _url.base_url + 'borrowed/showUpdate_fileReturn/' + id,
		type: "POST",
		dateType: "JSON",
		success: function (result) {
			console.log(result);
			console.log(result.data.code_contract_disbursement_value[0]);

			check_selectize(result.data.code_contract_disbursement_value[0], 'code_contract_disbursement_2', '');

			$('[name="fileReturn_start_2"]').val(result.data.fileReturn_start);

			$('[name="giay_to_khac_2"]').val(result.data.giay_to_khac);

			$('[name="fileReturn_id_3"]').val(result.data._id.$oid);

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


			$('#xulynhanhoso').modal('show');
		}
	});

}

$('#xulynhanhoso_submit').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id_3').val();

	var fileReturn_start = $("#fileReturn_start_3").val();

	var note = $("#note_3").val();

	$.ajax({
		url: _url.base_url + '/borrowed/approve_fileReturn',
		method: "POST",
		data: {
			id: fileReturn_id,
			fileReturn_start: fileReturn_start,
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
					window.location.href = _url.base_url + 'borrowed/index_fileReturn';
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

function xac_nhan_da_nhan_hs(thiz) {
	$('#uploads_fileReturn').empty();

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id_1").val(fileReturn_id);
	$("#title_confirm").text("Bạn xác nhận đã nhận hồ sơ của hợp đồng " + fileReturn_mhd + " này?");

	$("#confirm_fileReturn").modal("show");
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
	if (confirm("Bạn có chắc chắn muốn xóa ?")){
		$(thiz_).closest("div .block").remove();
	}
}

$('#fileReturn_confirm').click(function (event) {
	event.preventDefault();

	var id_fileReturn = $('#fileReturn_id_1').val();

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

	$("#confirm_fileReturn").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/confirm_fileReturn',
		method: "POST",
		data: {
			id_fileReturn: id_fileReturn,
			fileReturn_img: fileReturn_img,
		},
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Xác nhận thành công');
			setTimeout(function () {
				window.location.href = _url.base_url + 'borrowed/index_fileReturn';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function chua_nhan_duoc_ho_so(thiz){

	let fileReturn_id = $(thiz).data("id");
	let fileReturn_mhd = $(thiz).data("mhd");

	$("#fileReturn_id").val(fileReturn_id);
	$("#title_cancel").text("Bạn có chắc chắn chưa nhận được hồ sơ của mã hợp đồng " + fileReturn_mhd + " này không?");

	$("#cancel_fileReturn").modal("show");

}

$('#fileReturn_cancel').click(function (event) {
	event.preventDefault();

	var fileReturn_id = $('#fileReturn_id').val();

	var formData = new FormData();
	formData.append('fileReturn_id', fileReturn_id);

	$("#cancel_fileReturn").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/cancel_fileReturn',
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
				window.location.href = _url.base_url + 'borrowed/index_fileReturn';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function history_fileReturn(id){

	$('#history_return').empty();

	$.ajax({
		url: _url.base_url + 'borrowed/showLog_fileReturn/' + id,
		type: "POST",
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
					if (content[i].new.giay_to_khac == undefined){
						content[i].new.giay_to_khac = "";
					}
					if (content[i].note == undefined){
						content[i].note = "";
					}
					if (content[i].old.giay_to_khac == undefined){
						content[i].old.giay_to_khac = "";
					}
					if (content[i].new.fileReturn_img == undefined){
						content[i].new.fileReturn_img = "";
					}

					html += "<tr><td>" + content[i].created_at;
					html += "<br>" + content[i].created_by;
					html += "</td>";
					if (content[i].fileReturn != "") {
						console.log("xxx")
						html +=  "<td>" + content[i].fileReturn.status + "</td>";
					} else {
						html +=  "<td>" + content[i].old.status + " -> " + content[i].new.status + "</td>";
					}
					html +=  "<td>" + content[i].note + "</td>";
					if (content[i].file != undefined){
						html +=  "<td>" + content[i].file + "</td>";
					} else if(content[i].new.giay_to_khac != "") {

						html +=  "<td>" + content[i].new.giay_to_khac + "</td>";
					} else if(content[i].old.giay_to_khac != "") {

						html +=  "<td>" + content[i].old.giay_to_khac + "</td>";
					} else {
						html +=  "<td>" + content[i].fileReturn.giay_to_khac + "</td>";
					}

					if (content[i].new.fileReturn_img != ""){

						html += '<td><div id="SomeThing" class="simpleUploader">';
						html += '<div class="uploads " id="">';
						for(var j in content[i].new.fileReturn_img) {
							html += '<div class="block">';
							html += '<a href="' + content[i].new.fileReturn_img[j].path + '"  class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"   >';
							html += '<img class="w-100" src="' + content[i].new.fileReturn_img[j].path + '" />';
							html += '</a>';
							html += '</div>';
						}
						html += '</div></div></td>';
					} else {
						html += '<td></td>'
					}

					html += "</tr>";
				}
				$("#history_return").append(html);

			}
			$('#history_fileReturn').modal('show');
		}
	});


}



