$(document).ready(function () {
	$("#radio_btnSave").click(function (event) {
		event.preventDefault();
		var year = $("input[name='year_radio']").val();
		var month = $("#month_radio").val();
		var b1 = $("input[name='b1_radio']").val();
		var b2 = $("input[name='b2_radio']").val();
		var b3 = $("input[name='b3_radio']").val();
		var b4 = $("input[name='b4_radio']").val();
		var b5 = $("input[name='b5_radio']").val();
		var b6 = $("input[name='b6_radio']").val();
		var b7 = $("input[name='b7_radio']").val();
		var b8 = $("input[name='b8_radio']").val();
		var formData = new FormData();
		formData.append('month', month);
		formData.append('year', year);
		formData.append('b1', b1);
		formData.append('b2', b2);
		formData.append('b3', b3);
		formData.append('b4', b4);
		formData.append('b5', b5);
		formData.append('b6', b6);
		formData.append('b7', b7);
		formData.append('b8', b8);
		console.log(formData)
		$('#addNewRadioEmploy').modal('hide');
		$.ajax({
			url: _url.base_url + 'debt_manager_app/create_radio_field',
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

$(document).ready(function () {
	$(".radioBlock").click(function () {
		if (confirm('Bạn có chắc chắn muốn xóa?')) {
			let id = $(this).attr('data-id')
			$.ajax({
				url: _url.base_url + "/debt_manager_app/block_radio_field?id=" + id,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					if (data.code == 200) {
						$('#radio-user-' + id).remove()
					}
				}
			})
		}
	})
})

function showAndUpdate(id) {
	$.ajax({
		url: _url.base_url + "/debt_manager_app/showRadio?id=" + id,
		type: "GET",
		dataType: 'json',
		success: function (data) {
			$('.title_radio_update').empty()
			$("input[name='id_radio_update']").empty()
			$("input[name='b1_radio_update']").empty()
			$("input[name='b2_radio_update']").empty()
			$("input[name='b3_radio_update']").empty()
			$("input[name='b4_radio_update']").empty()
			$("input[name='b5_radio_update']").empty()
			$("input[name='b6_radio_update']").empty()
			$("input[name='b7_radio_update']").empty()
			$("input[name='b8_radio_update']").empty()
			$('.title_radio_update').text('Cập nhật tháng ' + data.data.month + '/' + data.data.year)
			$("input[name='id_radio_update']").val(id)
			$("input[name='b1_radio_update']").val(data.data.B1)
			$("input[name='b2_radio_update']").val(data.data.B2)
			$("input[name='b3_radio_update']").val(data.data.B3)
			$("input[name='b4_radio_update']").val(data.data.B4)
			$("input[name='b5_radio_update']").val(data.data.B5)
			$("input[name='b6_radio_update']").val(data.data.B6)
			$("input[name='b7_radio_update']").val(data.data.B7)
			$("input[name='b8_radio_update']").val(data.data.B8)
		}
	})
}

$(document).ready(function () {
	$('#update_radio_btnSave').click(function (event) {
		event.preventDefault();
		var id = $("input[name='id_radio_update']").val();
		var b1 = $("input[name='b1_radio_update']").val();
		var b2 = $("input[name='b2_radio_update']").val();
		var b3 = $("input[name='b3_radio_update']").val();
		var b4 = $("input[name='b4_radio_update']").val();
		var b5 = $("input[name='b5_radio_update']").val();
		var b6 = $("input[name='b6_radio_update']").val();
		var b7 = $("input[name='b7_radio_update']").val();
		var b8 = $("input[name='b8_radio_update']").val();
		var formData = new FormData();
		formData.append('id', id);
		formData.append('b1', b1);
		formData.append('b2', b2);
		formData.append('b3', b3);
		formData.append('b4', b4);
		formData.append('b5', b5);
		formData.append('b6', b6);
		formData.append('b7', b7);
		formData.append('b8', b8);
		$('#updateRadioEmploy').modal('hide');
		$.ajax({
			url: _url.base_url + 'debt_manager_app/updateRadio',
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
