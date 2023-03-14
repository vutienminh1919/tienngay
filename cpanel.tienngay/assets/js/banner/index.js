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

$(".delete_banner").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/banner/deletebanner',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".banner_" + id).remove();
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

$("select[name='page']").on('change', function () {
	$("input[name='category_name_banner']").val($("select[name='page'] option:selected").text());
});

$(".create_banner").click(function(event) {
    event.preventDefault();
     var inputimg=$('input[name=image]');
        var imgToUpload=inputimg[0].files[0];
        var inputimg_mb=$('input[name=image_mb]');
        var imgToUpload_mb=inputimg_mb[0].files[0];
        var title_vi = $("input[name='title_vi']").val();
        var summary_vi = $("textarea[name='summary_vi']").val();
        var title_en = $("input[name='title_en']").val();
        var summary_en = $("textarea[name='summary_en']").val();
        var link = $("input[name='link']").val();
        var page = $("select[name='page']").val();
        var category_name_banner = $("input[name='category_name_banner']").val();
        var level = $("select[name='level']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('image', imgToUpload);
         formData.append('image_mb', imgToUpload_mb);
        formData.append('title_vi', title_vi);
        formData.append('summary_vi', summary_vi);
        formData.append('title_en', title_en);
        formData.append('summary_en', summary_en);
        formData.append('page', page);
        formData.append('category_name_banner', category_name_banner);
        formData.append('link', link);
        formData.append('level', level);
        formData.append('status', status);
        
    console.log(formData);
       
    $.ajax({
        enctype: 'multipart/form-data',
        url :  _url.base_url + 'banner/doAddBanner',
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
                    window.location.href = _url.base_url + 'banner/listbanner';
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

$(".update_banner").click(function(event) {
    event.preventDefault();
    var id = $("input[name='id_banner']").val();
   var inputimg=$('input[name=image]');
    var inputimg_mb=$('input[name=image_mb]');
        var imgToUpload_mb=inputimg_mb[0].files[0];
        var imgToUpload=inputimg[0].files[0];
        var title_vi = $("input[name='title_vi']").val();
        var summary_vi = $("textarea[name='summary_vi']").val();
        var title_en = $("input[name='title_en']").val();
        var summary_en = $("textarea[name='summary_en']").val();
        var link = $("input[name='link']").val();
        var page = $("select[name='page']").val();
		var category_name_banner = $("input[name='category_name_banner']").val();
        var level = $("select[name='level']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('image', imgToUpload);
         formData.append('image_mb', imgToUpload_mb);
        formData.append('title_vi', title_vi);
        formData.append('summary_vi', summary_vi);
        formData.append('title_en', title_en);
        formData.append('summary_en', summary_en);
        formData.append('page', page);
        formData.append('category_name_banner', category_name_banner);
        formData.append('level', level);
        formData.append('link', link);
        formData.append('status', status);
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/banner/doUpdateBanner',
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
                    window.location.href = _url.base_url + '/banner/listbanner';
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


