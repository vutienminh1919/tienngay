function formatCurrency(number) {
	var n = number.split('').reverse().join("");
	var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
	return n2.split('').reverse().join('');
}
$('.only_number').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.only_number').keyup(function (event) {
	// skip for arrow keys
	if (event.which >= 37 && event.which <= 40) return;
	// format number
	$(this).val(function (index, value) {
		return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
	});
});

$('#create_pti_fee').click(function (event) {
	var title_fee = $("input[name='title_fee']").val();
	var start_date = $("input[name='start_date']").val();
	var end_date = $("input[name='end_date']").val();
	var note_fee = $("textarea[name='note_fee']").val();
	var packet = $("input[name='packet']").val();
	var died_fee = $("input[name='died_fee']").val();
	var therapy_fee = $("input[name='therapy_fee']").val();
	var three_month = $("input[name='three_month']").val();
	var six_month = $("input[name='six_month']").val();
	var twelve_month = $("input[name='twelve_month']").val();
	var quy_one = $("input[name='quy_one']").val();
	var quy_two = $("input[name='quy_two']").val();
	var quy_three = $("input[name='quy_three']").val();
	var quy_four = $("input[name='quy_four']").val();
	var quy_five = $("input[name='quy_five']").val();
	var quy_six = $("input[name='quy_six']").val();
	var status = $("input[name='status']:checked").val();

	var formData = {
			title_fee: title_fee,
			start_date: start_date,
			end_date: end_date,
			note_fee: note_fee,
			packet: packet,
			died_fee: died_fee,
			therapy_fee: therapy_fee,
			three_month: three_month,
			six_month: six_month,
			twelve_month: twelve_month,
			quy_one: quy_one,
			quy_two: quy_two,
			quy_three: quy_three,
			quy_four: quy_four,
			quy_five: quy_five,
			quy_six: quy_six,
			status: status,
		};
	if (confirm("Xác nhận tạo mới phí bảo hiểm!")) {
		$.ajax({
			url: _url.base_url + 'Pti_vta_fee/doCreatePtiFee',
			method: "POST",
			data: formData,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('.msg_success').text("Tạo phí bảo hiểm thành công!");
					$('#successModal').modal('show');
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				} else {
					$(".theloading").hide();
					$(".msg_error").text(data.msg);
					$("#errorModal").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	}
});
