$(document).ready(function () {
	$('#selectAll').click(function (event) {
		if (this.checked) {
			$('.heyUCheckBox').each(function () {
				this.checked = true;
			});
		} else {
			$('.heyUCheckBox').each(function () {
				this.checked = false;
			});
		}
		let heyu = [];
		$(".heyUCheckBox:checked").each(function () {
			heyu.push($(this).val());
		});
		var formData = {
			code: heyu
		}
		$.ajax({
			url: _url.base_url + 'heyU/get_total_pay',
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
	$('.heyUCheckBox').click(function () {
		if (!this.checked) {
			$('#selectAll').prop('checked', false)
		}
		let heyu = [];
		$(".heyUCheckBox:checked").each(function () {
			heyu.push($(this).val());
		});
		var formData = {
			code: heyu
		}
		$.ajax({
			url: _url.base_url + 'heyU/get_total_pay',
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
			let heyu = [];
			$(".heyUCheckBox:checked").each(function () {
				heyu.push($(this).val());
			});
			var store = $("select[name='store']").val()
			console.log(heyu)
			var formData = new FormData();
			formData.append('heyu', heyu);
			formData.append('store',store)
			$.ajax({
				url: _url.base_url + 'heyU/create_transaction',
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
							window.location.href = _url.base_url + "heyU?tab=transaction";
						}, 2000);
					} else if (data.code == 401) {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + "heyU/index";
						}, 1000);
					}
				},
				error: function () {
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
					setTimeout(function () {
						window.location.href = _url.base_url + "heyU/index";
					}, 2000);
				}
			});
		}
	})
})
