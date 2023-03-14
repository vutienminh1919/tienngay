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
 $('#selectize_province').selectize({
        create: false,
        valueField: 'code_province',
        labelField: 'name',
        searchField: 'name',
        maxItems: 100,
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
        url :  _url.base_url + '/news/deletenews',
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

$("select[name='type_new']").on('change', function () {
	$("input[name='category_name_post']").val($("select[name='type_new'] option:selected").text());
});

$(".create_news").click(function(event) {
    event.preventDefault();
     var inputimg=$('input[name=image]');
        var imgToUpload=inputimg[0].files[0];
        var title_vi = $("input[name='title_vi']").val();
        var summary_vi = $("textarea[name='summary_vi']").val();
        var content_vi = CKEDITOR.instances.content_vi.getData();
        var title_en = $("input[name='title_en']").val();
        var summary_en = $("textarea[name='summary_en']").val();
        var content_en = CKEDITOR.instances.content_en.getData();
        var level = $("select[name='level']").val();
        var status = $("input[name='status']:checked").val();
		var name_type_new = $("input[name='category_name_post']").val();
        var type_new = $("select[name='type_new']").val();
        var limit = $("input[name='limit']").val();
        var period = $("input[name='period']").val();
        var province_text = $('#selectize_province').text();
        var page_title_seo = $("input[name='page_title_seo']").val();
        var description_tag_seo = $("textarea[name='description_tag_seo']").val();
        var keyword_tag_seo = $("input[name='keyword_tag_seo']").val();
        var url_seo = $("input[name='url_seo']").val();
        var province_data = $('#selectize_province').val();
        var province = [];
		if (province_data) {
			$("#selectize_province option:selected").each(function () {
				var province_code = $(this).val();
				province.push(province_code);
			});
		}
        var formData = new FormData();
        formData.append('image', imgToUpload);
        formData.append('title_vi', title_vi);
        formData.append('summary_vi', summary_vi);
        formData.append('content_vi', content_vi);
        formData.append('title_en', title_en);
        formData.append('summary_en', summary_en);
        formData.append('content_en', content_en);
        formData.append('level', level);
        formData.append('status', status);
        formData.append('name_type_new', name_type_new);
        formData.append('period', period);
        formData.append('province', province);
        formData.append('limit', limit);
        formData.append('type_new', type_new);
        formData.append('page_title_seo', page_title_seo);
        formData.append('description_tag_seo', description_tag_seo);
        formData.append('keyword_tag_seo', keyword_tag_seo);
        formData.append('url_seo', url_seo);
        
    console.log(formData);
       
    $.ajax({
        enctype: 'multipart/form-data',
        url :  _url.base_url + 'news/doAddNews',
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
                    window.location.href = _url.base_url + 'news/listnews';
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

$(".update_news").click(function(event) {
    event.preventDefault();
    var id = $("input[name='id_news']").val();
   var inputimg=$('input[name=image]');
        var imgToUpload=inputimg[0].files[0];
        var title_vi = $("input[name='title_vi']").val();
        var summary_vi = $("textarea[name='summary_vi']").val();
        var content_vi = CKEDITOR.instances.content_vi.getData();
        var title_en = $("input[name='title_en']").val();
        var summary_en = $("textarea[name='summary_en']").val();
        var content_en = CKEDITOR.instances.content_en.getData();
        var level = $("select[name='level']").val();
        var status = $("input[name='status']:checked").val();
		var name_type_new = $("input[name='category_name_post']").val();
        var type_new = $("select[name='type_new']").val();
        var limit = $("input[name='limit']").val();
        var province_text = $('#selectize_province').text();
        var period = $("input[name='period']").val();
		var page_title_seo = $("input[name='page_title_seo']").val();
		var description_tag_seo = $("textarea[name='description_tag_seo']").val();
		var keyword_tag_seo = $("input[name='keyword_tag_seo']").val();
		var url_seo = $("input[name='url_seo']").val();
		var province_data = $('#selectize_province').val();
		var province = [];
		if (province_data) {
			$("#selectize_province option:selected").each(function () {
				var province_code = $(this).val();
				province.push(province_code);
			});
		}
        var formData = new FormData();
        formData.append('image', imgToUpload);
        formData.append('title_vi', title_vi);
        formData.append('summary_vi', summary_vi);
        formData.append('content_vi', content_vi);
        formData.append('title_en', title_en);
        formData.append('summary_en', summary_en);
        formData.append('content_en', content_en);
        formData.append('level', level);
        formData.append('status', status);
        formData.append('name_type_new', name_type_new);
        formData.append('period', period);
        formData.append('province', province);
        formData.append('limit', limit);
        formData.append('type_new', type_new);
        formData.append('id', id);
		formData.append('page_title_seo', page_title_seo);
		formData.append('description_tag_seo', description_tag_seo);
		formData.append('keyword_tag_seo', keyword_tag_seo);
		formData.append('url_seo', url_seo);
    $.ajax({
        url :  _url.base_url + '/news/doUpdateNews',
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
                    window.location.href = _url.base_url + '/news/listnews';
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


