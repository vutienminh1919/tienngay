$(document).ready(function () {
	$('#selectAll').click(function (event) {
		if (this.checked) {
			$('.micCheckBox').each(function () {
				this.checked = true;
			});
		} else {
			$('.micCheckBox').each(function () {
				this.checked = false;
			});
		}
		let mic = [];
		$(".micCheckBox:checked").each(function () {
			mic.push($(this).val());
		});
		var formData = {
			code: mic
		}
		$.ajax({
			url: _url.base_url + 'gic_plt/get_total_pay',
			type: "POST",
			data: formData,
			dataType: 'json',
			success: function (data) {
				console.log(data)
				$('#total_money').text(data.total)
			},
			error: function () {
				console.log('error')
			}
		});
	});
	$('.micCheckBox').click(function () {
		if (!this.checked) {
			$('#selectAll').prop('checked', false)
		}
		let mic = [];
		$(".micCheckBox:checked").each(function () {
			mic.push($(this).val());
		});
		console.log(mic)
		var formData = {
			code: mic
		}
		$.ajax({
			url: _url.base_url + 'gic_plt/get_total_pay',
			type: "POST",
			data: formData,
			dataType: 'json',
			success: function (data) {
				console.log(data)
				$('#total_money').text(data.total)
			},
			error: function () {
				console.log('error')
			}
		});
	})
})

$(document).ready(function () {
	$('#submit_payment').click(function (event) {
		event.preventDefault();
		if (confirm('Bạn có chắc chắn gửi sang kế toán?')) {
			let mic = [];
			$(".micCheckBox:checked").each(function () {
				mic.push($(this).val());
			});
			var store = $("select[name='store']").val();
			console.log(mic);
			var formData = new FormData();
			formData.append('mic', mic);
			formData.append('store',store);
			$.ajax({
				url: _url.base_url + 'gic_plt/create_transaction',
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
					console.log(data)
					if (data.code == 200) {
						$("#successModal").modal("show");
						$(".msg_success").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + "gic_plt?tab=transaction";
						}, 2000);
					} else if (data.code == 401) {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + "gic_plt?tab=transaction";
						}, 1000);
					}
				},
				error: function () {
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
					setTimeout(function () {
						window.location.href = _url.base_url + "gic_plt?tab=transaction";
					}, 2000);
				}
			});
		}
	});
});
