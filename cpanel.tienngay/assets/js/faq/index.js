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

$(".delete_faq").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/faq/deletefaq',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".faq_" + id).remove();
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


$(".create_faq").click(function(event) {
    event.preventDefault();
        var title_vi = $("input[name='title_vi']").val();
        var content_vi = CKEDITOR.instances.content_vi.getData();
        var title_en = $("input[name='title_en']").val();
        var content_en = CKEDITOR.instances.content_en.getData();
        var type = $("select[name='type_faq']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('title_vi', title_vi);
        formData.append('content_vi', content_vi);
        formData.append('title_en', title_en);
        formData.append('content_en', content_en);
        formData.append('type_faq', type);
        formData.append('status', status);
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'faq/doAddFaq',
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
                    window.location.href = _url.base_url + 'faq/listfaq';
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

$(".update_faq").click(function(event) {
    event.preventDefault();
        var id = $("input[name='id_faq']").val();
        var title_vi = $("input[name='title_vi']").val();
        var content_vi = CKEDITOR.instances.content_vi.getData();
        var title_en = $("input[name='title_en']").val();
        var content_en = CKEDITOR.instances.content_en.getData();
        var type = $("select[name='type_faq']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('title_vi', title_vi);
        formData.append('content_vi', content_vi);
        formData.append('title_en', title_en);
        formData.append('content_en', content_en);
        formData.append('type_faq', type);
        formData.append('status', status);
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/faq/doUpdateFaq',
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
                    window.location.href = _url.base_url + '/faq/listfaq';
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


