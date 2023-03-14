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
	$(".add_gic_plt_btnSave").click(function (event) {
		event.preventDefault();
		var ten_kh = $("input[name='ten_kh']").val()
		var cmt = $("input[name='cmt']").val()
		var ngay_sinh = $("input[name='ngay_sinh']").val()
		var phone = $("input[name='phone']").val()
		var mail = $("input[name='mail']").val()
		var address = $("input[name='address']").val()
		var id_pgd = $("select[name='store']").val()
		var thoi_han_hieu_luc = $("#thoi_han_hieu_luc").val()
		var gender = $("input[name='gender']:checked").val();
		var code_GIC_plt = $("[name='gic_plt'] :selected").text();
		var code_GIC_plt = (code_GIC_plt.split("-", 1) == "") ? "" : code_GIC_plt.split("-", 1)[0];
		var price = getFloat($("input[name='price']").val());
		var province_name = $("#selectize_province_current_address option:selected").text();
		var district_name = $("#selectize_district_current_address option:selected").text();
		if (!gender || !code_GIC_plt|| !price || !ten_kh || !cmt || !ngay_sinh || !phone || !mail || !address || !id_pgd) {
			alert("Ô nhập liệu đang trống!")
		} else {
			if (confirm("Bạn có chắc chắn muốn bán Bảo hiểm Phúc lộc thọ cho " + ten_kh + " với số tiền " + price)) {
				var formData = new FormData();
				formData.append('ten_kh', ten_kh);
				formData.append('cmt', cmt);
				formData.append('ngay_sinh', ngay_sinh);
				formData.append('phone', phone);
				formData.append('mail', mail);
				formData.append('address', address);
				formData.append('id_pgd', id_pgd);
				formData.append('price', price);
				formData.append('thoi_han_hieu_luc', thoi_han_hieu_luc);
				formData.append('code_GIC_plt', code_GIC_plt);
				formData.append('province_name', province_name);
				formData.append('district_name', district_name);
				formData.append('gender', gender);
			
				$.ajax({
					url: _url.base_url + 'gic_plt/add_gic_plt',
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
								window.location.replace(_url.base_url + "gic_plt");
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
function getFloat(val) {
	var val = val.replace(/,/g, "");
	return parseFloat(val);
}
$(document).ready(function () {

$('[name="gic_plt"]').change(function () {
		$('#fee_gic_plt').val(numeral($(this).val()).format('0,0'));
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
	$(this).simpleUpload(_url.base_url + "gic_plt/upload_img", {
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
$('#selectize_province_current_address').selectize({
	create: false,
	valueField: 'id',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	},
	onChange: function (value) {
		var formData = {
			id: value
		};
		$.ajax({
			url: _url.base_url + '/Ajax/get_district_by_province',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				if (data.res) {
					var selectClass = $('#selectize_district_current_address').selectize();
					var selectizeClass = selectClass[0].selectize;
					selectizeClass.clear();
					selectizeClass.clearOptions();
					selectizeClass.load(function (callback) {
						callback(data.data);
					});


				} else {

				}
			},
			error: function (data) {
				// console.log(data);
				// $("#loading").hide();
			}
		});
	}
});
$('#selectize_district_current_address').selectize({
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