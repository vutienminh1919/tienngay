$(document).ready(function () {
	$("#create_asset_moto").click(function (event) {
		event.preventDefault();
		var type = $("input[name='type_xm']").val()
		var name_customer = $("input[name='name_customer']").val()
		var address = $("input[name='address']").val()
		var product = $("input[name='product']").val()
		var nhan_hieu = $("input[name='nhan_hieu_xm']").val()
		var model = $("input[name='model_xm']").val()
		var bien_so = $("input[name='bien_so_xm']").val()
		var so_khung = $("input[name='so_khung_xm']").val()
		var so_may = $("input[name='so_may_xm']").val()
		var so_dang_ki = $("input[name='so_dang_ki_xm']").val()
		var ngay_cap = $("input[name='ngay_cap_xm']").val()
		var note = $("textarea[name='note_xm']").val()
		var count = $("img[name='img_asset']").length;
		var image_moto = {};
		if (count > 0) {
			$("img[name='img_asset']").each(function () {
				var data = {};
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				var key = $(this).data('key');
				image_moto[key] = data;
			});
		}
		console.log(image_moto)
		var formData = {
			loai_xe: type,
			name_customer: name_customer,
			address: address,
			product: product,
			nhan_hieu: nhan_hieu,
			model: model,
			bien_so: bien_so,
			so_khung: so_khung,
			so_may: so_may,
			so_dang_ki: so_dang_ki,
			ngay_cap: ngay_cap,
			note: note,
			image_asset: image_moto,
		};
		$.ajax({
			url: _url.base_url + 'asset_manager/add_new_asset',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#addnew_xemay_Modal").hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				// console.log(data)
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + "asset_manager/asset";
					}, 2000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					let html = '';
					$.each(data.msg, function (k, v) {
						html += '<li style="text-align: left">';
						html += v;
						html += '</li>';
					})
					$(".msg_error").html(html);
					setTimeout(function () {
						window.location.href = _url.base_url + "asset_manager/asset";
					}, 2000);
				}
			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
				setTimeout(function () {
					window.location.href = _url.base_url + "asset_manager/asset";
				}, 1000);
			}
		});
	})
})

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	if (confirm("Bạn có chắc chắn muốn xóa?")) {
		$(thiz_).closest("div .block").remove();
	}
}

$('input[type=file]').change(function () {
	var contain = $(this).data("contain");
	var title = $(this).data("title");
	var type = $(this).data("type");
	$(this).simpleUpload(_url.base_url + "asset_manager/upload_img", {
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
				content += '<img data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_asset"  data-key="' + data.key + '" src="' + data.path + '" />';
				content += '</a>';
				content += '<button type="button" onclick="deleteImage(this)" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				var data = $('<div id="imageAsset"></div>').html(content);
				this.block.append(data);
			} else {
				//our application returned an error
				var error = data.msg;
				this.block.remove();
				alert(error);
			}
		},
		error: function (error) {
			this.block.remove();
			alert('Không đúng định dạng!');
		}
	});
});
