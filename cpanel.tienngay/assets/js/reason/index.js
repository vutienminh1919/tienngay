$('#number_investment').keyup(function(event) {
	// skip for arrow keys
	if(event.which >= 37 && event.which <= 40) return;

	// format number
	$(this).val(function(index, value) {
		return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
	});
});
$('#number_investment').keyup(function(event) {

	$('.number').keypress(function(event) {

		if ((event.which != 46 || $(this).val().indexOf(',') != -1) && (event.which < 48 || event.which > 57)) {

			event.preventDefault();
		}
	});
});

$(".create_reason").click(function(event) {
	event.preventDefault();
	var code_reason = $("input[name='code_reason']").val();
	var reason_name = $("input[name='reason_name']").val();
	var status = $("input[name='status']:checked").val();
	
	var formData = new FormData();
	formData.append('code_reason', code_reason);
	formData.append('reason_name', reason_name);
	formData.append('status', status);

	console.log(formData);

	$.ajax({
		url :  _url.base_url + 'reason/do_add_reason',
		type: "POST",
		data : formData,
		dataType : 'json',
		processData: false,
		contentType: false,
		beforeSend: function(){$(".theloading").show();},
		success: function(data) {
			$(".theloading").hide();
			//console.log(data);
			if (data.res) {
				console.log(data);
				$('#successModal').modal('show');
				$('.msg_success').text(data.message);
				setTimeout(function(){
					window.location.href = _url.base_url + 'reason/reason_list';
				}, 3000);
			} else {
				console.log(data);
				$("#div_error").css("display", "block");
				$(".div_error").text(data.message);
				window.scrollTo(0, 0);
				setTimeout(function(){
					$("#div_error").css("display", "none");
				}, 3000);
			}
		},
		error: function(data) {
			//console.log(data);
			$(".theloading").hide();
		}
	});

});

$(".update_reason").click(function(event) {
	event.preventDefault();
	var id = $("input[name='id_reason']").val();
	var reason_name = $("input[name='reason_name']").val();
	var status = $("input[name='status']:checked").val();
	
	var formData = new FormData();
	formData.append('id', id);
	formData.append('reason_name', reason_name);
	formData.append('status', status);
	
	$.ajax({
		url :  _url.base_url + '/reason/do_update_reason',
		type: "POST",
		data : formData,
		dataType : 'json',
		processData: false,
		contentType: false,
		beforeSend: function(){$(".theloading").show();},
		success: function(data) {
			$(".theloading").hide();
			if (data.res) {
				$('#successModal').modal('show');
				$('.msg_success').text(data.message);
				setTimeout(function(){
					window.location.href = _url.base_url + '/reason/reason_list';
				}, 3000);
			} else {
				$("#div_error").css("display", "block");
				$(".div_error").text(data.message);
				window.scrollTo(0, 0);
				setTimeout(function(){
					$("#div_error").css("display", "none");
				}, 3000);
			}
		},
		error: function(data) {
			console.log(data);
			$(".theloading").hide();
		}
	});

});


