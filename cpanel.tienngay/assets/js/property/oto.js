$('select[name="vehicles"]').selectize({
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
	$(".blockProperty_oto").click(function () {
		if (confirm('Bạn có chắc chắn muốn xóa?')) {
			let id = $(this).attr('data-id')
			$.ajax({
				url: _url.base_url + "/property_valuation/block_property?id=" + id,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					if (data.code == 200) {
						$('#propertyOto-' + id).remove()
					}
				}
			})
		}
	})
})
$(document).ready(function () {
	$("#import_property_oto").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_property_oto]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'property_valuation/import_property_oto',
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
	$('.detailOtoModal').click(function () {
		let id = $(this).attr('data-id')
		$.ajax({
			url: _url.base_url + 'property_valuation/get_detai_property?id=' + id,
			type: "GET",
			dataType: "JSON",
			success: function (result) {
				console.log(result)
				$('.ten_oto').empty();
				$('.hang_xe').empty();
				$('.dong_xe').empty();
				$('.nam_san_xuat').empty();
				$('.gia_xe').empty();
				$('#depreciations').empty();
				$('.ten_oto').text(typeof result.data.str_name === undefined ? '' : result.data.str_name);
				$('.hang_xe').text(typeof result.data.main === undefined ? '' : result.data.main);
				$('.dong_xe').text(typeof result.data.type_property === undefined ? '' : result.data.type_property);
				$('.nam_san_xuat').text(typeof result.data.year_property === undefined ? '' : result.data.year_property);
				$('.gia_xe').text(typeof result.data.price === undefined ? 0 : result.data.price + ' VND');
				$.each(result.data.depreciations, function (k, v) {
					let price = typeof v.price === undefined ? 0 : v.price
					temp = "<tr><td>" + ++k + "</td><td>" + v.name + "</td><td>" + price + " VND" + "</td></tr>";
					$("#depreciations").append(temp);
				})
			}
		});
	})
})
