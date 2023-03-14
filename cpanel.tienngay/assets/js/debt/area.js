$('select[name="employ"]').selectize({
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

$('select[name="province_debt"]').selectize({
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
	$(".areaBlock").click(function () {
		if (confirm('Bạn có chắc chắn muốn xóa?')) {
			let id = $(this).attr('data-id')
			$.ajax({
				url: _url.base_url + "/debt_manager_app/block_area_employ?id=" + id,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					if (data.code == 200) {
						$('#area-user-' + id).remove()
					}
				}
			})
		}
	})
})

$(document).ready(function () {
	$('#province_debt').change(function () {
		let codeCity = $(this).val();
		$("#district_debt option").remove();
		$.ajax({
			url: _url.base_url + '/debt_manager_app/get_district_from_province?id=' + codeCity,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('#district_debt').append($('<option>', {value: '', text: "--Chọn Quận/Huyện--"}));
				$.each(data.data, function (key, value) {
					$('#district_debt').append($('<option>', {value: value.code, text: value.name_with_type}));
				});
			},
			error: function () {
				alert('Có lỗi xảy ra!!!');
			}
		});
	})

	$("#area_btnSave").click(function (event) {
		event.preventDefault();
		var province = $("#province_debt").val();
		var district = $("#district_debt").val();
		var user_id = $("#idUserDebt").val();
		var formData = new FormData();
		formData.append('province', province);
		formData.append('district', district);
		formData.append('id', user_id);
		$('#addNewAreaEmploy').modal('hide');
		$.ajax({
			url: _url.base_url + 'debt_manager_app/add_area_for_user',
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
