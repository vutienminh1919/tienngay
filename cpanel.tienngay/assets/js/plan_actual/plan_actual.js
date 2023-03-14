$("#add_one_day_accountant").click(function (event) {
	event.preventDefault();
	var day_export = $("input[name='day_export']").val();
	var formData = new FormData();
	formData.append('day_export', day_export);
	console.log(day_export);
	$.ajax({
		url: _url.base_url + 'plan_actual/doAddBankBalance',
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
			if (data.res) {
				$('#successModal').modal('show');
				$('.msg_success').text(data.message);
				setTimeout(function () {
					window.location.href = _url.base_url + 'plan_actual/indexBankBalance?day=' + day_export;
				}, 3000);
			} else {
				$('#errorModal').modal('show');
				$(".msg_error").text(data.message);
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 3000);
			}
		},
		error: function (data) {
			$(".theloading").hide();
		}
	});

});
