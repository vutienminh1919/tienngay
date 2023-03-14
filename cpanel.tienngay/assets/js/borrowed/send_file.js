$(document).ready(function (){

	$('#store_take').selectize({
		create: false,
		valueField: 'store_take',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#van_phong_pham').selectize({
		create: false,
		valueField: 'van_phong_pham',
		labelField: 'name',
		searchField: 'name',
		maxItems: 50,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#cong_cu').selectize({
		create: false,
		valueField: 'cong_cu',
		labelField: 'name',
		searchField: 'name',
		maxItems: 50,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

	$('[name="store_take[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#store_take').val();
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#store_take_value').val(JSON.stringify(data1));
	});

	$('[name="van_phong_pham[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#van_phong_pham').val();
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#van_phong_pham_value').val(JSON.stringify(data1));
	});

	$('[name="cong_cu[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#cong_cu').val();
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#cong_cu_value').val(JSON.stringify(data1));
	});

	$('#send_start').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});
	$('#send_end').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
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
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_send_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);

				}
				//Mp3
				else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
					var item = "";
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_send_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);
				}
				//Image
				else {
					var content = "";
					content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
					content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_send_file"  data-key="' + data.key + '" src="' + data.path + '" />';
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

$("#submit_send_file").click(function (event) {
	event.preventDefault();

	if ($('#store_take_value').val() != "") {
		var store_take_value = JSON.parse($('#store_take_value').val());
	}
	if ($('#van_phong_pham_value').val() != "") {
		var van_phong_pham_value = JSON.parse($('#van_phong_pham_value').val());
	}
	if ($('#cong_cu_value').val() != "") {
		var cong_cu_value = JSON.parse($('#cong_cu_value').val());
	}

	var send_start = $("#send_start").val();
	var send_end = $("#send_end").val();
	var note = $("#note").val();

	var count = $("img[name='img_send_file']").length;
	// console.log(count);
	var img_send_file = {};

	if (count > 0) {
		$("img[name='img_send_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'send_file') {
				img_send_file[key] = data;
			}

		});
	}

	$.ajax({
		url: _url.base_url + '/borrowed/create_sendFile',
		method: "POST",
		data: {
			store_take_value: store_take_value,
			van_phong_pham_value: van_phong_pham_value,
			cong_cu_value: cong_cu_value,
			send_start: send_start,
			send_end: send_end,
			note: note,
			img_send_file: img_send_file,
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
					window.location.href = _url.base_url + 'borrowed/index_sendFile';
				}, 3000);
			} else {

				$("#div_errorCreate").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

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

$('#store_take_1').selectize({
	create: false,
	valueField: 'store_take_1',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

function check_selectize(check = null, type, t) {
	$('#' + type).data('selectize').setValue(check);
}

$(document).ready(function (){

	$('#store_take_1').selectize({
		create: false,
		valueField: 'store_take_1',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#van_phong_pham_1').selectize({
		create: false,
		valueField: 'van_phong_pham_1',
		labelField: 'name',
		searchField: 'name',
		maxItems: 50,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#cong_cu_1').selectize({
		create: false,
		valueField: 'cong_cu_1',
		labelField: 'name',
		searchField: 'name',
		maxItems: 50,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

	$('[name="store_take_1[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#store_take_1').val();
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#store_take_value_1').val(JSON.stringify(data1));
	});

	$('[name="van_phong_pham_1[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#van_phong_pham_1').val();
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#van_phong_pham_value_1').val(JSON.stringify(data1));
	});

	$('[name="cong_cu_1[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#cong_cu_1').val();
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#cong_cu_value_1').val(JSON.stringify(data1));
	});

	$('#send_start_1').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});
	$('#send_end_1').datetimepicker({
		format: 'DD-MM-YYYY',
		minDate: new Date
	});


});

function editSendFile(id){

	$("#uploads_send_file_1").empty();

	$.ajax({
		url: _url.base_url + 'borrowed/showUpdate_sendFile/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);
			check_selectize(result.data.store_take_value[0], 'store_take_1', '');
			check_selectize(result.data.van_phong_pham_value[0], 'van_phong_pham_1', '');
			check_selectize(result.data.cong_cu_value[0], 'cong_cu_1', '');

			$('[name="send_start_1"]').val(result.data.send_start);
			$('[name="send_end_1"]').val(result.data.send_end);

			$("textarea[name='note_1']").val(result.data.note);

			$('[name="sendFile"]').val(result.data._id.$oid);

			var html = "";

			for (let j = 0; j < result.data.image.length; j++) {
				if (result.data.image[j].file_type == 'image/png' || result.data.image[j].file_type == 'image/jpg' || result.data.image[j].file_type == 'image/jpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "' data-type='send_file' class='w-100' src='" + result.data.image[j].path + "'></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='send_file' data-key='"+ result.data.image[j].key +"' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'audio/mp3' || result.data.image[j].file_type == 'audio/mpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>"+ result.data.image[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ result.data.image[j].key +"' data-fileName='"+ result.data.image[j].file_name +"' data-fileType='"+ result.data.image[j].file_type +"'  data-type='send_file' class='w-100' src='"+ result.data.image[j].path +"' ></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='send_file' data-key='"+ j +"' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'video/mp4') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>"+ result.data.image[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'><img name='img_send_file' data-key='"+ result.data.image[j].key +"' data-fileName='"+ result.data.image[j].file_name +"' data-fileType='"+ result.data.image[j].file_type +"'  data-type='send_file' class='w-100' src='" + result.data.image[j].path + "' ></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='send_file' data-key='"+ result.data.image[j].key +"' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
			}
			$("#uploads_send_file_1").append(html);


			$('#editModal_send_file').modal('show');
		}
	});

}


$('#edit_send_file').click(function (event){

	event.preventDefault();

	if ($('#store_take_value_1').val() != "") {
		var store_take_value = JSON.parse($('#store_take_value_1').val());
	}
	if ($('#van_phong_pham_value_1').val() != "") {
		var van_phong_pham_value = JSON.parse($('#van_phong_pham_value_1').val());
	}
	if ($('#cong_cu_value_1').val() != "") {
		var cong_cu_value = JSON.parse($('#cong_cu_value_1').val());
	}

	var send_start = $("#send_start_1").val();
	var send_end = $("#send_end_1").val();
	var note = $("#note_1").val();

	var count = $("img[name='img_send_file']").length;
	// console.log(count);
	var img_send_file = {};

	if (count > 0) {
		$("img[name='img_send_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'send_file') {
				img_send_file[key] = data;
			}

		});
	}
	console.log(img_send_file)
	$.ajax({
		url: _url.base_url + '/borrowed/update_sendFile',
		method: "POST",
		data: {
			id: $('#sendFile').val(),
			store_take_value: store_take_value,
			van_phong_pham_value: van_phong_pham_value,
			cong_cu_value: cong_cu_value,
			send_start: send_start,
			send_end: send_end,
			note: note,
			img_send_file: img_send_file,
		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.data.status == 200) {
				console.log("xxx");
				$("#successModal").modal("show");
				$(".msg_success").text('Cập nhật thành công');
				sessionStorage.clear()
				setTimeout(function () {
					window.location.href = _url.base_url + 'borrowed/index_sendFile';
				}, 3000);
			} else {

				$("#div_errorCreate_1").css("display", "block");
				$(".div_errorCreate").text(data.data.message);

				setTimeout(function () {
					$("#div_errorCreate_1").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log("xxx");
			$(".theloading").hide();
		}
	});
});

function xac_nhan_da_nhan_vpp(thiz){
	$('#uploads_sendFile_2').empty();

	let sendFile_id = $(thiz).data("id");

	$("#sendFile_id").val(sendFile_id);
	$("#title_confirm").text("Bạn có chắc chắn hoàn thành việc nhận VPP từ HCNS không?");

	$("#confirm_sendFile").modal("show");
}

$('#sendFile_confirm').click(function (event) {
	event.preventDefault();

	var sendFile_id = $('#sendFile_id').val();

	var count = $("img[name='img_send_file']").length;
	// console.log(count);
	var img_send_file = {};

	if (count > 0) {
		$("img[name='img_send_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'sendFile') {
				img_send_file[key] = data;
			}

		});
	}

	$("#confirm_fileReturn").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/confirm_sendFile',
		method: "POST",
		data: {
			sendFile_id: sendFile_id,
			img_send_file: img_send_file,
		},
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();

			$("#successModal").modal("show");
			$(".msg_success").text('Xác nhận thành công');
			setTimeout(function () {
				window.location.href = _url.base_url + 'borrowed/index_sendFile';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});

function history_sendFile(id){

	$('#history_sendFile_1').empty();

	$.ajax({
		url: _url.base_url + 'borrowed/showLog_sendFile/' + id,
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
				console.log(content[0].created_at)

				for (var i = 0; i < content.length; i++) {

					if (content[i].note == undefined){
						content[i].note = "";
					}
					if (content[i].van_phong_pham_value == undefined){
						content[i].van_phong_pham_value = "";
					}
					if (content[i].cong_cu_value == undefined){
						content[i].cong_cu_value = "";
					}

					// if (content[i].new.fileReturn_img == undefined){
					// 	content[i].new.fileReturn_img = "";
					// }

					html += "<tr><td>" + content[i].created_at;
					html += "<br>" + content[i].created_by;
					html += "</td>";
					if (content[i].sendFile != "" ) {
						html +=  "<td>" + content[i].sendFile.status + "</td>";
					} else {
						html +=  "<td>" + content[i].old.status + " -> " + content[i].new.status + "</td>";
					}
					html +=  "<td>" + content[i].note + "</td>";
					if (content[i].van_phong_pham_value != undefined){
						html +=  "<td>" + content[i].van_phong_pham_value + "</td>";
					}
					if (content[i].cong_cu_value != undefined){
						html +=  "<td>" + content[i].cong_cu_value + "</td>";
					}

					if (content[i].sendFile.img_send_file != undefined){
						html += '<td><div id="SomeThing" class="simpleUploader">';
						html += '<div class="uploads " id="">';
						for(var j in content[i].sendFile.img_send_file) {
							html += '<div class="block">';
							html += '<a href="' + content[i].sendFile.img_send_file[j].path + '"  class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"   >';
							html += '<img class="w-100" src="' + content[i].sendFile.img_send_file[j].path + '" />';
							html += '</a>';
							html += '</div>';
						}
						html += '</div></div></td>';
					}
					// else {
					// 	html += '<td></td>'
					// }
					if (content[i].sendFile.img_send_file == undefined ){
						html += '<td><div id="SomeThing" class="simpleUploader">';
						html += '<div class="uploads " id="">';
						for(var j in content[i].new.img_send_file) {
							html += '<div class="block">';
							html += '<a href="' + content[i].new.img_send_file[j].path + '"  class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"   >';
							html += '<img class="w-100" src="' + content[i].new.img_send_file[j].path + '" />';
							html += '</a>';
							html += '</div>';
						}
						html += '</div></div></td>';
					}


					html += "</tr>";
				}
				$("#history_sendFile_1").append(html);

			}
			$('#history_sendFile').modal('show');
		}
	});


}

function huy(thiz){

	let sendFile_id = $(thiz).data("id");

	$("#sendFile_id_1").val(sendFile_id);
	$("#title_cancel").text("Bạn có chắc chắn Hủy YC này không?");

	$("#cancel_sendFile").modal("show");

}

$('#sendFile_cancel').click(function (event) {
	event.preventDefault();

	var sendFile_id = $('#sendFile_id_1').val();

	var formData = new FormData();
	formData.append('sendFile_id', sendFile_id);

	$("#cancel_sendFile").modal("hide");

	$.ajax({
		url: _url.base_url + 'borrowed/cancel_sendFile',
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
				window.location.href = _url.base_url + 'borrowed/index_sendFile';
			}, 3000);

		},
		error: function (data) {
			console.log(data)
			$(".theloading").hide();
		}
	});

});





