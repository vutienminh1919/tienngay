function call_for_customer(phone_number, contract_id, type) {
	console.log(phone_number);
	if (phone_number == undefined || phone_number == '') {
		alert("Không có số");
	} else {
		// $(".title_modal_approve").text("Gọi cho khách hàng:0" + phone_number);
		if(type == "customer"){
			$(".title_modal_approve").text("Gọi cho khách hàng");
		}
		if(type ==  "rel1"){
			$(".title_modal_approve").text("Gọi cho tham chiếu 1");
		}
		if(type ==  "rel2"){
			$(".title_modal_approve").text("Gọi cho tham chiếu 2");
		}
		$("#number").val(phone_number);
		$(".contract_id").val(contract_id);
		$("#approve").modal("show");
	}
}

$(".approve_submit").on("click", function () {
	var note = $(".contract_v2_note").val();
	var id = $(".contract_id").val();
	var result_reminder =  $(".result_reminder").val();
	var payment_date =  $(".payment_date").val();
	var amount_payment_appointment =  $(".amount_payment_appointment").val();
	var formData = {
		note: note,
		payment_date: payment_date,
		result_reminder: result_reminder,
		amount_payment_appointment : amount_payment_appointment,
		contractId: id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "badDebt/doNoteReminder",
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
			if (data.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			}
		},
		error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
	})
});
$("#form_baddebt").submit(function() {
	$(".theloading").show();
});
$('#note_renewal').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	},
	dropdownParent: 'body'
});

