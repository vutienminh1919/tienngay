$(document).ready(function () {
	const R55 = 75000;
	const TD = 100000;
	$('#quantity').on('keyup', function (event) {
		event.preventDefault();
		let quantity = $(this).val();
		let type = $("select[name='type_transaction']").val();
		$('.box-image-qr').hide();
		$(".img_qr").attr("src", '');
		if (quantity && type) {
			if (type == 'SIMR55') {
				$("input[name='amount']").val(addCommas(quantity * R55));
			} else {
				$("input[name='amount']").val(addCommas(quantity * TD));
			}
		} else {
			$("input[name='amount']").val(0);
		}
	});

	$('.type_transaction').on('change', function (event) {
		event.preventDefault();
		let type = $(this).val();
		let quantity = $("input[name='quantity']").val();
		$('.box-image-qr').hide();
		$(".img_qr").attr("src", '');
		if (quantity && type) {
			if (type == 'SIMR55') {
				$("input[name='amount']").val(addCommas(quantity * R55));
			} else {
				$("input[name='amount']").val(addCommas(quantity * TD));
			}
		} else {
			$("input[name='amount']").val(0);
		}
	});

	$("#btn-create-qr").click(function (event) {
		event.preventDefault();
		$('.box-image-qr').hide();
		$(".img_qr").attr("src", '');
		let type_transaction = $("select[name='type_transaction']").val();
		let store = $("select[name='store']").val();
		let amount = $("input[name='amount']").val();
		let formData = new FormData();
		formData.append('type_transaction', type_transaction);
		formData.append('store', store);
		formData.append('amount', amount);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'qrCode/gen_qr_code',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data)
				$(".theloading").hide();
				if (data.status == 200) {
					$('.box-image-qr').show();
					$(".img_qr").attr("src", data.data);
				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.message || 'Thất bại');
				}
			},
			error: function (data) {
				$(".theloading").hide();
				$('#errorModal').modal('show');
				$('.msg_error').text(data.message);
			}
		});
	});
});

function addCommas(str) {
	return str.toString().replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
