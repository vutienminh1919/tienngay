$('#selectize_role').selectize({
	create: false,
	valueField: 'selectize_role',
	labelField: 'name',
	searchField: 'name',
	maxItems: 40,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('#selectize_area').selectize({
	create: false,
	valueField: 'selectize_area',
	labelField: 'name',
	searchField: 'name',
	maxItems: 40,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});


$('[name="selectize_role[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#selectize_role').val();
	var data = [];
	if (value != null) {
		data.push(value);
	}
	$('#selectize_role_value').val(JSON.stringify(data));

	if (typeof data[0] != undefined) {
		console.log(value)
		if (value == null){
			$(".gdv_vm").hide();
			$("#selectize_area_value").val("");
			$("#selectize_area")[0].selectize.clear();
		}
		if (data[0].includes('Giao dịch viên')) {
			$(".gdv_vm").show();
		} else {
			$(".gdv_vm").hide();
			$("#selectize_area_value").val("");
			$("#selectize_area")[0].selectize.clear();
		}
	}



});

$('[name="selectize_area[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#selectize_area').val();
	var data = [];
	if (value != null) {
		data.push(value);
	}
	$('#selectize_area_value').val(JSON.stringify(data));

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
		maxFileSize: 1000000000, //10MB,
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
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);

				}
				//Mp3
				else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
					var item = "";
					item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
					item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					var data = $('<div ></div>').html(item);
					this.block.append(data);
				}
				//Image
				else {
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

$(".submit_notification").click(function (event) {
	event.preventDefault();

	var notification_type = $("#notification_type").val();
	var priority_level = $("#priority_level").val();
	var title = $("#title").val();
	var content =  CKEDITOR.instances.content.getData();
	var start_date = $("#start_date").val();
	var end_date = $("#end_date").val();

	console.log(title)
	console.log(content)
	if ($('#selectize_role_value').val() != "") {
		var selectize_role_value = JSON.parse($('#selectize_role_value').val());

	}
	if ($('#selectize_area_value').val() != "") {
		var selectize_area_value = JSON.parse($('#selectize_area_value').val());
	}

	//upload image
	var count = $("img[name='img_file']").length;
	// console.log(count);
	var identify = {};

	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'identify') {
				identify[key] = data;
			}

		});
	}

	$.ajax({
		url: _url.base_url + '/notification/create_notification',
		method: "POST",
		data: {
			notification_type: notification_type,
			priority_level: priority_level,
			title: title,
			content: content,
			start_date: start_date,
			end_date: end_date,
			selectize_role_value: selectize_role_value,
			selectize_area_value: selectize_area_value,

			identify: identify,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Tạo thông báo thành công');
				sessionStorage.clear()
				setTimeout(function () {
					window.location.href = _url.base_url + 'notification/index_notification';
				}, 3000);
			} else {

				// $('#errorModal').modal('show');
				// $('.msg_error').text(data.data.message);
				$("#div_errorCreate").css("display", "block");
				$(".div_errorCreate").text(data.data.message);
				// window.scrollTo(0, 0);
				//
				$([document.documentElement, document.body]).animate({
					scrollTop: $(".right_col").offset().top
				}, 500);

				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorCreate").css("display", "none");
				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

$('#selectize_role_1').selectize();
$('#selectize_area_1').selectize();

function editModal(id) {
	$("#uploads_identify_1").empty();
	$.ajax({
		url: _url.base_url + 'notification/showUpdate/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			console.log(result);

			$('[name="notification_type_1"]').val(result.data.notification_type);
			$('[name="priority_level"]').val(result.data.priority_level);
			$('[name="title"]').val(result.data.title);
			CKEDITOR.instances['content_1'].setData(result.data.content);

			$('[name="start_date"]').val(result.data.start_date);
			console.log(result.data.content);

			if (result.data.end_date != "01-01-1970"){
				$('[name="end_date"]').val(result.data.end_date);
			}
			console.log(result.data.start_date)
			$('[name="notification_id"]').val(result.data._id.$oid);



			check_selectize(result.data.selectize_role_value[0], 'selectize_role_1', '');
			check_selectize(result.data.selectize_area_value[0], 'selectize_area_1', '');

			for (let i = 0; i < result.data.selectize_role_value[0].length; i++) {
				if (result.data.selectize_role_value[0][i] == "Giao dịch viên") {
					$(".gdv_vm").show();
				}
			}


			var html = "";

			// $.each(result.data.image, function (key, value) {
			// 	console.log(key);
			// 	console.log(value);
			// });


			for (let j = 0; j < result.data.image.length; j++) {
				if (result.data.image[j].file_type == 'image/png' || result.data.image[j].file_type == 'image/jpg' || result.data.image[j].file_type == 'image/jpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='image' data-title='Thông báo'><img name='img_file' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "' data-type='identify' class='w-100' src='" + result.data.image[j].path + "'></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='identify' data-key='"+ result.data.image[j].key +"' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'audio/mp3' || result.data.image[j].file_type == 'audio/mpeg') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>"+ result.data.image[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_file' data-key='"+ result.data.image[j].key +"' data-fileName='"+ result.data.image[j].file_name +"' data-fileType='"+ result.data.image[j].file_type +"'  data-type='identify' class='w-100' src='"+ result.data.image[j].path +"' ></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='identify' data-key='"+ j +"' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
				if (result.data.image[j].file_type == 'video/mp4') {
					html += "<div class='block'>";
					html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>"+ result.data.image[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'><img name='img_file' data-key='"+ result.data.image[j].key +"' data-fileName='"+ result.data.image[j].file_name +"' data-fileType='"+ result.data.image[j].file_type +"'  data-type='identify' class='w-100' src='" + result.data.image[j].path + "' ></a>";
					html += "<button type='button' onclick='deleteImage(this)' data-type='identify' data-key='"+ result.data.image[j].key +"' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
					html += "</div>"
				}
			}
			$("#uploads_identify_1").append(html);

			$('#editModal').modal('show');
		}
	});

}

function check_selectize(check = null, type, t) {

	$('#' + type).data('selectize').setValue(check);
}

$('#selectize_role_1').selectize({
	create: false,
	valueField: 'selectize_role_1',
	labelField: 'name',
	searchField: 'name',
	maxItems: 40,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$('#selectize_area_1').selectize({
	create: false,
	valueField: 'selectize_area_1',
	labelField: 'name',
	searchField: 'name',
	maxItems: 40,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});


$('[name="selectize_role_1[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#selectize_role_1').val();
	var data = [];
	if (value != null) {
		data.push(value);
	}
	$('#selectize_role_value_1').val(JSON.stringify(data));

	if (typeof data[0] != undefined) {
		if (data[0].includes('Giao dịch viên')) {
			$(".gdv_vm").show();
		} else {
			$(".gdv_vm").hide();
			$("#selectize_area_value_1").val("");
			$("#selectize_area_1")[0].selectize.clear();
		}
	}

});

$('[name="selectize_area_1[]"]').on('change', function (event) {
	event.preventDefault();
	var value = $('#selectize_area_1').val();
	var data = [];
	if (value != null) {
		data.push(value);
	}
	$('#selectize_area_value_1').val(JSON.stringify(data));

});



$(".edit_notification").click(function (event) {
	event.preventDefault();

	var notification_type = $("#notification_type_1").val();
	var priority_level = $("#priority_level_1").val();
	var title = $("#title_1").val();
	var content = CKEDITOR.instances.content_1.getData();
	var start_date = $("#start_date_1").val();
	var end_date = $("#end_date_1").val();
	console.log(notification_type)
	if ($('#selectize_role_value_1').val() != "") {
		var selectize_role_value = JSON.parse($('#selectize_role_value_1').val());

	}
	if ($('#selectize_area_value_1').val() != "") {
		var selectize_area_value = JSON.parse($('#selectize_area_value_1').val());
	}

	//upload image
	var count = $("img[name='img_file']").length;
	// console.log(count);
	var identify = {};

	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'identify') {
				identify[key] = data;
			}

		});
	}

	$.ajax({
		url: _url.base_url + '/notification/update_notification',
		method: "POST",
		data: {
			id: $("#notification_id").val(),
			notification_type: notification_type,
			priority_level: priority_level,
			title: title,
			content: content,
			start_date: start_date,
			end_date: end_date,
			selectize_role_value: selectize_role_value,
			selectize_area_value: selectize_area_value,

			identify: identify,

		},

		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.data.status == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text('Sửa thông báo thành công');
				sessionStorage.clear()
				setTimeout(function () {
					window.location.href = _url.base_url + 'notification/index_notification';
				}, 3000);
			} else {
				// $('#errorModal').modal('show');
				// $('.msg_error').text(data.data.message);
				$("#div_errorEdit").css("display", "block");
				$(".div_errorEdit").text(data.data.message);
				window.scrollTo(0, 0);
				setTimeout(function () {
					// $('#errorModal').modal('hide');
					$("#div_errorEdit").css("display", "none");

				}, 4000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

$(".close_tb").click(function (event) {
	event.preventDefault();

	$("#title").val("");
	$("#content").val("");
	$("#start_date").val("");
	$("#end_date").val("");

	$("#selectize_role_value").val("");
	$("#selectize_role")[0].selectize.clear();
	$("#selectize_area_value").val("");
	$("#selectize_area")[0].selectize.clear();

	$("#uploads_identify").empty();
});

$('#start_date').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('#end_date').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('#start_date_1').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});
$('#end_date_1').datetimepicker({
	format: 'DD-MM-YYYY',
	minDate: new Date
});








