$(document).ready(function () {
	$("#create_asset_oto").click(function (event) {
		event.preventDefault();
		var type = $("input[name='type_oto']").val()
		var name_customer = $("input[name='customer_name_oto']").val()
		var address = $("input[name='address_oto']").val()
		var product = $("input[name='product_oto']").val()
		var nhan_hieu = $("input[name='nhan_hieu_oto']").val()
		var model = $("input[name='model_oto']").val()
		var bien_so = $("input[name='bien_so_xe_oto']").val()
		var so_khung = $("input[name='so_khung_oto']").val()
		var so_may = $("input[name='so_may_oto']").val()
		var so_dang_ki = $("input[name='so_dang_ki_oto']").val()
		var ngay_cap = $("input[name='ngay_cap_oto']").val()
		var note = $("textarea[name='note_oto']").val()
		var count = $("img[name='img_asset']").length;
		var image_oto = {};
		if (count > 0) {
			$("img[name='img_asset']").each(function () {
				var data = {};
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				var key = $(this).data('key');
				image_oto[key] = data;
			});
		}
		console.log(image_oto)
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
			image_asset: image_oto,
		};
		$.ajax({
			url: _url.base_url + 'asset_manager/add_new_asset',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#addnew_oto_Modal").hide();
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
