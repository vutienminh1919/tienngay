$(document).ready(function () {
	$("#import_depreciation").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_depreciation]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'property_valuation/import_depreciation_xm',
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
				//console.log(data);
				if (data.status &&  data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					$(".theloading").hide();
					$("#successModal").modal("show");
					setTimeout(function () {
						window.location.reload();
					}, 1000);
					console.log(data);
				} else {
					console.log(data);
					$("#errorModal").modal("show");
					$(".msg_error").text(data.message);
					$("#errorModal").modal("show");
					setTimeout(function () {
						window.location.reload();
					}, 5000);
				}
			},
		});

	});
});

$(document).ready(function () {
	$(".depreciationUpdate").click(function () {
		let id = $(this).attr('data-id');
		$.ajax({
			url: _url.base_url + "property_valuation/get_depreciation_moto?id=" + id,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				$("input[name='id_depreciation_update']").empty()
				$(".hang_xe").empty()
				$(".dong_xe").empty()
				$(".nam_khau_hao").empty()
				$("input[name='khau_hao']").empty()
				$("input[name='id_depreciation_update']").val(id)
				$(".hang_xe").val(data.data.main_property)
				$(".dong_xe").val(data.data.type)
				$(".nam_khau_hao").val(data.data.year + " năm")
				$("input[name='khau_hao']").val(data.data.depreciation)
			}
		})
	})
})

$(document).ready(function () {
	$('#update_depreciation_btnSave').click(function (event) {
		event.preventDefault();
		var id = $("input[name='id_depreciation_update']").val();
		var khau_hao = $("input[name='khau_hao']").val();
		console.log(khau_hao)
		var formData = new FormData();
		formData.append('id', id);
		formData.append('depreciation', khau_hao);
		$('#updateDepreciationModal').modal('hide');
		$.ajax({
			url: _url.base_url + 'property_valuation/update_depreciations_moto',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				}
			}
		});
	})
})
