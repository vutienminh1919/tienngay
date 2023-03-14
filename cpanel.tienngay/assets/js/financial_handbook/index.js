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
var select_district =  $('#selectize_province').selectize({
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
$(".delete_news").click(function(event) {
	event.preventDefault();
	var id = $(this).attr('data-id');
	var formData = {
		id: id
	};
	$.ajax({
		url :  _url.base_url + 'FinancialHandbook/deleteHandbook',
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){$("#loading").show();},
		success: function(data) {
			if (data.res) {
				$(".news_" + id).remove();
				$('#successModal').modal('show');
				$('.msg_success').text(data.message);
			} else {
				$('#errorModal').modal('show');
				$('.msg_error').text(data.message);
			}
		},
		error: function(data) {
			console.log(data);
			$("#loading").hide();
		}
	});

});


$(".create_handbook").click(function(event) {
	event.preventDefault();
	var inputimg=$('input[name=image]');
	var imgToUpload=inputimg[0].files[0];
	var title_vi = $("input[name='title_vi']").val();
	var benefit_vi = $("textarea[name='benefit_vi']").val();
	var fee_insurance_vi = $("textarea[name='fee_insurance_vi']").val();
	var type_finance_vi = $("#type_finance_vi").val();
	var summary_vi = $("textarea[name='summary_vi']").val();
	var content_vi = CKEDITOR.instances.content_vi.getData();
	var title_en = $("input[name='title_en']").val();
	var benefit_en = $("textarea[name='benefit_en']").val();
	var fee_insurance_en = $("textarea[name='fee_insurance_en']").val();
	var type_finance_en = $("select[name='type_finance_en']").val();
	var summary_en = $("textarea[name='summary_en']").val();
	var content_en = CKEDITOR.instances.content_en.getData();
	var level = $("select[name='level']").val();
	var status = $("input[name='status']:checked").val();
	var type_new = $("input[name='type_new']:checked").val();
	var limit = $("input[name='limit']").val();
	var province = $("select[name='province']").val();
	var period = $("input[name='period']").val();
	var province_text = $('#selectize_province').text();
	var page_title_seo = $("input[name='page_title_seo']").val();
	var description_tag_seo = $("textarea[name='description_tag_seo']").val();
	var keyword_tag_seo = $("input[name='keyword_tag_seo']").val();
	var url_seo = $("input[name='url_seo']").val();
	var formData = new FormData();
	formData.append('image', imgToUpload);
	formData.append('title_vi', title_vi);
	formData.append('benefit_vi', benefit_vi);
	formData.append('fee_insurance_vi', fee_insurance_vi);
	formData.append('type_finance_vi', type_finance_vi);
	formData.append('summary_vi', summary_vi);
	formData.append('content_vi', content_vi);
	formData.append('title_en', title_en);
	formData.append('benefit_en', benefit_en);
	formData.append('fee_insurance_en', fee_insurance_en);
	formData.append('type_finance_en', type_finance_en);
	formData.append('summary_en', summary_en);
	formData.append('content_en', content_en);
	formData.append('level', level);
	formData.append('status', status);
	formData.append('period', period);
	formData.append('province', province);
	formData.append('limit', limit);
	formData.append('province_text', province_text);
	formData.append('type_new', type_new);
	formData.append('page_title_seo', page_title_seo);
	formData.append('description_tag_seo', description_tag_seo);
	formData.append('keyword_tag_seo', keyword_tag_seo);
	formData.append('url_seo', url_seo);

	console.log(formData);

	$.ajax({
		enctype: 'multipart/form-data',
		url :  _url.base_url + 'FinancialHandbook/doAddHandbook',
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
					window.location.href = _url.base_url + 'FinancialHandbook/listHandbook';
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

$(".update_handbook").click(function(event) {
	event.preventDefault();
	var id = $("input[name='id_news']").val();
	var inputimg=$('input[name=image]');
	var imgToUpload=inputimg[0].files[0];
	var title_vi = $("input[name='title_vi']").val();
	var benefit_vi = $("textarea[name='benefit_vi']").val();
	var fee_insurance_vi = $("textarea[name='fee_insurance_vi']").val();
	var type_finance_vi = $("#type_finance_vi").val();
	var summary_vi = $("textarea[name='summary_vi']").val();
	var content_vi = CKEDITOR.instances.content_vi.getData();
	var title_en = $("input[name='title_en']").val();
	var benefit_en = $("textarea[name='benefit_en']").val();
	var fee_insurance_en = $("textarea[name='fee_insurance_en']").val();
	var type_finance_en = $("select[name='type_finance_en']").val();
	var summary_en = $("textarea[name='summary_en']").val();
	var content_en = CKEDITOR.instances.content_en.getData();
	var level = $("select[name='level']").val();
	var status = $("input[name='status']:checked").val();
	var type_new = $("input[name='type_new']:checked").val();
	var limit = $("input[name='limit']").val();
	var province = $("select[name='province']").val();
	var province_text = $('#selectize_province').text();
	var period = $("input[name='period']").val();
	var page_title_seo = $("input[name='page_title_seo']").val();
	var description_tag_seo = $("textarea[name='description_tag_seo']").val();
	var keyword_tag_seo = $("input[name='keyword_tag_seo']").val();
	var url_seo = $("input[name='url_seo']").val();
	var formData = new FormData();
	formData.append('image', imgToUpload);
	formData.append('title_vi', title_vi);
	formData.append('benefit_vi', benefit_vi);
	formData.append('fee_insurance_vi', fee_insurance_vi);
	formData.append('type_finance_vi', type_finance_vi);
	formData.append('summary_vi', summary_vi);
	formData.append('content_vi', content_vi);
	formData.append('title_en', title_en);
	formData.append('benefit_en', benefit_en);
	formData.append('fee_insurance_en', fee_insurance_en);
	formData.append('type_finance_en', type_finance_en);
	formData.append('summary_en', summary_en);
	formData.append('content_en', content_en);
	formData.append('level', level);
	formData.append('status', status);
	formData.append('period', period);
	formData.append('province', province);
	formData.append('limit', limit);
	formData.append('type_new', type_new);
	formData.append('province_text', province_text);
	formData.append('id', id);
	formData.append('page_title_seo', page_title_seo);
	formData.append('description_tag_seo', description_tag_seo);
	formData.append('keyword_tag_seo', keyword_tag_seo);
	formData.append('url_seo', url_seo);
	$.ajax({
		url :  _url.base_url + 'FinancialHandbook/doUpdateHandbook',
		type: "POST",
		enctype: 'multipart/form-data',
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
					window.location.href = _url.base_url + 'FinancialHandbook/listHandbook';
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


