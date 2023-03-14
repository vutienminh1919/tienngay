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

$(".create_seo").click(function(event) {
	event.preventDefault();
	var page_name_seo = $("input[name='page_name_seo']").val();
	var page_title_seo = $("input[name='page_title_seo']").val();
	var description_tag_seo = $("textarea[name='description_tag_seo']").val();
	var keyword_tag_seo = $("input[name='keyword_tag_seo']").val();
	var url_seo = $("input[name='url_seo']").val();
	var status = $("input[name='status']:checked").val();

	var formData = new FormData();
	formData.append('page_name_seo', page_name_seo);
	formData.append('page_title_seo', page_title_seo);
	formData.append('description_tag_seo', description_tag_seo);
	formData.append('keyword_tag_seo', keyword_tag_seo);
	formData.append('url_seo', url_seo);
	formData.append('status', status);

	console.log(formData);

	$.ajax({
		url :  _url.base_url + 'seo/do_add_seo',
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
					window.location.href = _url.base_url + 'seo/seo_list';
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

$(".update_seo").click(function(event) {
	event.preventDefault();
	var id = $("input[name='id_seo']").val();
	var page_name_seo = $("input[name='page_name_seo']").val();
	var page_title_seo = $("input[name='page_title_seo']").val();
	var description_tag_seo = $("textarea[name='description_tag_seo']").val();
	var keyword_tag_seo = $("input[name='keyword_tag_seo']").val();
	var url_seo = $("input[name='url_seo']").val();
	var status = $("input[name='status']:checked").val();

	var formData = new FormData();
	formData.append('id', id);
	formData.append('page_name_seo', page_name_seo);
	formData.append('page_title_seo', page_title_seo);
	formData.append('description_tag_seo', description_tag_seo);
	formData.append('keyword_tag_seo', keyword_tag_seo);
	formData.append('url_seo', url_seo);
	formData.append('status', status);

	$.ajax({
		url :  _url.base_url + '/seo/do_update_seo',
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
					window.location.href = _url.base_url + 'seo/seo_list';
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


