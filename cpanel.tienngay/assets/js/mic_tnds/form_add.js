$('select[name="store"]').selectize({
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

$(document).ready(function () {
	$(".add_mic_tnds_btnSave").click(function (event) {
		event.preventDefault();
		var bien_xe = $("input[name='bien_xe']").val()
		var ten_kh = $("input[name='ten_kh']").val()
		var cmt = $("input[name='cmt']").val()
		var ngay_sinh = $("input[name='ngay_sinh']").val()
		var phone = $("input[name='phone']").val()
		var mail = $("input[name='mail']").val()
		var address = $("input[name='address']").val()
		var chinh_chu = $("select[name='vehicle']").val()
		var id_pgd = $("select[name='store']").val()
		var thoi_han_hieu_luc = $("select[name='thoi_han_hieu_luc']").val()
		var muc_trach_nhiem = $("select[name='muc_trach_nhiem']").val()
		let loai_xe = $("input[name='loai_xe']:checked").val();
		var ten_kh_ko_chinh_chu = $("input[name='ten_kh_ko_chinh_chu']").val()
		var cmt_kh_ko_chinh_chu = $("input[name='cmt_kh_ko_chinh_chu']").val()
		var ngay_sinh_khong_chinh_chu = $("input[name='ngay_sinh_khong_chinh_chu']").val()
		var phone_khong_chinh_chu = $("input[name='phone_khong_chinh_chu']").val()
		var dia_chi_khong_chinh_chu = $("input[name='dia_chi_khong_chinh_chu']").val()
		var email_khong_chinh_chu = $("input[name='email_khong_chinh_chu']").val()
		var price = $("input[name='price']").val()
		var start_date_effect = $("input[name='start_effect_date']").val();

		if (!bien_xe || !ten_kh || !cmt || !ngay_sinh || !phone || !mail || !address || !chinh_chu || !id_pgd) {
			alert("Ô nhập liệu đang trống!")
		} else {
			if (confirm("Bạn có chắc chắn muốn bán Bảo hiểm Trách nhiệm dân sự cho biển số xe " + bien_xe + " với số tiền " + price)) {
				var formData = new FormData();
				formData.append('bien_xe', bien_xe);
				formData.append('ten_kh', ten_kh);
				formData.append('cmt', cmt);
				formData.append('ngay_sinh', ngay_sinh);
				formData.append('phone', phone);
				formData.append('mail', mail);
				formData.append('address', address);
				formData.append('chinh_chu', chinh_chu);
				formData.append('id_pgd', id_pgd);
				formData.append('loai_xe', loai_xe);
				formData.append('price', price);
				formData.append('thoi_han_hieu_luc', thoi_han_hieu_luc);
				formData.append('muc_trach_nhiem', muc_trach_nhiem);
				formData.append('ten_kh_ko_chinh_chu', ten_kh_ko_chinh_chu);
				formData.append('cmt_kh_ko_chinh_chu', cmt_kh_ko_chinh_chu);
				formData.append('ngay_sinh_khong_chinh_chu', ngay_sinh_khong_chinh_chu);
				formData.append('phone_khong_chinh_chu', phone_khong_chinh_chu);
				formData.append('dia_chi_khong_chinh_chu', dia_chi_khong_chinh_chu);
				formData.append('email_khong_chinh_chu', email_khong_chinh_chu);
				formData.append('start_date_effect', start_date_effect);

				$.ajax({
					url: _url.base_url + 'mic_tnds/add_mic_tnds',
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
						console.log(data.file)
						if (data.code == 200) {
							$("#successModal").modal("show");
							$(".msg_success").text(data.msg);
							setTimeout(function () {
								window.location.replace(_url.base_url + "mic_tnds");
								window.open(data.file);
							}, 500);
						} else if (data.code == 401) {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
						}
					},
					error: function () {
						$(".theloading").hide();
						$("#errorModal").modal("show");
						$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
					}
				});
			}
		}
	})
})

$(document).ready(function () {
	$("#vehicle").change(function () {
		let xe_khong_chinh_chu = $("select[name='vehicle']").val()
		if (xe_khong_chinh_chu == "C") {
			$('#xe_khong_chinh_chu').show()
		} else {
			$('#ten_kh_ko_chinh_chu').val('')
			$('#cmt_kh_ko_chinh_chu').val('')
			$('#phone_khong_chinh_chu').val('')
			$('#email_khong_chinh_chu').val('')
			$('#dia_chi_khong_chinh_chu').val('')
			$('#ngay_sinh_khong_chinh_chu').val('')
			$('#xe_khong_chinh_chu').hide()
		}
	})

	$("input").on("change", function () {
		let loai_xe = $("input[name='loai_xe']:checked").val();
		let muc_trach_nhiem = $("#muc_trach_nhiem").val();
		let thoi_han_hieu_luc = $("#thoi_han_hieu_luc").val();
		console.log(muc_trach_nhiem)
		$.ajax({
			url: _url.base_url + "mic_tnds/get_price_mic_tnds?loai_xe=" + loai_xe + '&muc_trach_nhiem=' + muc_trach_nhiem + '&thoi_han_hieu_luc=' + thoi_han_hieu_luc,
			type: "GET",
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				console.log(this.url)
				$("input[name='price']").val(data.data + " VND")
			},
			error: function () {
				$(".theloading").hide();
				console.log('error')
			}
		})
	});

	$("#muc_trach_nhiem").on("change", function () {
		let loai_xe = $("input[name='loai_xe']:checked").val();
		let muc_trach_nhiem = $("#muc_trach_nhiem").val();
		let thoi_han_hieu_luc = $("#thoi_han_hieu_luc").val();
		console.log(muc_trach_nhiem)
		$.ajax({
			url: _url.base_url + "mic_tnds/get_price_mic_tnds?loai_xe=" + loai_xe + '&muc_trach_nhiem=' + muc_trach_nhiem + '&thoi_han_hieu_luc=' + thoi_han_hieu_luc,
			type: "GET",
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				$("input[name='price']").val(data.data + " VND")
			},
			error: function () {
				$(".theloading").hide();
				console.log('error')
			}
		})
	});

	$("#thoi_han_hieu_luc").on("change", function () {
		let loai_xe = $("input[name='loai_xe']:checked").val();
		let muc_trach_nhiem = $("#muc_trach_nhiem").val();
		let thoi_han_hieu_luc = $("#thoi_han_hieu_luc").val();
		console.log(muc_trach_nhiem)
		$.ajax({
			url: _url.base_url + "mic_tnds/get_price_mic_tnds?loai_xe=" + loai_xe + '&muc_trach_nhiem=' + muc_trach_nhiem + '&thoi_han_hieu_luc=' + thoi_han_hieu_luc,
			type: "GET",
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				$("input[name='price']").val(data.data + " VND")
			},
			error: function () {
				$(".theloading").hide();
				console.log('error')
			}
		})
	});

	$('#thoi_han_hieu_luc').on('change', function () {
		let thoi_han_hieu_luc = $("#thoi_han_hieu_luc").val();
		let start_effect_date = $("#start_effect_date").val();
		console.log(thoi_han_hieu_luc)
		$.ajax({
			url: _url.base_url + "mic_tnds/get_time?year=" + thoi_han_hieu_luc + "&start_date=" + start_effect_date,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				console.log(data.date)
				$("#endDateMic").val(data.date)
			},
			error: function () {
				console.log('error')
			}
		})
	})

	//Hiện chọn ngày bắt đầu hiệu lực
	$('#choose_date').click(function () {
		$('#start_effect_date').prop('disabled', false);
		$('#start_effect_date').datetimepicker({
			format: 'DD/MM/YYYY',
			minDate: new Date
		});
	});
})

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	var res = confirm("Are you sure want to delete ?");
	$(thiz_).closest("div .block").remove();
}

$('input[type=file]').change(function () {
	var contain = $(this).data("contain");
	var title = $(this).data("title");
	var type = $(this).data("type");
	$(this).simpleUpload(_url.base_url + "mic_tnds/upload_img", {
		allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
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
		},
		progress: function (progress) {
			//received progress
			this.progressBar.width(progress + "%");
		},
		success: function (data) {
			//upload successful
			this.progressBar.remove();
			if (data.code == 200) {
				var content = "";
				content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" data-gallery="' + contain + '" data-max-width="992" data-type="image" data-title="' + title + '">';
				content += '<img data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_asset"  data-key="' + data.key + '" src="' + data.path + '" /><button type="button" onclick="deleteImage(this)" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				content += '</a>';
				var data = $('<div ></div>').html(content);
				this.block.append(data);
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
			alert(msg);
		}
	});
});

//Change giá trị ngày kết thúc
$("#start_effect_date").on("dp.change", function(e) {
	e.preventDefault();
	let start_effect_date_string = $('#start_effect_date').val();
	let number_year = $('#thoi_han_hieu_luc').val();
	console.log(start_effect_date_string);
	let start_date_convert = moment(start_effect_date_string, 'DD-MM-YYYY')
	console.log(start_date_convert)
	let end_date_string =  start_date_convert.add(number_year, 'years');
	let end_date_string_convert = moment(end_date_string, 'DD-MM-YYYY').format('DD/MM/YYYY');
	console.log(end_date_string_convert)
	$('#endDateMic').empty();
	$('#endDateMic').val(end_date_string_convert);
	$('#endDateMic').append(end_date_string_convert);
});
