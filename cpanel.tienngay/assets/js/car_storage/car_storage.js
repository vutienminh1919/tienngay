$(".modal_storage").click(function(event)
{
	event.preventDefault();

	$("input[name='storage_name']").val();
	$("input[name='storage_address']").val();
	$("input[name='car_park']:checked").val();
	$("input[name='storage_ticket']:checked").val();
	$("input[name='storage_price']").val();
	$("input[name='storage_covered']:checked").val();

});

$(".storage_close").click(function(event)
{
	event.preventDefault();

	$("input[name='storage_name']").val('');
	$("input[name='storage_address']").val('');
	$("input[name='storage_price']").val('');


});

$("#storage_btnSave").click(function (event) {
	event.preventDefault();
	var storage_name = $("input[name='storage_name']").val();
	var storage_address = $("input[name='storage_address']").val();
	var car_park = $("input[name='car_park']:checked").val();
	var storage_ticket = $("input[name='storage_ticket']:checked").val();
	var storage_price = $("input[name='storage_price']").val();
	var storage_covered = $("input[name='storage_covered']:checked").val();

	var formData = new FormData();
	formData.append('storage_name', storage_name);
	formData.append('storage_address', storage_address);
	formData.append('car_park', car_park);
	formData.append('storage_ticket', storage_ticket);
	formData.append('storage_price', storage_price);
	formData.append('storage_covered', storage_covered);


	$.ajax({
		url: _url.base_url + 'car_storage/insert_car_storage',
		type: "POST",
		data: formData,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$("#loading").hide();
			if (data.status == 200) {
				$('#successModal').modal('show');
				$('.msg_success').text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + 'car_storage/index_car_storage';
				}, 3000);
			} else {

				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
				setTimeout(function () {
					$('#errorModal').modal('hide');
				}, 3000);
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});






